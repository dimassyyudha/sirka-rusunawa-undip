<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Occupant;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\StudentProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PenghuniController extends Controller
{

    private function syncRoomOccupied(?Room $room): void
    {
        if (!$room) {
            return;
        }

        $room->load('floor');

        $occupied = Occupant::where('room_id', $room->room_id)
            ->where('status', 'active')
            ->count();

        $reservation = Reservation::where('room_id', $room->room_id)
            ->whereIn('status', ['active', 'approved'])
            ->latest()
            ->first();

        if ($reservation?->occupancy_type === 'private') {

            $room->update([
                'occupied' => $occupied,
                'status' => $occupied >= 1
                    ? 'penuh'
                    : 'tersedia',
            ]);

            return;
        }

        $capacity = $room->floor->room_capacity ?? 2;

        $room->update([
            'occupied' => $occupied,
            'status' => $occupied >= $capacity
                ? 'penuh'
                : 'tersedia',
        ]);
    }

    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);

        $buildings = Building::where('is_active', true)->orderBy('name')->get();

        $penghunis = StudentProfile::with([
            'user',
            'room.floor.building',
            'user.reservations',
        ])

            ->where('status_mahasiswa', 'penghuni')
            ->whereNotNull('student_profiles.room_id')

            ->when($request->search, function ($query) use ($request) {

                $query->where(function ($q) use ($request) {

                    $q->where('nim', 'like', '%' . $request->search . '%');
                })

                    ->orWhereHas('user', function ($user) use ($request) {

                        $user->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%')
                            ->orWhere('number_phone', 'like', '%' . $request->search . '%');
                    });
            })

            ->when($request->building_id, function ($query) use ($request) {

                $query->whereHas('room.floor', function ($q) use ($request) {

                    $q->where('building_id', $request->building_id);
                });
            })

            ->when($request->occupancy_type, function ($query) use ($request) {

                $query->whereHas('user.reservations', function ($q) use ($request) {

                    $q->whereIn('status', ['active', 'approved'])
                        ->where('occupancy_type', $request->occupancy_type);
                });
            })
            ->when($request->jalur_pembiayaan, function ($query) use ($request) {

                $query->where(
                    'jalur_pembiayaan',
                    $request->jalur_pembiayaan
                );
            })

            ->join('rooms', 'student_profiles.room_id', '=', 'rooms.room_id')
            ->join('floors', 'rooms.floor_id', '=', 'floors.floor_id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.building_id')
            ->select('student_profiles.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->orderBy('rooms.kode_kamar')
            ->orderBy('student_profiles.nim')
            ->paginate($perPage)
            ->withQueryString();


        $penghunis->getCollection()->transform(function ($p) {

            $reservation = $p->user->reservations
                ->whereIn('status', ['active', 'approved'])
                ->sortByDesc('created_at')
                ->first();

            if (!$reservation) {

                $reservation = $p->user->reservations
                    ->where('room_id', $p->room_id)
                    ->sortByDesc('created_at')
                    ->first();
            }

            $p->occupancy_type_label = $reservation?->occupancy_type;
            $p->lease_start_date = $reservation?->start_date;
            $p->lease_end_date = $reservation?->end_date;

            return $p;
        });
        return view('pages.admin.penghuni.index', compact('penghunis', 'buildings'));
    }

    public function create()
    {
        $rooms = Room::with(['floor.building'])
            ->where('status', '!=', 'maintenance')
            ->join('floors', 'rooms.floor_id', '=', 'floors.floor_id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.building_id')
            ->select('rooms.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->orderBy('rooms.kode_kamar')
            ->get();



        return view('pages.admin.penghuni.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'occupancy_type' => 'required|in:private,shared',

            'lease_start_date' => 'required|date',

            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',

            'number_phone' => 'required|string|max:20',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'nim' => 'required|string|max:20|unique:student_profiles,nim',

            'fakultas' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|integer',

            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',

            'alamat' => 'required|string',

            'nama_ortu' => 'required|string|max:255',
            'no_hp_ortu' => 'required|string|max:20',

            'alamat_orang_tua' => 'required|string',
            'pekerjaan_orang_tua' => 'required|string|max:100',

            'status_mahasiswa' => 'required',
            'room_id' => 'nullable|exists:rooms,room_id',

        ]);

        DB::transaction(function () use ($validated) {
            $room = !empty($validated['room_id'])
                ? Room::with('floor')->find($validated['room_id'])
                : null;

            if ($validated['status_mahasiswa'] === 'penghuni' && $room) {

                $currentOccupied = Occupant::where('room_id', $room->room_id)
                    ->where('status', 'active')
                    ->count();

                if ($validated['occupancy_type'] === 'private') {

                    if ($currentOccupied >= 1) {

                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'room_id' => 'Kamar private sudah ditempati penghuni lain.',
                        ]);
                    }
                } else {

                    if ($currentOccupied >= $room->floor->room_capacity) {

                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'room_id' => 'Kamar sudah penuh.',
                        ]);
                    }
                }
            }

            if ($validated['status_mahasiswa'] === 'tidak_penghuni') {
                $validated['room_id'] = null;
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'number_phone' => $validated['number_phone'],
                'gender' => $validated['gender'],
                'role' => 'mahasiswa',
            ]);
            StudentProfile::create([
                'user_id' => $user->user_id,

                'nim' => $validated['nim'],
                'fakultas' => $validated['fakultas'],
                'jurusan' => $validated['jurusan'],
                'angkatan' => $validated['angkatan'],

                'tempat_lahir' => $validated['tempat_lahir'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'agama' => $validated['agama'],

                'alamat' => $validated['alamat'],

                // tambahkan ini
                'no_hp' => $validated['number_phone'],

                'nama_ortu' => $validated['nama_ortu'],
                'no_hp_ortu' => $validated['no_hp_ortu'],
                'alamat_orang_tua' => $validated['alamat_orang_tua'],
                'pekerjaan_orang_tua' => $validated['pekerjaan_orang_tua'],

                'status_mahasiswa' => $validated['status_mahasiswa'],
                'room_id' => $validated['room_id'],

                'has_vehicle' => false,
            ]);
            if (
                $validated['status_mahasiswa'] === 'penghuni'
                && !empty($validated['room_id'])
            ) {

                $room = Room::with('floor')->find($validated['room_id']);
                $userGender = strtolower($user->gender ?? '');

                $buildingGender = strtolower(
                    $room->floor->building->gender_type
                );

                if (
                    $buildingGender !== $userGender
                ) {

                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'room_id' =>
                        'Jenis kelamin penghuni tidak sesuai dengan gedung.',
                    ]);
                }

                $pricePerMonth = $room->monthly_price ?? 0;

                $startDate = Carbon::parse(
                    $validated['lease_start_date']
                );

                if ($startDate->month <= 6) {

                    $endDate = Carbon::create(
                        $startDate->year,
                        6,
                        30
                    );
                } else {

                    $endDate = Carbon::create(
                        $startDate->year,
                        12,
                        31
                    );
                }

                $durationMonth = max(
                    1,
                    $startDate->diffInMonths($endDate)
                );


                $reservation = Reservation::create([

                    'reservation_code' => strtoupper(
                        substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ123456789'), 0, 8)
                    ),

                    'room_id' => $room->room_id,
                    'user_id' => $user->user_id,

                    'contact_name' => $user->name,
                    'contact_phone' => $user->number_phone,
                    'contact_email' => $user->email,

                    'guest_name' => $user->name,
                    'guest_nim' => $validated['nim'],
                    'guest_faculty' => $validated['fakultas'],
                    'guest_major' => $validated['jurusan'],
                    'guest_intake_year' => $validated['angkatan'],

                    'parent_name' => $validated['nama_ortu'],
                    'parent_phone' => $validated['no_hp_ortu'],

                    'start_date' => $startDate,
                    'end_date' => $endDate,

                    'duration_month' => $durationMonth,

                    'payment_term' => 1,

                    'occupancy_type' => $validated['occupancy_type'],

                    'slot_used' => 1,

                    'price_per_month' => $pricePerMonth,
                    'total_price' => $pricePerMonth * $durationMonth,

                    'status' => 'active',
                ]);

                Occupant::create([

                    'user_id' => $user->user_id,

                    'room_id' => $room->room_id,

                    'reservation_id' => $reservation->reservation_id,

                    'start_date' => $startDate,

                    'end_date' => $endDate,

                    'status' => 'active',

                ]);

                $room->increment('occupied');
            }
            $this->syncRoomOccupied($room);
        });

        return redirect()->route('admin.penghuni.index')->with('success', 'Data penghuni berhasil ditambahkan.');
    }

    public function show(StudentProfile $penghuni)
    {
        $penghuni->load(['user', 'room.floor.building']);

        $reservation = Reservation::where('user_id', $penghuni->user_id)
            ->whereIn('status', ['active', 'approved'])
            ->latest()
            ->first();

        return view(
            'pages.admin.penghuni.show',
            compact('penghuni', 'reservation')
        );
    }

    public function edit(StudentProfile $penghuni)
    {
        $penghuni->load(['user', 'room.floor.building']);

        $rooms = Room::with(['floor.building'])
            ->where(function ($query) use ($penghuni) {
                $query->where('rooms.status', '!=', 'maintenance')
                    ->orWhere('rooms.room_id', $penghuni->room_id);
            })
            ->join('floors', 'rooms.floor_id', '=', 'floors.floor_id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.building_id')
            ->select('rooms.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->orderBy('rooms.kode_kamar')
            ->get();
        $activeReservation = $penghuni->user->reservations()
            ->whereIn('status', ['active', 'approved'])
            ->latest()
            ->first();

        return view('pages.admin.penghuni.edit', compact(
            'penghuni',
            'rooms',
            'activeReservation'
        ));

        // return view(
        //     'pages.admin.penghuni.edit',
        //     compact(
        //         'penghuni',
        //         'rooms',
        //         'reservation'
        //     )
        // );
    }

    public function update(Request $request, StudentProfile $penghuni)
    {
        $validated = $request->validate([

            'name' => 'required|string|max:100',
            // 'email' => 'required|email|unique:users,email,' . $penghuni->user_id,
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')
                    ->ignore($penghuni->user_id, 'user_id'),
            ],

            // 'nim' => 'required|digits:14|unique:student_profiles,nim,' . $penghuni->id,
            'nim' => [
                'required',
                'digits:14',
                Rule::unique('student_profiles', 'nim')
                    ->ignore($penghuni->student_profile_id, 'student_profile_id'),
            ],

            'fakultas' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:2100',

            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|string|max:50',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'alamat' => 'required|string',

            'number_phone' => 'required|string|max:20',

            'nama_ortu' => 'required|string|max:100',
            'no_hp_ortu' => 'required|string|max:20',

            'alamat_orang_tua' => 'required|string',
            'pekerjaan_orang_tua' => 'required|string|max:100',

            'occupancy_type' => 'required|in:private,shared',

            'lease_start_date' => 'required|date',

            'status_mahasiswa' => 'required|in:penghuni,tidak_penghuni',

            'room_id' => 'required_if:status_mahasiswa,penghuni|nullable|exists:rooms,room_id',
        ]);

        DB::transaction(function () use ($validated, $penghuni) {
            $oldRoom = $penghuni->room;

            $newRoom = !empty($validated['room_id'])
                ? Room::with('floor')->find($validated['room_id'])
                : null;

            if ($validated['status_mahasiswa'] === 'penghuni' && $newRoom) {

                $currentOccupied = Occupant::where('room_id', $newRoom->room_id)
                    ->where('status', 'active')
                    ->where('user_id', '!=', $penghuni->user_id)
                    ->count();

                if ($validated['occupancy_type'] === 'private') {

                    if ($currentOccupied >= 1) {

                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'room_id' => 'Kamar private sudah ditempati penghuni lain.',
                        ]);
                    }
                } else {

                    if ($currentOccupied >= $newRoom->floor->room_capacity) {

                        throw \Illuminate\Validation\ValidationException::withMessages([
                            'room_id' => 'Kamar sudah penuh.',
                        ]);
                    }
                }
            }

            if ($validated['status_mahasiswa'] === 'tidak_penghuni') {
                $validated['room_id'] = null;
            }

            $penghuni->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'number_phone' => $validated['number_phone'],
                'gender' => $validated['gender'],
            ]);
            $penghuni->update([

                'nim' => $validated['nim'],

                'fakultas' => $validated['fakultas'],

                'jurusan' => $validated['jurusan'],

                'angkatan' => $validated['angkatan'],

                'tempat_lahir' => $validated['tempat_lahir'],

                'tanggal_lahir' => $validated['tanggal_lahir'],

                'agama' => $validated['agama'],

                'alamat' => $validated['alamat'],

                'nama_ortu' => $validated['nama_ortu'],

                'no_hp_ortu' => $validated['no_hp_ortu'],

                'alamat_orang_tua' => $validated['alamat_orang_tua'],

                'pekerjaan_orang_tua' => $validated['pekerjaan_orang_tua'],

                'status_mahasiswa' => $validated['status_mahasiswa'],

                'room_id' => $validated['room_id'],
            ]);

            $startDate = Carbon::parse(
                $validated['lease_start_date']
            );

            $month = $startDate->month;

            if ($month <= 6) {

                $endDate = Carbon::create(
                    $startDate->year,
                    6,
                    30
                );
            } else {

                $endDate = Carbon::create(
                    $startDate->year,
                    12,
                    31
                );
            }
            // update reservation aktif
            $currentReservation = Reservation::where('user_id', $penghuni->user_id)
                ->whereIn('status', [
                    'active',
                    'approved'
                ])
                ->latest()
                ->first();

            if ($currentReservation) {
                $currentReservation->update([

                    'room_id' => $validated['room_id'],

                    'occupancy_type' => $validated['occupancy_type'],

                    'start_date' => $startDate,

                    'end_date' => $endDate,

                ]);
            }

            // update occupant aktif
            $currentOccupant = Occupant::where('user_id', $penghuni->user_id)
                ->where('status', 'active')
                ->first();

            if ($currentOccupant) {

                $currentOccupant->update([

                    'room_id' => $validated['room_id'],

                    'start_date' => $startDate,

                    'end_date' => $endDate,

                ]);
            } elseif (
                $validated['status_mahasiswa'] === 'penghuni'
                && !empty($validated['room_id'])
            ) {

                Occupant::create([

                    'user_id' => $penghuni->user_id,

                    'room_id' => $validated['room_id'],

                    'reservation_id' => $currentReservation?->reservation_id,

                    'start_date' => $currentReservation?->start_date ?? now(),

                    'end_date' => $currentReservation?->end_date ?? now()->addMonths(6),

                    'status' => 'active',
                ]);
            }

            $this->syncRoomOccupied($oldRoom);
            $this->syncRoomOccupied($newRoom);
        });

        return redirect()->route('admin.penghuni.index')->with('success', 'Data penghuni berhasil diperbarui.');
    }

    public function destroy(StudentProfile $penghuni)
    {
        DB::transaction(function () use ($penghuni) {
            $room = $penghuni->room;
            $penghuni->user->delete();
            $this->syncRoomOccupied($room);
        });

        return redirect()->route('admin.penghuni.index')->with('success', 'Penghuni berhasil dihapus.');
    }
}
