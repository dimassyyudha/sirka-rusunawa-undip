<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RoomPhotoController extends Controller
{
    /**
     * Opsional: Tampilkan semua foto semua kamar.
     */
    public function index()
    {
        $photos = RoomPhoto::with('room')
            ->orderBy('room_id')
            ->orderBy('order')
            ->get();

        // Kamu bisa bikin view admin.room_photos.index sendiri
        return view('admin.room_photos.index', compact('photos'));
    }

    /**
     * Simpan foto baru untuk kamar tertentu.
     * Bisa TERIMA BANYAK FILE sekaligus (photos[]).
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id'   => 'required|exists:rooms,room_id',
            'photos'    => 'required|array',
            'photos.*'  => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $room = Room::findOrFail($data['room_id']);

        $lastOrder = (int) RoomPhoto::where('room_id', $room->room_id)->max('order');
        $order     = $lastOrder;

        foreach ($request->file('photos') as $file) {
            $order++;

            $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $relativePath = 'uploads/rooms/' . $room->room_id . '/' . $filename;
            $destination  = public_path('uploads/rooms/' . $room->room_id);

            if (!is_dir($destination)) {
                mkdir($destination, 0775, true);
            }

            $file->move($destination, $filename);

            RoomPhoto::create([
                'room_id'    => $room->room_id,
                'path'       => $relativePath,
                'is_primary' => $order === 1 && $lastOrder === 0, // kalau belum ada foto, jadikan utama
                'order'      => $order,
            ]);
        }

        return back()->with('success', 'Foto kamar berhasil ditambahkan.');
    }

    /**
     * Hapus satu foto kamar.
     */
    public function destroy(RoomPhoto $roomPhoto)
    {
        $fullPath = public_path($roomPhoto->path);

        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }

        $roomPhoto->delete();

        return back()->with('success', 'Foto kamar berhasil dihapus.');
    }

    // method lain (create/show/edit/update) optional, bisa diisi nanti kalau perlu
}
