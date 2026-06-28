<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Occupant;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);

        $buildings = Building::where('is_active', true)
            ->orderBy('name')
            ->get();

        // $buildings = Building::orderBy('name')->get();

        $floors = Floor::with('building')
            ->orderBy('building_id')
            ->orderBy('floor_number')
            ->get();

        $rooms = Room::with([
            'floor.building',
            'penghuni.user',
            'occupants.reservation'
        ])

            ->when($request->search, function ($q) use ($request) {

                $q->where('kode_kamar', 'like', '%' . $request->search . '%');
            })

            ->when($request->building_id, function ($q) use ($request) {

                $q->whereHas('floor', function ($floor) use ($request) {

                    $floor->where('building_id', $request->building_id);
                });
            })

            ->when($request->floor_id, function ($q) use ($request) {

                $q->where('floor_id', $request->floor_id);
            })

            ->when($request->status, function ($q) use ($request) {

                $q->where('status', $request->status);
            })

            ->join('floors', 'rooms.floor_id', '=', 'floors.floor_id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.building_id')

            ->select('rooms.*')

            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->orderBy('rooms.kode_kamar')

            ->paginate($perPage)
            ->withQueryString();
        $rooms->getCollection()->transform(function ($room) {

            $activeOccupants = Occupant::with('reservation')
                ->where('room_id', $room->room_id)
                ->where('status', 'active')
                ->get();

            $occupiedCount = $activeOccupants->count();

            $latestReservation = Reservation::where('room_id', $room->room_id)
                ->whereIn('status', ['active', 'approved'])
                ->latest()
                ->first();

            $occupancyType = $latestReservation?->occupancy_type;

            if ($occupancyType === 'private') {

                $room->display_capacity = 1;

                $room->display_status =
                    $occupiedCount >= 1
                    ? 'penuh'
                    : 'tersedia';

                $room->display_slot =
                    max(0, 1 - $occupiedCount);
            } else {

                $capacity = $room->floor->room_capacity ?? 2;

                $room->display_capacity = $capacity;

                $room->display_status =
                    $occupiedCount >= $capacity
                    ? 'penuh'
                    : 'tersedia';

                $room->display_slot =
                    max(0, $capacity - $occupiedCount);
            }

            $room->display_occupied = $occupiedCount;

            $room->occupancy_type =
                $occupancyType;

            return $room;
        });
        return view('pages.admin.rooms.index', compact('rooms', 'floors', 'buildings'));
    }



    public function create()
    {
        $floors = Floor::with('building')
            ->join('buildings', 'floors.building_id', '=', 'buildings.building_id')
            ->select('floors.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->get();

        $currentYear = now()->year;

        return view('pages.admin.rooms.create', compact('floors', 'currentYear'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'floor_id' => 'required|exists:floors,floor_id',
            // 'kode_kamar' => 'required|string|max:50|unique:rooms,kode_kamar',

            'occupied' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,penuh,maintenance',
            'fasilitas' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);



        $floor = Floor::findOrFail($request->floor_id);

        $request->validate([
            'occupied' => 'max:' . $floor->room_capacity,
        ]);

        $room = Room::create([
            'floor_id' => $request->floor_id,
            'kode_kamar' => strtoupper($request->kode_kamar),
            'occupied' => $request->occupied,
            'status' => $request->status,
            'fasilitas' => $request->fasilitas,
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('rooms', 'public');

                RoomPhoto::create([
                    'room_id' => $room->room_id,
                    'path' => 'storage/' . $path,
                    'is_primary' => $index === 0,
                    'sort_order' => $index + 1,
                ]);
            }
        }

        $floor->update([
            'total_rooms' => $floor->rooms()->count(),
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function show(Room $room)
    {
        $room->load([
            'floor.building',
            'penghuni.user',
        ]);

        return view('pages.admin.rooms.show', compact('room'));
    }

    public function edit(Room $room)
    {
        $room->load(['floor.building']);

        $floors = Floor::with('building')
            ->join('buildings', 'floors.building_id', '=', 'buildings.building_id')
            ->select('floors.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->get();

        return view('pages.admin.rooms.edit', compact('room', 'floors'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            // 'kode_kamar' => 'required|string|max:50|unique:rooms,kode_kamar,' . $room->room_id,


            'kode_kamar' => [
                'required',
                'string',
                'max:50',
                Rule::unique('rooms', 'kode_kamar')
                    ->ignore($room->room_id, 'room_id'),
            ],
            'occupied' => 'required|integer|min:0|max:' . $room->floor->room_capacity,
            'status' => 'required|in:tersedia,penuh,maintenance',
            'fasilitas' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'exists:room_photos,id',
        ]);

        $room->update([
            'kode_kamar' => strtoupper($request->kode_kamar),
            'occupied' => $request->occupied,
            'status' => $request->status,
            'fasilitas' => $request->fasilitas,
        ]);

        if ($request->filled('delete_photos')) {
            $photos = $room->photos()
                ->whereIn('id', $request->delete_photos)
                ->get();

            foreach ($photos as $photo) {
                Storage::disk('public')->delete(str_replace('storage/', '', $photo->path));
                $photo->delete();
            }
        }

        if ($request->hasFile('photos')) {
            $lastOrder = $room->photos()->max('sort_order') ?? 0;

            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('rooms', 'public');

                RoomPhoto::create([
                    'room_id' => $room->room_id,
                    'path' => 'storage/' . $path,
                    'is_primary' => $room->photos()->count() === 0 && $index === 0,
                    'sort_order' => $lastOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Room $room)
    {
        $floor = $room->floor;

        $room->delete();

        if ($floor) {
            $floor->update([
                'total_rooms' => $floor->rooms()->count(),
            ]);
        }

        return redirect()->route('admin.rooms.index')->with('success', 'Kamar berhasil dihapus.');
    }
}
