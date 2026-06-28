<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;

class BuildingSeeder extends Seeder
{
    public function run(): void
    {
        $buildings = [
            ['code' => 'A', 'name' => 'Gedung A', 'gender_type' => 'Laki-Laki', 'prices' => [800000, 800000, 800000]],
            ['code' => 'B', 'name' => 'Gedung B', 'gender_type' => 'perempuan', 'prices' => [14000000, 1400000, 1400000]],
            ['code' => 'C', 'name' => 'Gedung C', 'gender_type' => 'perempuan', 'prices' => [900000, 850000, 800000]],
            ['code' => 'D', 'name' => 'Gedung D', 'gender_type' => 'perempuan', 'prices' => [1000000, 900000, 850000]],
            ['code' => 'E', 'name' => 'Gedung E', 'gender_type' => 'perempuan', 'prices' => [1000000, 900000, 800000, 750000, 700000]],
            ['code' => 'F', 'name' => 'Gedung F', 'gender_type' => 'Laki-Laki', 'prices' => [1700000, 1700000, 1600000]],
        ];

        foreach ($buildings as $b) {
            $building = Building::updateOrCreate(
                ['code' => $b['code']],
                [
                    'name' => $b['name'],
                    'gender_type' => $b['gender_type'],
                    'total_floors' => count($b['prices']),
                    'is_active' => true,
                ]
            );

            foreach ($b['prices'] as $index => $price) {
                $floorNumber = $index + 1;

                $floor = Floor::updateOrCreate(
                    [
                        'building_id' => $building->building_id,
                        'floor_number' => $floorNumber,
                    ],
                    [
                        'total_rooms' => 12,
                        'monthly_price' => $price,
                        'room_capacity' => $b['code'] === 'F' ? 3 : 2,
                    ]
                );

                for ($roomNo = 1; $roomNo <= 12; $roomNo++) {
                    $kode = $b['code'] . '-' . $floorNumber . str_pad($roomNo, 2, '0', STR_PAD_LEFT);

                    Room::updateOrCreate(
                        ['kode_kamar' => $kode],
                        [
                            'floor_id' => $floor->floor_id,
                            'occupied' => 0,
                            'fasilitas' => "Tempat tidur\nLemari\nMeja belajar\nKamar mandi bersama\nListrik",
                            'status' => 'tersedia',
                        ]
                    );
                }
            }
        }
    }
}
