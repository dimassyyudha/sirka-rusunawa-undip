<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\RoomPhoto;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);

        $buildings = Building::where('is_active', true)
            ->orderBy('name')
            ->get();

        $rooms = Room::with(['floor.building', 'penghuni.user'])
            ->when($request->building_id, function ($query) use ($request) {
                $query->whereHas('floor', function ($q) use ($request) {
                    $q->where('building_id', $request->building_id);
                });
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('rooms.status', $request->status);
            })
            ->when($request->angkatan, function ($query) use ($request) {
                $query->whereHas('penghuni', function ($q) use ($request) {
                    $q->where('angkatan', $request->angkatan)
                        ->where('status_mahasiswa', 'penghuni');
                });
            })
            ->join('floors', 'rooms.floor_id', '=', 'floors.id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('rooms.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->orderBy('rooms.kode_kamar')
            ->paginate(10)
            ->withQueryString();

        return view('pages.admin.rooms.index', compact('rooms', 'buildings'));
    }

    public function create()
    {
        $floors = Floor::with('building')
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('floors.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->get();

        return view('pages.admin.rooms.create', compact('floors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'kode_kamar' => 'required|string|max:50|unique:rooms,kode_kamar',
            'occupied' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,penuh,maintenance',
            'fasilitas' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
                    'room_id' => $room->id,
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
            ->join('buildings', 'floors.building_id', '=', 'buildings.id')
            ->select('floors.*')
            ->orderBy('buildings.name')
            ->orderBy('floors.floor_number')
            ->get();

        return view('pages.admin.rooms.edit', compact('room', 'floors'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'kode_kamar' => 'required|string|max:50|unique:rooms,kode_kamar,' . $room->id,
            'occupied' => 'required|integer|min:0|max:' . $room->floor->room_capacity,
            'status' => 'required|in:tersedia,penuh,maintenance',
            'fasilitas' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
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
                    'room_id' => $room->id,
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
