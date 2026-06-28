<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Pengelola Rusunawa',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'gender' => 'laki-laki',
                'number_phone' => '081234567890',
                'profile_photo' => '0',
            ],

        );


        // foreach ($mahasiswaList as $index => $data) {

        //     [$nama, $gender, $nim] = $data;

        //     $nomorUrut = $index + 1;

        //     $emailName = Str::slug($nama, '.');

        //     $user = User::updateOrCreate(
        //         ['email' => $emailName . '@gmail.com'],
        //         [
        //             'name' => $nama,
        //             'email' => $emailName . '@gmail.com',
        //             'password' => Hash::make('password'),
        //             'role' => 'mahasiswa',
        //             'gender' => $gender,
        //             'number_phone' => '08' . $faker->numerify('##########'),
        //             'profile_photo' => null,
        //         ]
        //     );

        //     StudentProfile::updateOrCreate(
        //         ['user_id' => $user->id],
        //         [
        //             'nim' => $nim,

        //             'fakultas' => 'FSM',
        //             'jurusan' => 'Informatika',
        //             'angkatan' => (int) substr($nim, 6, 4),

        //             'alamat' => $faker->address,
        //             'no_hp' => $user->number_phone,

        //             'nama_ortu' => $faker->name(),
        //             'no_hp_ortu' => '08' . $faker->numerify('##########'),

        //             'ktm_path' => null,

        //             'has_vehicle' => false,
        //             'vehicle_plate_number' => null,
        //             'stnk_path' => null,

        //             'status_mahasiswa' => 'tidak_penghuni',
        //             'room_id' => null,
        //         ]
        //     );
        // }
    }
}
