<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceReminderMail;
use App\Models\Building;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function checkForm()
    {
        return view('pages.invoice.check');
    }

    public function check(Request $request)
    {
        $request->validate([
            'invoice_number' => 'required|string',
        ]);

        $invoice = Invoice::with([
            'Reservation.room.floor.building',
            'paymentTransactions',
            'user',
        ])
            ->where('invoice_number', strtoupper($request->invoice_number))
            ->first();

        if (!$invoice) {
            return back()
                ->with('error', 'Nomor invoice tidak ditemukan.')
                ->withInput();
        }

        return view('pages.invoice.result', compact('invoice'));
    }

    public function show(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        $invoice->load([
            'Reservation.room.floor.building',
            'paymentTransactions',
            'user',
        ]);

        return view('pages.invoice.show', compact('invoice'));
    }
    public function pay(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $snapToken = \Midtrans\Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $invoice->invoice_number . now()->timestamp,
                'gross_amount' => (int) $invoice->amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ]);

        return view('pages.mahasiswa.pembayaran.midtrans', [
            'invoice' => $invoice,
            'snapToken' => $snapToken,
            'midtransClientKey' => config('midtrans.client_key'),
        ]);
    }

    public function finish(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        $invoice->load([
            'reservation.occupancyPeriod',
            'reservation.room',
            'user.studentProfile',
        ]);

        $reservation = $invoice->reservation;
        $period = $reservation?->occupancyPeriod;
        $profile = $invoice->user?->studentProfile;

        $invoice->update([
            'status' => 'paid',
        ]);

        if ($reservation && $period && $profile) {
            $profile->update([
                'status_mahasiswa' => 'penghuni',
                'room_id' => $reservation->room_id,
            ]);

            $oldOccupant = \App\Models\Occupant::where('user_id', $invoice->user_id)
                ->where('status', 'active')
                ->first();

            \App\Models\Occupant::updateOrCreate(
                ['user_id' => $invoice->user_id],
                [
                    'room_id' => $reservation->room_id,
                    'reservation_id' => $reservation->reservation_id,
                    'status' => 'active',

                    // tanggal masuk tetap tanggal pertama kali masuk
                    'start_date' => $oldOccupant?->start_date ?? $period->lease_start_date,

                    // yang berubah hanya akhir sewa
                    'end_date' => $period->lease_end_date,
                ]
            );
        }

        return redirect()
            ->route('mahasiswa.kamar-saya')
            ->with('success', 'Pembayaran berhasil. Masa hunian kamu telah diperbarui.');
    }
    // reminder
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);

        $query = Invoice::with([
            'user.studentProfile',
            'reservation.room.floor.building',
            'paymentTransactions',
        ]);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('jalur')) {
            $query->whereHas('user.studentProfile', function ($q) use ($request) {
                $q->where('jalur_pembiayaan', $request->jalur);
            });
        }

        if ($request->filled('gedung')) {
            $query->whereHas('reservation.room.floor.building', function ($q) use ($request) {
                $q->where('building_id', $request->gedung);
            });
        }

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('invoice_number', 'like', "%$search%")

                    ->orWhereHas('user', function ($qq) use ($search) {
                        $qq->where('name', 'like', "%$search%");
                    })

                    ->orWhereHas('user.studentProfile', function ($qq) use ($search) {
                        $qq->where('nim', 'like', "%$search%");
                    });
            });
        }

        $invoices = $query
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $buildings = Building::orderBy('name')->get();

        return view(
            'pages.admin.invoices.index',
            compact('invoices', 'buildings')
        );
    }

    public function sendReminder(
        Invoice $invoice
    ) {
        Mail::to(
            $invoice->user->email
        )->send(
            new InvoiceReminderMail(
                $invoice
            )
        );

        $invoice->update([
            'last_reminder_at' => now()
        ]);

        return back()->with(
            'success',
            'Reminder berhasil dikirim.'
        );
    }

    public function sendReminderAll()
    {
        $invoices = Invoice::with('user')

            ->whereIn('status', [
                'pending',
                'unpaid',
            ])

            ->get();

        foreach ($invoices as $invoice) {

            Mail::to(
                $invoice->user->email
            )->queue(
                new InvoiceReminderMail(
                    $invoice
                )
            );

            $invoice->update([
                'last_reminder_at' => now()
            ]);
        }

        return back()->with(
            'success',
            'Reminder massal berhasil dikirim.'
        );
    }
}
