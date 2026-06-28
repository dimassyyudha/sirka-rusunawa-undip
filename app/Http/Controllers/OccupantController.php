<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Occupant;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;

class OccupantController extends Controller
{
    public function index()
    {
        $occupants = Occupant::with(['user.studentProfile', 'room.floor.building', 'reservation'])
            ->latest()
            ->paginate(10);

        return view('admin.occupants.index', compact('occupants'));
    }

    public function create()
    {
        $users = User::where('role', 'mahasiswa')
            ->with('studentProfile')
            ->orderBy('name')
            ->get();

        $rooms = Room::with('floor.building')
            ->orderBy('kode_kamar')
            ->get();

        return view('admin.occupants.create', compact('users', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'room_id' => ['required', 'exists:rooms,room_id'],
            'reservation_id' => ['nullable', 'exists:reservations,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,ended,moved,cancelled'],
        ]);

        Occupant::create($validated);

        return redirect()
            ->route('admin.occupants.index')
            ->with('success', 'Data penghuni berhasil ditambahkan.');
    }

    public function show(Occupant $occupant)
    {
        $occupant->load(['user.studentProfile', 'room.floor.building', 'reservation']);

        return view('admin.occupants.show', compact('occupant'));
    }

    public function edit(Occupant $occupant)
    {
        $users = User::where('role', 'mahasiswa')
            ->with('studentProfile')
            ->orderBy('name')
            ->get();

        $rooms = Room::with('floor.building')
            ->orderBy('kode_kamar')
            ->get();

        return view('admin.occupants.edit', compact('occupant', 'users', 'rooms'));
    }

    public function update(Request $request, Occupant $occupant)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'room_id' => ['required', 'exists:rooms,room_id'],
            'reservation_id' => ['nullable', 'exists:reservations,id'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:active,ended,moved,cancelled'],
        ]);

        $occupant->update($validated);

        return redirect()
            ->route('admin.occupants.index')
            ->with('success', 'Data penghuni berhasil diperbarui.');
    }

    public function destroy(Occupant $occupant)
    {
        $occupant->delete();

        return redirect()
            ->route('admin.occupants.index')
            ->with('success', 'Data penghuni berhasil dihapus.');
    }
}
