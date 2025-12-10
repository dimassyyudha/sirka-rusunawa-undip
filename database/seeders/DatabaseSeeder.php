<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            WargaSeeder::class,
            KategoriAsetSeeder::class,
            AsetSeeder::class,
            LokasiAsetSeeder::class,
            PemeliharaanAsetSeeder::class,
            MutasiAsetSeeder::class,   
        ]);
    }
}
