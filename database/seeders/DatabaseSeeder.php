<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([

            BuildingSeeder::class,
            FloorSeeder::class,
            RoomSeeder::class,
            RoomPhotoSeeder::class,

            UserSeeder::class,

            OccupancyPeriodSeeder::class,

            OccupantSeeder::class,

            RecommendationSeeder::class,
            TestimonialSeeder::class,

            FaqSeeder::class,
            AlurSeeder::class,
            FooterSeeder::class,
        ]);
    }
}
