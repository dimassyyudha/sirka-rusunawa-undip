<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // MASTER DATA KAMAR DULU
            BuildingSeeder::class,
            FloorSeeder::class,
            RoomSeeder::class,
            RoomPhotoSeeder::class,

            // USER & PROFILE
            UserSeeder::class,
            // StudentProfileSeeder::class,

            // DATA TRANSAKSI / PENGHUNI

            ReservationSeeder::class,
            RoomReviewSeeder::class,
            RecommendationSeeder::class,
            // OccupantSeeder::class,
            // LANDING PAGE CONTENT
           
            FaqSeeder::class,
            AlurSeeder::class,
            FooterSeeder::class,
        ]);
    }
}
