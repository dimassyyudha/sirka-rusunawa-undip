<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    // public function index()
    // {
    //     $floors = Floor::with('building')
    //         ->latest()
    //         ->get();

    //     return view('pages.admin.floors.index', compact('floors'));
    // }
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        $floors = Floor::with('building')
            ->orderBy('building_id')
            ->orderBy('floor_number')
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.admin.floors.index', compact('floors'));
    }

    public function create()
    {
        $buildings = Building::where('is_active', true)->get();

        return view('pages.admin.floors.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'building_id' => 'required|exists:buildings,id',
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
            'building_id' => 'required|exists:buildings,id',
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
            ->where('id', '!=', $floor->id)
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
