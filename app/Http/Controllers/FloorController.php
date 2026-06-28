<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->integer('per_page', 10);

        $buildings = Building::orderBy('name')->get();

        $floors = Floor::with('building')

            ->when($request->search, function ($q) use ($request) {

                $q->where('floor_number', 'like', '%' . $request->search . '%');
            })

            ->when($request->building_id, function ($q) use ($request) {

                $q->where('building_id', $request->building_id);
            })

            ->orderBy('building_id')
            ->orderBy('floor_number')

            ->paginate($perPage)
            ->withQueryString();

        return view(
            'pages.admin.floors.index',
            compact('floors', 'buildings')
        );
    }

    public function create()
    {
        $buildings = Building::where('is_active', true)->get();

        return view('pages.admin.floors.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,building_id',
            'floor_number' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:0',
            'monthly_price' => 'required|integer|min:0',
            'room_capacity' => 'required|integer|min:1',
        ]);

        $building = Building::findOrFail($request->building_id);

        if ($request->floor_number > $building->total_floors) {
            return back()
                ->withInput()
                ->with('error', 'Nomor lantai tidak boleh melebihi total lantai gedung.');
        }

        $exists = Floor::where('building_id', $request->building_id)
            ->where('floor_number', $request->floor_number)
            ->where('floor_id', '!=', $request->floor_id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Nomor lantai tersebut sudah ada di gedung ini.');
        }

        Floor::create($request->only([
            'building_id',
            'floor_number',
            'total_rooms',
            'monthly_price',
            'room_capacity',
        ]));

        return redirect()
            ->route('admin.floors.index')
            ->with('success', 'Lantai berhasil ditambahkan.');
    }

    public function show(Floor $floor)
    {
        $floor->load('building');

        return view('pages.admin.floors.show', compact('floor'));
    }

    public function edit(Floor $floor)
    {
        $floor->load('building');

        $buildings = Building::where('is_active', true)->get();

        return view('pages.admin.floors.edit', compact('floor', 'buildings'));
    }

    public function update(Request $request, Floor $floor)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,building_id',
            'floor_number' => 'required|integer|min:1',
            'total_rooms' => 'required|integer|min:0',
            'monthly_price' => 'required|integer|min:0',
            'room_capacity' => 'required|integer|min:1',
        ]);

        // $building = Building::findOrFail($request->building_id);
        $building = Building::where('building_id', $request->building_id)->firstOrFail();

        if ($request->floor_number > $building->total_floors) {
            return back()
                ->withInput()
                ->with('error', 'Nomor lantai tidak boleh melebihi total lantai gedung.');
        }

        $exists = Floor::where('building_id', $request->building_id)
            ->where('floor_number', $request->floor_number)
            // ->where('floor_id', '!=', $floor->floor_id)
            ->where('floor_id', '!=', $floor->getKey())
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Nomor lantai tersebut sudah ada di gedung ini.');
        }

        $floor->update($request->only([
            'building_id',
            'floor_number',
            'total_rooms',
            'monthly_price',
            'room_capacity',
        ]));

        return redirect()
            ->route('admin.floors.index')
            ->with('success', 'Lantai berhasil diperbarui.');
    }

    public function destroy(Floor $floor)
    {
        $building = $floor->building;

        $floor->delete();

        if ($building) {
            $building->update([
                'total_floors' => $building->floors()->count(),
            ]);
        }

        return redirect()
            ->route('admin.floors.index')
            ->with('success', 'Lantai berhasil dihapus.');
    }
}
