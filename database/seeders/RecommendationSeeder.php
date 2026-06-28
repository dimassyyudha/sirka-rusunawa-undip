<?php

namespace Database\Seeders;

use App\Models\Recommendation;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RecommendationSeeder extends Seeder
{
    public function run(): void
    {
        Recommendation::truncate();

        $rooms = Room::with('floor.building')
            ->where('status', 'tersedia')
            ->get()
            ->filter(function ($room) {
                if (!$room->floor || !$room->floor->building) {
                    return false;
                }

                $capacity = (int) ($room->floor->room_capacity ?? 2);
                $occupied = (int) ($room->occupied ?? 0);

                return ($capacity - $occupied) > 0;
            })
            ->sortBy(fn($room) => $room->floor->monthly_price ?? 0)
            ->take(15)
            ->values();

        foreach ($rooms as $index => $room) {
            Recommendation::create([
                'room_id' => $room->room_id,
                'badge' => 'Rekomendasi',
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }
    }
}
