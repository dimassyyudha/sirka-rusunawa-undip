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

        // Setup Folder Upload
        $destinationPath = public_path('uploads/profile_pictures');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0777, true, true);
        }

        // ----------------------------------------------------
        // 1. Akun Admin Utama (Dzakwan)
        // ----------------------------------------------------

        $myPhotoName = null;
        $sourceMyPhoto = public_path('assets-admin/images/faces/my-photo.png');

        if (File::exists($sourceMyPhoto)) {
            $myPhotoName = 'admin_dzakwan_' . time() . '.png';
            File::copy($sourceMyPhoto, $destinationPath . '/' . $myPhotoName);
        }

        User::create([
            'name'          => 'Dzakwan',
            'email'         => 'admin@desa.id',
            'password'      => Hash::make('admin'),
            'role'          => 'admin',
            'profile_photo' => $myPhotoName
        ]);

        // ----------------------------------------------------
        // 2. Loop 50 Data Dummy Lainnya
        // ----------------------------------------------------

        $sourceDummy = public_path('assets-admin/images/faces/2.jpg');
        $hasDummySource = File::exists($sourceDummy);

        for ($i = 1; $i <= 50; $i++) {
            $filename = null;

            // 20 Data Pertama: Pakai Foto Dummy
            if ($i <= 20 && $hasDummySource) {
                $filename = 'dummy_user_' . $i . '_' . time() . '.jpg';
                File::copy($sourceDummy, $destinationPath . '/' . $filename);
            }

            User::create([
                'name'     => $faker->name,
                'email'    => $faker->unique()->safeEmail,
                'password' => Hash::make('password'),
                'role'     => $faker->randomElement(['staff', 'kades']),
                'profile_photo' => $filename,
            ]);
        }
    }
}