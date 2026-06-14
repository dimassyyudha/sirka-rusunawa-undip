<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Invoice;
use App\Models\OccupancyPeriod;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FinancialController extends Controller
{
    public function index(Request $request)
    {
        $periods = OccupancyPeriod::query()
            ->orderByDesc('academic_year_start')
            ->orderByRaw("FIELD(semester_type, 'ganjil', 'genap')")
            ->get();

        $selectedPeriod = null;

        if ($request->filled('occupancy_period_id')) {
            $selectedPeriod = OccupancyPeriod::find($request->occupancy_period_id);
        }

        $startDate = $selectedPeriod
            ? $selectedPeriod->registration_start_date->copy()->startOfDay()
            : ($request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null);

        $endDate = $selectedPeriod
            ? $selectedPeriod->registration_end_date->copy()->endOfDay()
            : ($request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null);

        $gedung = $request->gedung;

        $buildings = Building::where('is_active', true)
            ->orderBy('code')
            ->get();

        $invoiceQuery = Invoice::query()
            ->with([
                'user',
                'Reservation.room.floor.building',
                'reservation.room.floor.building',
                'room.floor.building',
                'paymentTransactions',
            ])
            ->whereIn('status', ['paid', 'lunas', 'settlement'])
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('created_at', '<=', $endDate))
            ->when($selectedPeriod, function ($q) use ($selectedPeriod) {
                $q->where(function ($query) use ($selectedPeriod) {
                    $query->whereHas('reservation', function ($reservationQuery) use ($selectedPeriod) {
                        $reservationQuery->where('occupancy_period_id', $selectedPeriod->id);
                    })
                        ->orWhereBetween('created_at', [
                            $selectedPeriod->registration_start_date->copy()->startOfDay(),
                            $selectedPeriod->registration_end_date->copy()->endOfDay(),
                        ]);
                });
            })
            ->when($gedung, function ($q) use ($gedung) {
                $q->where(function ($query) use ($gedung) {
                    $query->whereHas('Reservation.room.floor.building', function ($b) use ($gedung) {
                        $b->where('code', $gedung);
                    })
                        ->orWhereHas('reservation.room.floor.building', function ($b) use ($gedung) {
                            $b->where('code', $gedung);
                        })
                        ->orWhereHas('room.floor.building', function ($b) use ($gedung) {
                            $b->where('code', $gedung);
                        });
                });
            })
            ->latest();

        $invoices = (clone $invoiceQuery)
            ->paginate(10)
            ->withQueryString();

        $totalPendapatan = (clone $invoiceQuery)->sum('amount');

        $totalTransaksi = (clone $invoiceQuery)->count();

        $paidInvoiceIds = (clone $invoiceQuery)->pluck('id');

        $incomeByBuilding = Building::query()
            ->where('is_active', true)
            ->orderBy('code')
            ->get()
            ->map(function ($building) use ($paidInvoiceIds) {
                $income = Invoice::query()
                    ->whereIn('id', $paidInvoiceIds)
                    ->where(function ($query) use ($building) {
                        $query->whereHas('Reservation.room.floor.building', function ($q) use ($building) {
                            $q->where('buildings.id', $building->id);
                        })
                            ->orWhereHas('reservation.room.floor.building', function ($q) use ($building) {
                                $q->where('buildings.id', $building->id);
                            })
                            ->orWhereHas('room.floor.building', function ($q) use ($building) {
                                $q->where('buildings.id', $building->id);
                            });
                    })
                    ->sum('amount');

                return (object) [
                    'gedung' => $building->code,
                    'nama_gedung' => $building->name,
                    'income' => $income,
                ];
            });

        return view('pages.admin.financial.index', [
            'Reservations' => $invoices,
            'invoices' => $invoices,
            'buildings' => $buildings,
            'periods' => $periods,
            'selectedPeriod' => $selectedPeriod,
            'incomeByBuilding' => $incomeByBuilding,
            'totalPendapatan' => $totalPendapatan,
            'totalTransaksi' => $totalTransaksi,
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $selectedPeriod = null;

        if ($request->filled('occupancy_period_id')) {
            $selectedPeriod = OccupancyPeriod::find($request->occupancy_period_id);
        }

        $startDate = $selectedPeriod
            ? $selectedPeriod->registration_start_date->copy()->startOfDay()
            : ($request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null);

        $endDate = $selectedPeriod
            ? $selectedPeriod->registration_end_date->copy()->endOfDay()
            : ($request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null);

        $gedung = $request->gedung;

        $invoices = Invoice::query()
            ->with([
                'user',
                'Reservation.room.floor.building',
                'reservation.room.floor.building',
                'room.floor.building',
                'paymentTransactions',
            ])
            ->whereIn('status', ['paid', 'lunas', 'settlement'])
            ->when($startDate, fn($q) => $q->where('created_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('created_at', '<=', $endDate))
            ->when($selectedPeriod, function ($q) use ($selectedPeriod) {
                $q->where(function ($query) use ($selectedPeriod) {
                    $query->whereHas('reservation', function ($reservationQuery) use ($selectedPeriod) {
                        $reservationQuery->where('occupancy_period_id', $selectedPeriod->id);
                    })
                        ->orWhereBetween('created_at', [
                            $selectedPeriod->registration_start_date->copy()->startOfDay(),
                            $selectedPeriod->registration_end_date->copy()->endOfDay(),
                        ]);
                });
            })
            ->when($gedung, function ($q) use ($gedung) {
                $q->where(function ($query) use ($gedung) {
                    $query->whereHas('Reservation.room.floor.building', function ($b) use ($gedung) {
                        $b->where('code', $gedung);
                    })
                        ->orWhereHas('reservation.room.floor.building', function ($b) use ($gedung) {
                            $b->where('code', $gedung);
                        })
                        ->orWhereHas('room.floor.building', function ($b) use ($gedung) {
                            $b->where('code', $gedung);
                        });
                });
            })
            ->latest()
            ->get();

        $fileName = 'laporan-keuangan-' . now()->format('YmdHis') . '.csv';

        return response()->streamDownload(function () use ($invoices) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Tanggal WIB',
                'Nomor Invoice',
                'Order ID',
                'Nama',
                'Gedung',
                'Kamar',
                'Status Invoice',
                'Total Pembayaran',
            ]);

            foreach ($invoices as $invoice) {
                $Reservation = $invoice->Reservation;
                $reservation = $invoice->reservation;

                $room = $Reservation?->room
                    ?? $reservation?->room
                    ?? $invoice->room;

                $transaction = $invoice->paymentTransactions
                    ? $invoice->paymentTransactions->sortByDesc('created_at')->first()
                    : null;

                fputcsv($handle, [
                    $invoice->created_at
                        ? $invoice->created_at->timezone('Asia/Jakarta')->format('d/m/Y H:i') . ' WIB'
                        : '-',
                    $invoice->invoice_number,
                    $transaction?->order_id ?? '-',
                    $Reservation?->guest_name ?? $invoice->user?->name ?? '-',
                    $room?->floor?->building?->name ?? '-',
                    $room?->kode_kamar ?? '-',
                    $invoice->status,
                    $invoice->amount,
                ]);
            }

            fclose($handle);
        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}
