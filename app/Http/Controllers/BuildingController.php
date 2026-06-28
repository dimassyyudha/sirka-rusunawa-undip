<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BuildingController extends Controller
{
    // public function index()
    // {
    //     $buildings = Building::withCount([
    //         'floors as total_rooms' => function ($query) {
    //             $query->join('rooms', 'rooms.floor_id', '=', 'floors.id');
    //         }
    //     ])->with('floors')
    //         ->orderBy('code')
    //         ->get();

    //     return view('pages.admin.buildings.index', compact('buildings'));
    // }

    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);

        // $buildings = Building::withCount('rooms')
        //     ->orderBy('code')
        //     ->paginate($perPage)
        //     ->withQueryString();

        $buildings = Building::query()

            ->when($request->search, function ($q) use ($request) {

                $q->where(function ($query) use ($request) {

                    $query
                        ->where('code', 'like', '%' . $request->search . '%')
                        ->orWhere('name', 'like', '%' . $request->search . '%');
                });
            })

            ->when($request->filled('gender_type'), function ($q) use ($request) {

                $q->where('gender_type', $request->gender_type);
            })

            ->when($request->filled('is_active'), function ($q) use ($request) {

                $q->where('is_active', $request->is_active);
            })

            ->orderBy('code')
            ->paginate($perPage)
            ->withQueryString();

        return view('pages.admin.buildings.index', compact('buildings'));
    }

    public function create()
    {
        return view('pages.admin.buildings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:20|unique:buildings,code',
            'gender_type' => 'required|in:Laki-Laki,Perempuan',
            'total_floors' => 'required|integer|min:1',
        ]);

        Building::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'gender_type' => $request->gender_type,
            'total_floors' => $request->total_floors,
            'is_active' => true,
        ]);

        return redirect()
            ->route('admin.buildings.index')
            ->with('success', 'Gedung berhasil ditambahkan.');
    }

    public function show(Building $building)
    {
        $building->load('floors.rooms');

        return view('pages.admin.buildings.show', compact('building'));
    }

    public function edit(Building $building)
    {
        return view('pages.admin.buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('buildings', 'code')
                    ->ignore($building->building_id, 'building_id'),
            ],
            'gender_type' => 'required|in:Laki-Laki,Perempuan',
            'total_floors' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $building->update([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'gender_type' => $request->gender_type,
            'total_floors' => $request->total_floors,
            'is_active' => $request->is_active,
        ]);

        return redirect()
            ->route('admin.buildings.index')
            ->with('success', 'Gedung berhasil diperbarui.');
    }

    public function destroy(Building $building)
    {
        $building->delete();

        return redirect()
            ->route('admin.buildings.index')
            ->with('success', 'Gedung berhasil dihapus.');
    }
}
