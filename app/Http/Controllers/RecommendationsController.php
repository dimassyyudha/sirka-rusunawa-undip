<?php

namespace App\Http\Controllers;

use App\Models\Recommendation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RecommendationsController extends Controller
{
    public function index()
    {
        $items = Recommendation::with('room.floor.building')
            ->orderBy('sort_order', 'asc')
            ->get();

        return view('pages.admin.recommendation.index', compact('items'));
    }

    public function create()
    {
        $rooms = Room::with('floor.building')
            ->get()
            ->sortBy([
                fn ($a, $b) => strcmp($a->floor?->building?->name ?? '', $b->floor?->building?->name ?? ''),
                fn ($a, $b) => ($a->floor?->floor_number ?? 0) <=> ($b->floor?->floor_number ?? 0),
                fn ($a, $b) => strcmp($a->kode_kamar ?? '', $b->kode_kamar ?? ''),
            ])
            ->values();

        $nextOrder = (int) (Recommendation::max('sort_order') ?? 0) + 1;

        return view('pages.admin.recommendation.create', compact('rooms', 'nextOrder'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'sort_order' => ['required', 'integer', 'min:1', 'unique:recommendations,sort_order'],
            'is_active' => ['nullable', 'boolean'],
            'badge' => ['nullable', 'string', 'max:50'],
        ], [
            'sort_order.unique' => 'Nomor urut sudah dipakai.',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        Recommendation::create($data);

        return redirect()
            ->route('admin.settings.recommendation.index')
            ->with('success', 'Rekomendasi berhasil ditambahkan.');
    }

    public function edit(Recommendation $recommendation)
    {
        $rooms = Room::with('floor.building')
            ->get()
            ->sortBy([
                fn ($a, $b) => strcmp($a->floor?->building?->name ?? '', $b->floor?->building?->name ?? ''),
                fn ($a, $b) => ($a->floor?->floor_number ?? 0) <=> ($b->floor?->floor_number ?? 0),
                fn ($a, $b) => strcmp($a->kode_kamar ?? '', $b->kode_kamar ?? ''),
            ])
            ->values();

        $item = $recommendation->load('room.floor.building');

        return view('pages.admin.recommendation.edit', compact('rooms', 'item'));
    }

    public function update(Request $request, Recommendation $recommendation)
    {
        $data = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'sort_order' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('recommendations', 'sort_order')->ignore($recommendation->id),
            ],
            'is_active' => ['nullable', 'boolean'],
            'badge' => ['nullable', 'string', 'max:50'],
        ], [
            'sort_order.unique' => 'Nomor urut sudah dipakai.',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $recommendation->update($data);

        return redirect()
            ->route('admin.settings.recommendation.index')
            ->with('success', 'Rekomendasi berhasil diupdate.');
    }

    public function destroy(Recommendation $recommendation)
    {
        $recommendation->delete();

        return redirect()
            ->route('admin.settings.recommendation.index')
            ->with('success', 'Rekomendasi berhasil dihapus.');
    }
}