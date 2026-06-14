<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Room;
use App\Models\RoomPhoto;

class RoomPhotoSeeder extends Seeder
{
    public function run(): void
    {
        RoomPhoto::truncate();

        // Gedung → folder
        $folderMap = [
            'A' => 'a',
            'B' => 'b',
            'C' => 'c',
            'D' => 'd',
            'E' => 'e',
            'F' => 'f',
        ];

        $exts = ['jpg','jpeg','png','webp'];

        foreach (Room::all() as $room) {
            // normalisasi gedung ("Gedung A" / "A" → "A")
            $gedung = strtoupper(preg_replace('/^Gedung\s+/i', '', (string) $room->gedung));
            $folder = $folderMap[$gedung] ?? null;
            if (! $folder) continue;

            // bikin 3 foto random per kamar, tapi tetap di folder gedung yg sama
            $seed = crc32((string)($room->id ?? $room->kode_kamar));
            $base = ($seed % 6) + 1; // 1..6

            $indexes = [
                $base,
                ($base % 6) + 1,
                (($base + 1) % 6) + 1,
            ];

            $order = 1;

            foreach (array_unique($indexes) as $idx) {
                $relPath = null;

                foreach ($exts as $ext) {
                    // >>> PATH SESUAI STRUKTURMU
                    $candidate = "images/{$folder}/{$folder}{$idx}.{$ext}";
                    if (File::exists(public_path($candidate))) {
                        $relPath = $candidate;
                        break;
                    }
                }

                if (! $relPath) continue;

                RoomPhoto::create([
                    'room_id'    => $room->id,
                    'path'       => $relPath,     // contoh: images/a/a3.jpg
                    'is_primary' => $order === 1,
                    'order'      => $order,
                ]);

                // isi kolom rooms.foto utk fallback (optional)
                if ($order === 1) {
                    $room->update(['foto' => $relPath]);
                }

                $order++;
            }
        }
    }
}