<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Room;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenghuniController extends Controller
{
    private function syncRoomOccupied(?Room $room): void
    {
        if (!$room) {
            return;
        }

        $room->load('floor');

        $occupied = StudentProfile::where('room_id', $room->id)
            ->where('status_mahasiswa', 'penghuni')
            ->count();

        $room->update([
            'occupied' => $occupied,
            'status' => $occupied >= $room->floor->room_capacity ? 'penuh' : 'tersedia',
        ]);
    }

    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);

        $buildings = Building::where('is_active', true)->orderBy('name')->get();

        $penghunis = $penghunis = StudentProfile::with([
            'user.reservations',
            'room.floor.building'
        ])
            ->where('status_mahasiswa', 'penghuni')
            ->whereNotNull('room_id')
            ->when($request->building_id, function ($query) use ($request) {
                $query->whereHas('room.floor', function ($q) use ($request) {
                    $q->where('building_id', $request->building_id);
                });
            })
            ->join('rooms', 'student_profiles.room_id', '=', 'rooms.id')
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('student_profiles.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->orderBy('rooms.kode_kamar')
            ->orderBy('student_profiles.nim')
            ->paginate($perPage)
            ->withQueryString();


        $penghunis->getCollection()->transform(function ($p) {

            $activeReservation = $p->user->reservations
                ->where('status', 'active')
                ->sortByDesc('created_at')
                ->first();

            $latestLease = $p->user->reservations
                ->whereIn('status', ['active', 'approved'])
                ->sortByDesc('end_date')
                ->first();

            $p->occupancy_type_label =
                $activeReservation?->occupancy_type;

            $p->lease_start_date =
                $latestLease?->start_date;

            $p->lease_end_date =
                $latestLease?->end_date;

            return $p;
        });

        return view('pages.admin.penghuni.index', compact('penghunis', 'buildings'));
    }

    public function create()
    {
        $rooms = Room::with(['floor.building'])
            ->where('status', '!=', 'maintenance')
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
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
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',

            'nim' => 'required|digits:14|unique:student_profiles,nim',
            'fakultas' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:2100',
            'alamat' => 'required|string',

            'number_phone' => 'required|string|max:20',
            'nama_ortu' => 'required|string|max:100',
            'no_hp_ortu' => 'required|string|max:20',

            'status_mahasiswa' => 'required|in:penghuni,tidak_penghuni',
            'room_id' => 'required_if:status_mahasiswa,penghuni|exists:rooms,id',
        ]);

        DB::transaction(function () use ($validated) {
            $room = !empty($validated['room_id'])
                ? Room::with('floor')->find($validated['room_id'])
                : null;

            if ($validated['status_mahasiswa'] === 'penghuni' && $room) {
                $currentOccupied = StudentProfile::where('room_id', $room->id)
                    ->where('status_mahasiswa', 'penghuni')
                    ->count();

                if ($currentOccupied >= $room->floor->room_capacity) {
                    abort(redirect()->back()->withErrors([
                        'room_id' => 'Kamar sudah penuh, pilih kamar lain.',
                    ])->withInput());
                }
            }

            if ($validated['status_mahasiswa'] === 'tidak_penghuni') {
                $validated['room_id'] = null;
            }

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'mahasiswa',
                'number_phone' => $validated['number_phone'] ?? null,
            ]);

            StudentProfile::create([
                'user_id' => $user->id,
                'nim' => $validated['nim'],
                'jurusan' => $validated['jurusan'],
                'angkatan' => $validated['angkatan'],
                'alamat' => $validated['alamat'] ?? null,
                'nama_ortu' => $validated['nama_ortu'] ?? null,
                'no_hp_ortu' => $validated['no_hp_ortu'] ?? null,
                'status_mahasiswa' => $validated['status_mahasiswa'],
                'room_id' => $validated['room_id'],
            ]);

            $this->syncRoomOccupied($room);
        });

        return redirect()->route('admin.penghuni.index')->with('success', 'Data penghuni berhasil ditambahkan.');
    }

    public function show(StudentProfile $penghuni)
    {
        $penghuni->load(['user', 'room.floor.building']);

        return view('pages.admin.penghuni.show', compact('penghuni'));
    }

    public function edit(StudentProfile $penghuni)
    {
        $penghuni->load(['user', 'room.floor.building']);

        $rooms = Room::with(['floor.building'])
            ->where(function ($query) use ($penghuni) {
                $query->where('rooms.status', '!=', 'maintenance')
                    ->orWhere('rooms.id', $penghuni->room_id);
            })
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('rooms.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->orderBy('rooms.kode_kamar')
            ->get();

        return view('pages.admin.penghuni.edit', compact('penghuni', 'rooms'));
    }

    public function update(Request $request, StudentProfile $penghuni)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $penghuni->user_id,

            'nim' => 'required|digits:14|unique:student_profiles,nim,' . $penghuni->id,
            'fakultas' => 'required|string|max:100',
            'jurusan' => 'required|string|max:100',
            'angkatan' => 'required|integer|min:2000|max:2100',
            'alamat' => 'required|string',

            'number_phone' => 'required|string|max:20',
            'nama_ortu' => 'required|string|max:100',
            'no_hp_ortu' => 'required|string|max:20',

            'status_mahasiswa' => 'required|in:penghuni,tidak_penghuni',
            'room_id' => 'required_if:status_mahasiswa,penghuni|exists:rooms,id',
        ]);

        DB::transaction(function () use ($validated, $penghuni) {
            $oldRoom = $penghuni->room;

            $newRoom = !empty($validated['room_id'])
                ? Room::with('floor')->find($validated['room_id'])
                : null;

            if ($validated['status_mahasiswa'] === 'penghuni' && $newRoom) {
                $currentOccupied = StudentProfile::where('room_id', $newRoom->id)
                    ->where('status_mahasiswa', 'penghuni')
                    ->where('id', '!=', $penghuni->id)
                    ->count();

                if ($currentOccupied >= $newRoom->floor->room_capacity) {
                    abort(redirect()->back()->withErrors([
                        'room_id' => 'Kamar sudah penuh, pilih kamar lain.',
                    ])->withInput());
                }
            }

            if ($validated['status_mahasiswa'] === 'tidak_penghuni') {
                $validated['room_id'] = null;
            }

            $penghuni->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'number_phone' => $validated['number_phone'] ?? null,
            ]);

            $penghuni->update([
                'nim' => $validated['nim'],
                'jurusan' => $validated['jurusan'],
                'angkatan' => $validated['angkatan'],
                'alamat' => $validated['alamat'] ?? null,
                'nama_ortu' => $validated['nama_ortu'] ?? null,
                'no_hp_ortu' => $validated['no_hp_ortu'] ?? null,
                'status_mahasiswa' => $validated['status_mahasiswa'],
                'room_id' => $validated['room_id'],
            ]);

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
