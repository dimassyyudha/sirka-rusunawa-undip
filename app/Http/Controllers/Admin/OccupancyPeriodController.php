<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\OccupancyPeriod;
use App\Models\Occupant;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OccupancyPeriodController extends Controller
{
    public function index()
    {
        $periods = OccupancyPeriod::latest()->paginate(10);

        return view('pages.admin.occupancy-periods.index', compact('periods'));
    }

    public function create()
    {
        $currentYear = now()->year;

        return view('pages.admin.occupancy-periods.create', compact('currentYear'));
    }

    public function store(Request $request)
    {
        $currentYear = now()->year;

        $validated = $request->validate([
            'semester_type' => 'required|in:ganjil,genap',
            'academic_year_start' => 'required|integer|in:' . $currentYear,
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after_or_equal:registration_start_date',
            'payment_due_date' => 'nullable|date|after_or_equal:registration_start_date',
            'notes' => 'nullable|string',
        ]);

        $academicYearStart = (int) $validated['academic_year_start'];
        $academicYearEnd = $academicYearStart + 1;

        if ($validated['semester_type'] === 'ganjil') {
            $semesterName = 'Semester Ganjil';
            $leaseStartDate = $academicYearStart . '-07-01';
            $leaseEndDate = $academicYearStart . '-12-31';
        } else {
            $semesterName = 'Semester Genap';
            $leaseStartDate = $academicYearEnd . '-01-01';
            $leaseEndDate = $academicYearEnd . '-06-30';
        }

        OccupancyPeriod::create([
            'name' => 'Registrasi Ulang ' . $semesterName . ' ' . $academicYearStart . '/' . $academicYearEnd,
            'semester_type' => $validated['semester_type'],
            'academic_year_start' => $academicYearStart,
            'academic_year_end' => $academicYearEnd,
            'registration_start_date' => $validated['registration_start_date'],
            'registration_end_date' => $validated['registration_end_date'],
            'lease_start_date' => $leaseStartDate,
            'lease_end_date' => $leaseEndDate,
            'payment_due_date' => $validated['payment_due_date'] ?? null,
            'status' => 'upcoming',
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.occupancy-periods.index')
            ->with('success', 'Periode registrasi ulang berhasil dibuat.');
    }


    public function show(OccupancyPeriod $occupancyPeriod)
    {
        $periods = OccupancyPeriod::query()
            ->orderByDesc('academic_year_start')
            ->orderByRaw("FIELD(semester_type, 'ganjil', 'genap')")
            ->get();

        if (request()->filled('period_id')) {
            $selectedPeriod = OccupancyPeriod::findOrFail(request('period_id'));

            return redirect()
                ->route('admin.occupancy-periods.show', $selectedPeriod);
        }

        $reservations = $occupancyPeriod->reservations()
            ->with([
                'user.studentProfile',
                'room.floor.building',
                'previousRoom.floor.building',
            ])
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $summary = [
            'extension' => $occupancyPeriod->reservations()->where('reservation_type', 'extension')->count(),
            'transfer' => $occupancyPeriod->reservations()->where('reservation_type', 'transfer')->count(),
            'checkout' => $occupancyPeriod->reservations()->where('reservation_type', 'checkout')->count(),
            'pending' => $occupancyPeriod->reservations()->where('status', 'pending')->count(),
            'approved' => $occupancyPeriod->reservations()->where('status', 'approved')->count(),
            'rejected' => $occupancyPeriod->reservations()->where('status', 'rejected')->count(),
        ];

        return view('pages.admin.occupancy-periods.show', compact(
            'occupancyPeriod',
            'periods',
            'reservations',
            'summary'
        ));
    }

    // public function edit(OccupancyPeriod $occupancyPeriod)
    // {
    //     $currentYear = now()->year;

    //     return view(
    //         'pages.admin.occupancy-periods.edit',
    //         compact(
    //             'occupancyPeriod',
    //             'currentYear'
    //         )
    //     );
    // }


    public function edit(OccupancyPeriod $occupancyPeriod)
    {
        $currentYear = now()->year;

        return view(
            'pages.admin.occupancy-periods.edit',
            compact('occupancyPeriod', 'currentYear')
        );
    }

    public function update(Request $request, OccupancyPeriod $occupancyPeriod)
    {
        $currentYear = now()->year;

        $validated = $request->validate([
            'semester_type' => 'required|in:ganjil,genap',

            'academic_year_start' => 'required|integer|in:' . $currentYear,

            'registration_start_date' => 'required|date',

            'registration_end_date' =>
            'required|date|after_or_equal:registration_start_date',

            'payment_due_date' =>
            'nullable|date|after_or_equal:registration_start_date',

            'status' => 'required|in:upcoming,open,closed',

            'notes' => 'nullable|string',
        ]);

        $academicYearStart = (int) $validated['academic_year_start'];
        $academicYearEnd = $academicYearStart + 1;

        /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE MASA HUNIAN
    |--------------------------------------------------------------------------
    */

        if ($validated['semester_type'] === 'ganjil') {

            $semesterName = 'Semester Ganjil';

            $leaseStartDate = $academicYearStart . '-07-01';
            $leaseEndDate = $academicYearStart . '-12-31';
        } else {

            $semesterName = 'Semester Genap';

            $leaseStartDate = $academicYearEnd . '-01-01';
            $leaseEndDate = $academicYearEnd . '-06-30';
        }

        $occupancyPeriod->update([

            'name' => 'Registrasi Ulang '
                . $semesterName
                . ' '
                . $academicYearStart
                . '/'
                . $academicYearEnd,

            'semester_type' => $validated['semester_type'],

            'academic_year_start' => $academicYearStart,
            'academic_year_end' => $academicYearEnd,

            'registration_start_date' =>
            $validated['registration_start_date'],

            'registration_end_date' =>
            $validated['registration_end_date'],

            'lease_start_date' => $leaseStartDate,
            'lease_end_date' => $leaseEndDate,

            'payment_due_date' =>
            $validated['payment_due_date'] ?? null,

            'status' => $validated['status'],

            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()
            ->route('admin.occupancy-periods.index')
            ->with(
                'success',
                'Periode registrasi ulang berhasil diperbarui.'
            );
    }

    public function destroy(OccupancyPeriod $occupancyPeriod)
    {
        $occupancyPeriod->delete();

        return back()->with('success', 'Periode berhasil dihapus.');
    }
    public function activeRegistration()
    {
        $period = OccupancyPeriod::query()
            ->where('status', 'open')
            ->latest()
            ->first();

        if (!$period) {
            $period = OccupancyPeriod::query()
                ->latest()
                ->get()
                ->first(function ($item) {
                    return $item->computed_status === 'open';
                });
        }

        if (!$period) {
            return view('pages.admin.occupancy-periods.no-active');
        }

        return redirect()
            ->route('admin.occupancy-periods.show', $period);
    }
    public function bulkDelete(Request $request)
    {
        $ids = $request->ids ?? [];

        if (empty($ids)) {
            return back()->with('error', 'Pilih data terlebih dahulu.');
        }

        OccupancyPeriod::whereIn('id', $ids)->delete();

        return back()->with('success', 'Periode berhasil dihapus.');
    }

    public function openRegistration(OccupancyPeriod $occupancyPeriod)
    {
        OccupancyPeriod::query()
            ->where('id', '!=', $occupancyPeriod->id)
            ->where('status', 'open')
            ->update([
                'status' => 'upcoming',
            ]);

        $occupancyPeriod->update([
            'status' => 'open',
        ]);

        return back()->with(
            'success',
            'Registrasi ulang berhasil dibuka.'
        );
    }


    public function closeRegistration(OccupancyPeriod $occupancyPeriod)
    {
        if ($occupancyPeriod->computed_status !== 'open') {
            return back()->with('error', 'Periode hanya dapat ditutup jika registrasi sedang dibuka.');
        }

        DB::transaction(function () use ($occupancyPeriod) {
            $approvedReservations = $occupancyPeriod->reservations()
                ->with([
                    'user.studentProfile',
                    'room.floor',
                    'previousRoom',
                ])
                ->where('status', 'approved')
                ->get();

            foreach ($approvedReservations as $reservation) {
                $profile = $reservation->user?->studentProfile;

                if (!$profile) {
                    continue;
                }

                if ($reservation->reservation_type === 'extension') {
                    if (!$this->hasPaidInvoice($reservation)) {
                        continue;
                    }

                    $profile->update([
                        'status_mahasiswa' => 'penghuni',
                        'status_mahasiswa' => 'penghuni',
                        'room_id' => $reservation->room_id,
                    ]);

                    Occupant::updateOrCreate(
                        ['user_id' => $reservation->user_id],
                        [
                            'room_id' => $reservation->room_id,
                            'reservation_id' => $reservation->id,
                            'status' => 'active',
                            'end_date' => $reservation->end_date,
                        ]
                    );
                }

                if ($reservation->reservation_type === 'transfer') {
                    if (!$this->hasPaidInvoice($reservation)) {
                        continue;
                    }

                    $activeOccupant = Occupant::where('user_id', $reservation->user_id)
                        ->where('status', 'active')
                        ->first();

                    $oldRoomId = $reservation->previous_room_id ?: $activeOccupant?->room_id;
                    $newRoomId = $reservation->room_id;

                    if ($oldRoomId && $newRoomId && $oldRoomId !== $newRoomId) {
                        DB::table('rooms')
                            ->where('id', $oldRoomId)
                            ->where('occupied', '>', 0)
                            ->decrement('occupied');

                        DB::table('rooms')
                            ->where('id', $newRoomId)
                            ->increment('occupied');
                    }

                    $profile->update([
                        'status_mahasiswa' => 'penghuni',
                        'status_mahasiswa' => 'penghuni',
                        'room_id' => $newRoomId,
                    ]);

                    Occupant::updateOrCreate(
                        ['user_id' => $reservation->user_id],
                        [
                            'room_id' => $newRoomId,
                            'reservation_id' => $reservation->id,
                            'status' => 'active',
                            'start_date' => $activeOccupant?->start_date ?? $reservation->start_date,
                            'end_date' => $reservation->end_date,
                        ]
                    );
                }

                if ($reservation->reservation_type === 'checkout') {
                    // $activeOccupant = Occupant::where('user_id', $reservation->user_id)
                    //     ->where('status', 'active')
                    //     ->first();
                    $activeOccupant = Occupant::where('user_id', $reservation->user_id)
                        ->where('status', 'active')
                        ->first();

                    Occupant::updateOrCreate(
                        ['user_id' => $reservation->user_id],
                        [
                            'room_id' => $reservation->room_id,
                            'reservation_id' => $reservation->id,
                            'status' => 'active',
                            'start_date' => $activeOccupant?->start_date ?? $reservation->start_date,
                            'end_date' => $reservation->end_date,
                        ]
                    );
                    $oldRoomId = $reservation->previous_room_id
                        ?: $reservation->room_id
                        ?: $activeOccupant?->room_id;

                    if ($oldRoomId) {
                        DB::table('rooms')
                            ->where('id', $oldRoomId)
                            ->where('occupied', '>', 0)
                            ->decrement('occupied');
                    }

                    $profile->update([
                        'status_mahasiswa' => 'tidak_penghuni',
                        'status_mahasiswa' => 'bukan_penghuni',
                        'room_id' => null,
                    ]);



                    Occupant::where('user_id', $reservation->user_id)
                        ->where('status', 'active')
                        ->update([
                            'status' => 'inactive',
                            'room_id' => null,
                            'reservation_id' => $reservation->id,
                            'end_date' => $reservation->end_date ?? now(),
                        ]);
                }
            }

            $occupancyPeriod->update([
                'status' => 'close',
            ]);
        });

        return back()->with(
            'success',
            'Periode registrasi ulang berhasil ditutup dan data hunian telah diperbarui.'
        );
    }

    public function approveReservation(Reservation $reservation)
    {
        $reservation->load([
            'occupancyPeriod',
            'room.floor',
        ]);

        if ($reservation->occupancyPeriod?->status !== 'open') {
            return back()->with('error', 'Pengajuan hanya bisa disetujui saat periode registrasi masih dibuka.');
        }

        if (now()->startOfDay()->gt($reservation->occupancyPeriod->registration_end_date)) {
            return back()->with('error', 'Periode registrasi ulang sudah melewati batas akhir.');
        }

        $reservation->update([
            'status' => 'approved',
        ]);

        if (in_array($reservation->reservation_type, ['extension', 'transfer'])) {
            $this->createRegistrationInvoice($reservation);
        }

        return back()->with(
            'success',
            'Pengajuan berhasil disetujui. Tagihan pembayaran berhasil dibuat.'
        );
    }

    public function rejectReservation(Reservation $reservation)
    {
        $reservation->update([
            'status' => 'rejected',
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function deleteReservation(Reservation $reservation)
    {
        $reservation->delete();

        return back()->with('success', 'Data pengajuan berhasil dihapus.');
    }

    public function bulkAction(Request $request)
    {
        $ids = $request->ids ?? [];

        if (empty($ids)) {
            return back()->with('error', 'Pilih data terlebih dahulu.');
        }

        if (!$request->bulk_action) {
            return back()->with('error', 'Pilih aksi terlebih dahulu.');
        }

        $reservations = Reservation::with(['occupancyPeriod', 'room.floor'])
            ->whereIn('id', $ids)
            ->get();

        foreach ($reservations as $reservation) {
            if ($request->bulk_action === 'approve') {
                if ($reservation->occupancyPeriod?->status !== 'open') {
                    continue;
                }

                if (now()->startOfDay()->gt($reservation->occupancyPeriod->registration_end_date)) {
                    continue;
                }

                $reservation->update([
                    'status' => 'approved',
                ]);

                if (in_array($reservation->reservation_type, ['extension', 'transfer'])) {
                    $this->createRegistrationInvoice($reservation);
                }
            }

            if ($request->bulk_action === 'reject') {
                $reservation->update([
                    'status' => 'rejected',
                ]);
            }

            if ($request->bulk_action === 'delete') {
                $reservation->delete();
            }
        }

        return back()->with('success', 'Bulk action berhasil diproses.');
    }

    private function createRegistrationInvoice(Reservation $reservation): void
    {
        $reservation->loadMissing([
            'room.floor',
            'occupancyPeriod',
        ]);

        $amount = (int) ($reservation->room?->floor?->monthly_price ?? 0)
            * (int) ($reservation->duration_month ?? 1);

        if ($amount <= 0) {
            return;
        }

        Invoice::updateOrCreate(
            [
                'user_id' => $reservation->user_id,
                'reservation_id' => $reservation->id,
            ],
            [

                'room_id' => $reservation->room_id,
                'invoice_number' => 'INV' . strtoupper(Str::random(5)),
                'invoice_type' => match ($reservation->reservation_type) {
                    'extension' => 'extension',
                    'transfer' => 'transfer',
                    'checkout' => 'checkout',
                    default => 'new',
                },
                'amount' => $amount,
                'status' => 'unpaid',
                'due_at' => $reservation->occupancyPeriod?->registration_end_date,
            ]
        );
    }

    private function hasPaidInvoice(Reservation $reservation): bool
    {
        if ($reservation->reservation_type === 'checkout') {
            return true;
        }

        return Invoice::where('reservation_id', $reservation->id)
            ->whereIn('status', ['paid', 'settlement'])
            ->exists();
    }
}
