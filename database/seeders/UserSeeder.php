<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Setup Folder & Gambar Sumber
        $path = public_path('uploads/profile_pictures');
        if (!File::exists($path)) File::makeDirectory($path, 0777, true, true);
        $sourceImage = public_path('assets-admin/images/faces/2');
        $hasSource = File::exists($sourceImage);

        // 1. Akun Admin Utama (Agar bisa login)
        User::create([
            'name'     => 'Dzakwan',
            'email'    => 'admin@desa.id',
            'password' => Hash::make('admin'),
            'role'     => 'admin',
        ]);
        // 2. Loop 50 Data Dummy
        for ($i = 1; $i <= 50; $i++) {
            $filename = null;

            // 20 Data Pertama: Pakai Foto
            if ($i <= 20 && $hasSource) {
                $filename = 'dummy_user_' . $i . '_' . time() . '.png';
                File::copy($sourceImage, $path . '/' . $filename);
            }

            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role' => $faker->randomElement(['staff', 'kades']),
                'profile_photo' => $filename, // Simpan nama file
            ]);
        }
    }
}