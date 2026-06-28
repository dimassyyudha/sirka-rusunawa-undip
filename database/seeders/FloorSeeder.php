<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'A' => [
                1 => ['rooms' => 28, 'price' => 800000, 'capacity' => 2],
                2 => ['rooms' => 28, 'price' => 800000, 'capacity' => 2],
                3 => ['rooms' => 28, 'price' => 800000, 'capacity' => 2],
            ],
            'B' => [
                1 => ['rooms' => 32, 'price' => 1400000, 'capacity' => 2],
                2 => ['rooms' => 32, 'price' => 1400000, 'capacity' => 2],
                3 => ['rooms' => 32, 'price' => 1400000, 'capacity' => 2],
            ],
            'C' => [
                1 => ['rooms' => 5, 'price' => 1250000, 'capacity' => 2],
                2 => ['rooms' => 32, 'price' => 1250000, 'capacity' => 2],
                3 => ['rooms' => 32, 'price' => 1250000, 'capacity' => 2],
                4 => ['rooms' => 32, 'price' => 1250000, 'capacity' => 2],
            ],
            'D' => [
                1 => ['rooms' => 7, 'price' => 1250000, 'capacity' => 2],
                2 => ['rooms' => 32, 'price' => 700000, 'capacity' => 2],
                3 => ['rooms' => 32, 'price' => 700000, 'capacity' => 2],
                4 => ['rooms' => 32, 'price' => 700000, 'capacity' => 2],
            ],
            'E' => [
                1 => ['rooms' => 18, 'price' => 1000000, 'capacity' => 2],
                2 => ['rooms' => 24, 'price' => 900000, 'capacity' => 2],
                3 => ['rooms' => 24, 'price' => 800000, 'capacity' => 2],
                4 => ['rooms' => 24, 'price' => 750000, 'capacity' => 2],
                5 => ['rooms' => 24, 'price' => 700000, 'capacity' => 2],
            ],
            'F' => [
                1 => ['rooms' => 13, 'price' => 1700000, 'capacity' => 3],
                2 => ['rooms' => 15, 'price' => 1700000, 'capacity' => 3],
                3 => ['rooms' => 15, 'price' => 1700000, 'capacity' => 3],
            ],
        ];

        foreach ($data as $buildingCode => $floors) {
            $building = Building::where('code', $buildingCode)->first();

            if (!$building) {
                continue;
            }

            foreach ($floors as $floorNumber => $floorData) {
                Floor::updateOrCreate(
                    [
                        'building_id' => $building->building_id,
                        'floor_number' => $floorNumber,
                    ],
                    [
                        'total_rooms' => $floorData['rooms'],
                        'monthly_price' => $floorData['price'],
                        'room_capacity' => $floorData['capacity'],
                    ]
                );
            }

            $building->update([
                'total_floors' => $building->floors()->count(),
            ]);
        }
    }
}