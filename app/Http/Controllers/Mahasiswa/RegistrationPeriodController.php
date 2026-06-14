<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\OccupancyPeriod;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Occupant;
use Illuminate\Http\Request;

class RegistrationPeriodController extends Controller
{
    private function activeProfile()
    {
        $occupant = Occupant::query()
            ->where('user_id', auth()->id())
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhereDate('end_date', '>=', now());
            })
            ->latest()
            ->first();

        if (!$occupant) {
            return null;
        }

        return auth()->user()
            ->studentProfile()
            ->with([
                'room.floor.building',
            ])
            ->where('room_id', $occupant->room_id)
            ->first();
    }
    private function activePeriod()
    {
        // PRIORITAS:
        // 1. admin buka manual
        // 2. otomatis berdasarkan tanggal

        $manualOpen = OccupancyPeriod::query()
            ->where('status', 'open')
            ->latest()
            ->first();

        if ($manualOpen) {
            return $manualOpen;
        }

        return OccupancyPeriod::query()
            ->where('status', 'upcoming')
            ->whereDate('registration_start_date', '<=', now())
            ->whereDate('registration_end_date', '>=', now())
            ->latest()
            ->first();
    }

    private function alreadySubmitted($period)
    {
        if (!$period) {
            return false;
        }

        return Reservation::where('user_id', auth()->id())
            ->where('occupancy_period_id', $period->id)
            ->whereIn('status', [
                'pending',
                'approved',
            ])
            ->exists();
    }

    public function index()
    {
        $period = $this->activePeriod();
        $profile = $this->activeProfile();

        $reservation = null;

        if ($period) {
            $reservation = Reservation::with([
                'room.floor.building',
                'previousRoom.floor.building',
            ])
                ->where('user_id', auth()->id())
                ->where('occupancy_period_id', $period->id)
                ->latest()
                ->first();
        }

        return view('pages.mahasiswa.registrasi-ulang.index', compact(
            'period',
            'profile',
            'reservation'
        ));
    }

    public function extendForm()
    {
        $period = $this->activePeriod();
        $profile = $this->activeProfile();

        if (!$period || !$profile) {
            return redirect()
                ->route('mahasiswa.registrasi-ulang.index')
                ->with('error', 'Periode registrasi ulang belum dibuka atau kamu belum memiliki kamar aktif.');
        }

        if ($this->alreadySubmitted($period)) {
            return redirect()
                ->route('mahasiswa.registrasi-ulang.index')
                ->with('error', 'Kamu sudah mengajukan pilihan registrasi ulang.');
        }

        $room = $profile->room;

        return view('pages.mahasiswa.registrasi-ulang.perpanjang', compact(
            'period',
            'profile',
            'room'
        ));
    }

    public function extendStore(Request $request)
    {
        $request->validate([
            'duration_month' => 'nullable|in:6',
            'notes' => 'nullable|string|max:1000',
        ]);

        $period = $this->activePeriod();
        $profile = $this->activeProfile();

        if (!$period || !$profile) {
            return back()->with('error', 'Periode registrasi ulang tidak tersedia.');
        }

        if ($this->alreadySubmitted($period)) {
            return back()->with('error', 'Kamu sudah mengajukan pilihan registrasi ulang.');
        }
        $user = auth()->user();
        $student = $user->studentProfile;
        $room = Room::with('floor')->find($profile->room_id);
        $activeReservation = Reservation::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();
        Reservation::create([
            'reservation_code' => strtoupper(substr(md5(uniqid()), 0, 6)),
            // 'reservation_code' => $this->generateReservationCode(),

            'occupancy_period_id' => $period->id,
            'reservation_type' => 'extension',

            'user_id' => $user->id,
            'room_id' => $profile->room_id,
            'previous_room_id' => $profile->room_id,

            'contact_name' => $user->name,
            'contact_phone' => $user->number_phone,
            'contact_email' => $user->email,

            'guest_name' => $user->name,
            'guest_nim' => $student->nim,
            'guest_faculty' => $student->fakultas,
            'guest_major' => $student->jurusan,
            'guest_intake_year' => $student->angkatan,

            'parent_name' => $student->nama_ortu,
            'parent_phone' => $student->no_hp_ortu,

            // 'occupancy_type' => 'shared',
            // 'slot_used' => 1,

            'occupancy_type' => $activeReservation?->occupancy_type ?? 'shared',
            'slot_used' => $activeReservation?->slot_used ?? 1,

            'price_per_month' => $room->floor->monthly_price ?? 0,
            'total_price' => ($room->floor->monthly_price ?? 0) * 6,

            'duration_month' => 6,
            'payment_term' => 1,

            'status' => 'pending',

            'start_date' => $period->lease_start_date,
            'end_date' => $period->lease_end_date,

            'special_request' => $request->notes,
        ]);

        return redirect()
            ->route('mahasiswa.registrasi-ulang.index')
            ->with('success', 'Pengajuan perpanjang sewa berhasil dikirim.');
    }

    public function transferForm()
    {
        $period = $this->activePeriod();
        $profile = $this->activeProfile();

        if (!$period || !$profile) {
            return redirect()
                ->route('mahasiswa.registrasi-ulang.index')
                ->with('error', 'Periode registrasi ulang belum dibuka atau kamu belum memiliki kamar aktif.');
        }

        if ($this->alreadySubmitted($period)) {
            return redirect()
                ->route('mahasiswa.registrasi-ulang.index')
                ->with('error', 'Kamu sudah mengajukan pilihan registrasi ulang.');
        }

        $currentRoom = $profile->room;
        $userGender = $profile->gender;

        $rooms = Room::query()
            ->select('rooms.*')
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->with(['floor.building'])
            ->where('rooms.id', '!=', $profile->room_id)
            ->where('rooms.status', 'tersedia')
            ->whereColumn('rooms.occupied', '<', 'floors.room_capacity')
            ->where(function ($query) use ($userGender) {
                $query->where('buildings.gender_type', 'mixed')
                    ->orWhere('buildings.gender_type', $userGender)
                    ->orWhereNull('buildings.gender_type');
            })
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->orderBy('rooms.kode_kamar')
            ->paginate(12);

        return view('pages.mahasiswa.registrasi-ulang.pindah-kamar', compact(
            'period',
            'profile',
            'currentRoom',
            'rooms'
        ));
    }

    public function transferStore(Request $request, Room $room)
    {
        $request->validate([
            'occupancy_type' => 'required|in:private,shared',
            'notes' => 'nullable|string|max:1000',
        ]);

        $period = $this->activePeriod();
        $profile = $this->activeProfile();

        if (!$period || !$profile) {
            return back()->with('error', 'Periode registrasi ulang tidak tersedia.');
        }

        if ($this->alreadySubmitted($period)) {
            return back()->with('error', 'Kamu sudah mengajukan pilihan registrasi ulang.');
        }

        if ($profile->room_id === $room->id) {
            return back()->with('error', 'Kamu sudah menempati kamar tersebut.');
        }

        $room->load(['floor.building']);

        $capacity = (int) ($room->floor?->room_capacity ?? 0);
        $occupied = (int) ($room->occupied ?? 0);

        if ($room->status !== 'tersedia' || $occupied >= $capacity) {
            return back()->with('error', 'Kamar tujuan sudah penuh atau tidak tersedia.');
        }

        $userGender = $profile->gender;
        $buildingGender = $room->floor?->building?->gender_type;

        if ($buildingGender && $buildingGender !== 'mixed' && $buildingGender !== $userGender) {
            return back()->with('error', 'Kamar tidak sesuai ketentuan gedung.');
        }

        Reservation::create([
            'occupancy_period_id' => $period->id,
            'reservation_type' => 'transfer',
            'user_id' => auth()->id(),
            'room_id' => $room->id,
            'previous_room_id' => $profile->room_id,
            'duration_month' => 6,
            'status' => 'pending',
            'start_date' => $period->lease_start_date,
            'end_date' => $period->lease_end_date,
            'requested_at' => now(),
            'notes' => $request->notes ?: 'Pengajuan pindah kamar.',
            'occupancy_type' => $request->occupancy_type,
            'slot_used' => $request->occupancy_type === 'private'
                ? ($room->floor->room_capacity ?? 2)
                : 1,
        ]);

        return redirect()
            ->route('mahasiswa.registrasi-ulang.index')
            ->with('success', 'Pengajuan pindah kamar berhasil dikirim.');
    }

    public function checkoutForm()
    {
        $period = $this->activePeriod();
        $profile = $this->activeProfile();

        if (!$period || !$profile) {
            return redirect()
                ->route('mahasiswa.registrasi-ulang.index')
                ->with('error', 'Periode registrasi ulang belum dibuka atau kamu belum memiliki kamar aktif.');
        }

        if ($this->alreadySubmitted($period)) {
            return redirect()
                ->route('mahasiswa.registrasi-ulang.index')
                ->with('error', 'Kamu sudah mengajukan pilihan registrasi ulang.');
        }

        $room = $profile->room;

        return view('pages.mahasiswa.registrasi-ulang.akhiri-kontrak', compact(
            'period',
            'profile',
            'room'
        ));
    }

    public function checkoutStore(Request $request)
    {
        $period = $this->activePeriod();
        $profile = $this->activeProfile();
        $request->validate([
            'checkout_date' => [
                'required',
                'date',
                'after_or_equal:today',
                'before_or_equal:' . $period->lease_end_date->format('Y-m-d'),
            ],
            'notes' => 'required|string|max:1000',
            // 'statement_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:15360',
        ], [
            'checkout_date.before_or_equal' => 'Tanggal keluar tidak boleh melewati batas akhir masa hunian periode ini.',
        ]);



        if (!$period || !$profile) {
            return back()->with('error', 'Periode registrasi ulang tidak tersedia.');
        }

        if ($this->alreadySubmitted($period)) {
            return back()->with('error', 'Kamu sudah mengajukan pilihan registrasi ulang.');
        }

        // $filePath = null;

        // if ($request->hasFile('statement_file')) {
        //     $filePath = $request->file('statement_file')->store(
        //         'documents/checkout-statements',
        //         'public'
        //     );
        // }

        $user = auth()->user();
        $student = $user->studentProfile;
        $room = Room::with('floor')->find($profile->room_id);

        $activeReservation = Reservation::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();
        Reservation::create([
            'reservation_code' => strtoupper(substr(md5(uniqid()), 0, 6)),

            'occupancy_period_id' => $period->id,
            'reservation_type' => 'checkout',

            'user_id' => $user->id,
            'room_id' => $profile->room_id,
            'previous_room_id' => $profile->room_id,

            'contact_name' => $user->name,
            'contact_phone' => $user->number_phone,
            'contact_email' => $user->email,

            'guest_name' => $user->name,
            'guest_nim' => $student->nim,
            'guest_faculty' => $student->fakultas,
            'guest_major' => $student->jurusan,
            'guest_intake_year' => $student->angkatan,

            'parent_name' => $student->nama_ortu,
            'parent_phone' => $student->no_hp_ortu,

            // 'occupancy_type' => 'shared',
            // 'slot_used' => 1,
            'occupancy_type' => $activeReservation?->occupancy_type,
            'slot_used' => $activeReservation?->slot_used,
            'price_per_month' => $room->floor->monthly_price ?? 0,
            'total_price' => 0,

            'duration_month' => 0,
            'payment_term' => 1,

            'status' => 'pending',

            'start_date' => now()->startOfDay(),
            'end_date' => $request->checkout_date,

            'special_request' => $request->notes ?: 'Pengajuan akhiri kontrak.',

            // HAPUS INI kalau tidak ada kolomnya:
            // 'requested_at' => now(),
            // 'document_path' => $filePath,
        ]);
        // Reservation::create([
        //     'occupancy_period_id' => $period->id,
        //     'reservation_type' => 'checkout',
        //     'user_id' => auth()->id(),
        //     'room_id' => $profile->room_id,
        //     'previous_room_id' => $profile->room_id,
        //     'duration_month' => 0,
        //     'status' => 'pending',
        //     'start_date' => now()->startOfDay(),
        //     'end_date' => $request->checkout_date,
        //     'requested_at' => now(),
        //     'notes' => $request->notes ?: 'Pengajuan akhiri kontrak.',
        //     'document_path' => $filePath,
        // ]);

        return redirect()
            ->route('mahasiswa.registrasi-ulang.index')
            ->with('success', 'Pengajuan akhiri kontrak berhasil dikirim.');
    }
}
