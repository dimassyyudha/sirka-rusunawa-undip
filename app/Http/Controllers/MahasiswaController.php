<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Occupant;
use App\Models\PaymentTransaction;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    private function getOccupant()
    {
        $occupant = Occupant::with([
            'room.floor.building',
            'room.photos',
            'reservation.occupancyPeriod',
        ])
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->latest()
            ->first();

        if (
            $occupant &&
            $occupant->end_date &&
            now()->startOfDay()->gt(
                \Carbon\Carbon::parse($occupant->end_date)->startOfDay()
            )
        ) {

            $occupant->update([
                'status' => 'ended',
                'room_id' => null,
            ]);

            auth()->user()->studentProfile?->update([
                'status_mahasiswa' => 'tidak_penghuni',
                'room_id' => null,
            ]);

            return null;
        }

        return $occupant;
    }

    private function syncExpiredTransactions()
    {
        if (!Schema::hasTable('payment_transactions')) {
            return;
        }

        PaymentTransaction::with(['invoice', 'Reservation'])
            ->where('user_id', auth()->id())
            ->where('transaction_status', 'pending')
            ->whereNotNull('expired_at')
            ->where('expired_at', '<=', now())
            ->get()
            ->each(function ($transaction) {
                $transaction->update([
                    'transaction_status' => 'expire',
                ]);

                $transaction->invoice?->update([
                    'status' => 'expired',
                ]);

                $transaction->Reservation?->update([
                    'status' => 'expired',
                ]);
            });
    }

    private function getReservations()
    {
        $this->syncExpiredTransactions();

        return Reservation::with([
            'room.floor.building',
            'room.photos',
            'paymentTransactions',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }



    // private function getReservations()
    // {
    //     return Reservation::with([
    //         'room.floor.building',
    //         'room.photos',
    //     ])
    //         ->where('user_id', auth()->id())
    //         ->latest()
    //         ->get();
    // }

    private function getInvoices()
    {
        if (!Schema::hasTable('invoices')) {
            return collect();
        }

        return Invoice::with([
            'Reservation.room.floor.building',
            'room.floor.building',
            'paymentTransactions',
            'user',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    private function getPayments()
    {
        if (!Schema::hasTable('payment_transactions')) {
            return collect();
        }

        return Reservation::with([
            'room.floor.building',
            'room.photos',
            'paymentTransactions',
        ])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();
    }

    public function mahasiswa()
    {
        $occupant = $this->getOccupant();
        $Reservations = $this->getReservations();
        $reservations = $this->getReservations();
        $invoices = $this->getInvoices();

        $roommates = collect();

        if ($occupant?->room_id) {
            $roommates = Occupant::with([
                'user.studentProfile',
            ])
                ->where('room_id', $occupant->room_id)
                ->where('status', 'active')
                ->where('user_id', '!=', auth()->id())
                ->get();
        }

        $pendingReservations = $Reservations->filter(function ($reservation) {

            $transaction = $reservation->invoices
                ->flatMap(function ($invoice) {
                    return $invoice->paymentTransactions;
                })
                ->sortByDesc('created_at')
                ->firstWhere('transaction_status', 'pending');

            return $reservation->status === 'pending'
                && $transaction
                && $transaction->expired_at
                && now()->lt($transaction->expired_at);
        });
        $unpaidInvoices = $invoices->whereIn('status', [
            'pending',
            'unpaid',
        ]);
        // $activeInvoice = Invoice::with('paymentTransactions')
        //     ->where('user_id', auth()->id())
        //     ->get()
        //     ->first(function ($invoice) {

        //         $trx = $invoice->paymentTransactions
        //             ->sortByDesc('created_at')
        //             ->first();

        //         return !in_array(
        //             $trx?->transaction_status,
        //             ['settlement']
        //         );
        //     });
        $activeInvoices = Invoice::with('paymentTransactions')
            ->where('user_id', auth()->id())
            ->whereIn('status', [
                'pending',
                'unpaid',
            ])
            ->orderBy('due_at')
            ->get();

        $activeInvoiceTotal = $activeInvoices->sum('amount');
        return view('pages.mahasiswa.dashboard', [
            'occupant' => $occupant,
            'roommates' => $roommates,
            'reservations' => $reservations,
            // 'Reservations' => $Reservations,
            'pendingReservations' => $pendingReservations,
            'invoices' => $invoices,
            'unpaidInvoices' => $unpaidInvoices,
            'activeInvoiceTotal' => $unpaidInvoices->sum('amount'),
            'reservationCount' => $Reservations->count(),
            'activeInvoices' => $activeInvoices,
            'activeInvoiceTotal' => $activeInvoiceTotal,
            'activeReservation' => $Reservations
                ->whereIn('status', [
                    'pending',
                    'paid',
                    'approved',
                    'active',
                ])
                ->first(),
        ]);
    }

    public function kamarSaya()
    {
        $occupant = $this->getOccupant();
        $room = $occupant?->room;
        $roommates = collect();
        if ($occupant?->room_id) {
            $roommates = Occupant::with([
                'user.studentProfile',
            ])
                ->where('room_id', $occupant->room_id)
                ->where('status', 'active')
                ->where('user_id', '!=', auth()->id())
                ->get();
        }

        return view('pages.mahasiswa.kamar-saya', [
            'occupant' => $occupant,
            'room' => $room,
            'roommates' => $roommates,
            'floor' => $room?->floor,
            'building' => $room?->floor?->building,
            'photos' => $room?->photos ?? collect(),
            'roomPhotos' => $room?->photos ?? collect(),
        ]);
    }

    public function reservasi()
    {
        $occupant = $this->getOccupant();
        $Reservations = $this->getReservations();

        return view('pages.mahasiswa.reservasi.reservasi', [
            'occupant' => $occupant,
            'reservations' => $Reservations,
            'pendingReservations' => $Reservations->whereIn('status', ['pending']),
            'approvedReservations' => $Reservations->whereIn('status', [
                'paid',
                'approved',
                'active',
            ]),
            'rejectedReservations' => $Reservations->whereIn('status', [
                'rejected',
                'expired',
                'cancelled',
            ]),
        ]);
    }

    public function pembayaran()
    {
        $occupant = $this->getOccupant();
        $invoices = $this->getInvoices();
        $payments = $this->getPayments();

        $unpaidInvoices = $invoices->whereIn('status', [
            'pending',
            'unpaid',
        ]);

        $paidInvoices = $invoices->whereIn('status', [
            'paid',
            'settlement',
        ]);

        return view('pages.mahasiswa.pembayaran', [
            'occupant' => $occupant,
            'invoices' => $invoices,
            'payments' => $payments,
            'transactions' => $payments,
            'unpaidInvoices' => $unpaidInvoices,
            'paidInvoices' => $paidInvoices,
            'activeInvoiceTotal' => $unpaidInvoices->sum('amount'),
            'paidInvoiceTotal' => $paidInvoices->sum('amount'),
        ]);
    }

    // public function perpanjang()
    // {
    //     $occupant = $this->getOccupant();

    //     return view('pages.mahasiswa.perpanjang', [
    //         'occupant' => $occupant,
    //         'room' => $occupant?->room,
    //         'canExtend' => $occupant !== null,
    //         'currentEndDate' => $occupant?->end_date,
    //         'extensionOptions' => [
    //             1 => '1 Bulan',
    //             3 => '3 Bulan',
    //             6 => '6 Bulan',
    //             12 => '12 Bulan',
    //         ],
    //     ]);
    // }

    // public function pindahKamar()
    // {
    //     $occupant = $this->getOccupant();
    //     $currentRoom = $occupant?->room;

    //     $availableRooms = Room::with([
    //         'floor.building',
    //         'photos',
    //     ])
    //         ->where('status', 'tersedia')
    //         ->when($currentRoom, function ($query) use ($currentRoom) {
    //             $query->where('id', '!=', $currentRoom->id);
    //         })
    //         ->get()
    //         ->filter(function ($room) {
    //             $capacity = (int) ($room->floor?->room_capacity ?? 2);
    //             return (int) $room->occupied < $capacity;
    //         })
    //         ->values();

    //     return view('pages.mahasiswa.pindah-kamar', [
    //         'occupant' => $occupant,
    //         'currentRoom' => $currentRoom,
    //         'availableRooms' => $availableRooms,
    //     ]);
    // }

    // public function akhiriKontrak()
    // {
    //     $occupant = $this->getOccupant();
    //     $invoices = $this->getInvoices();

    //     $unpaidInvoices = $invoices->whereIn('status', [
    //         'pending',
    //         'unpaid',
    //     ]);

    //     return view('pages.mahasiswa.akhiri-kontrak', [
    //         'occupant' => $occupant,
    //         'room' => $occupant?->room,
    //         'unpaidInvoices' => $unpaidInvoices,
    //         'hasUnpaidInvoice' => $unpaidInvoices->count() > 0,
    //         'activeInvoiceTotal' => $unpaidInvoices->sum('amount'),
    //     ]);
    // }

    public function profil()
    {
        $profile = auth()->user()
            ->studentProfile;

        return view('pages.mahasiswa.profile.index', compact('profile'));
    }

    public function editProfil()
    {
        $profile = auth()->user()
            ->studentProfile;

        return view('pages.mahasiswa.profile.edit', compact('profile'));
    }



    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'profile_photo_file' => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        $user->name = $validated['name'];

        if ($request->hasFile('profile_photo_file')) {

            if (
                $user->profile_photo &&
                Storage::disk('public')->exists($user->profile_photo)
            ) {

                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo_file')
                ->store('profile-photos', 'public');

            $user->profile_photo = $path;
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function review()
    {
        $occupant = $this->getOccupant();

        return view('pages.mahasiswa.review', [
            'occupant' => $occupant,
            'room' => $occupant?->room,
        ]);
    }
}
