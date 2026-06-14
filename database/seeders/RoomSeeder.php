<?php

namespace Database\Seeders;

use App\Models\Floor;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::query()->delete();
        $fasilitas = [
            'A' => "KM luar\nFree Wifi, air, listrik\nBus kampus\nKasur\nLemari\nMeja, kursi",

            'B' => "Free air, listrik, wifi\nKasur Springbed\nMeja, Almari, kursi\nKamar Mandi Dalam\nKeamanan 24 jam\nBus Kampus gratis",

            'C' => "KM Dalam\nFree Wifi, air, listrik\nKasur Busa\nMeja, kursi, Almari\nBus kampus",

            'D' => "KM Dalam\nFree Wifi, air, listrik\nKasur Busa\nMeja, kursi, Almari\nBus kampus",

            'E' => "KM Dalam\nKasur\nMeja, kursi, Almari\nFree Wifi, air, listrik\nBus Kampus",

            'F' => "KM Dalam\nFree Wifi, air, listrik\nKasur Busa\nMeja, kursi, Almari\nBus kampus",
        ];

        $floors = Floor::with('building')->get();

        foreach ($floors as $floor) {

            $buildingCode = strtoupper(
                $floor->building->code
            );

            for (
                $roomIndex = 1;
                $roomIndex <= $floor->total_rooms;
                $roomIndex++
            ) {

                $kodeKamar =
                    $buildingCode .
                    '-' .
                    $floor->floor_number .
                    str_pad(
                        $roomIndex,
                        2,
                        '0',
                        STR_PAD_LEFT
                    );

                Room::updateOrCreate(
                    [
                        'kode_kamar' => $kodeKamar,
                    ],
                    [
                        'floor_id' => $floor->id,

                        // AWAL SEMUA KOSONG
                        'occupied' => 0,

                        'fasilitas' => $fasilitas[$buildingCode],

                        'status' => 'tersedia',
                    ]
                );
            }
        }
    }
}
