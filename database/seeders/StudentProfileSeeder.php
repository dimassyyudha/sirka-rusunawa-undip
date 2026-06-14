<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

use App\Models\User;
use App\Models\Room;
use App\Models\StudentProfile;

class StudentProfileSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        /*
        |--------------------------------------------------------------------------
        | Ambil semua mahasiswa
        |--------------------------------------------------------------------------
        */

        $users = User::where('role', 'mahasiswa')->get();

        /*
        |--------------------------------------------------------------------------
        | Ambil semua kamar
        |--------------------------------------------------------------------------
        */

        $rooms = Room::with('floor.building')->get();

        /*
        |--------------------------------------------------------------------------
        | List jurusan UNDIP
        |--------------------------------------------------------------------------
        */

        $jurusanList = [
            'Informatika',
            'Sistem Informasi',
            'Teknik Industri',
            'Teknik Elektro',
            'Teknik Mesin',
            'Teknik Sipil',
            'Arsitektur',
            'PWK',
            'Manajemen',
            'Akuntansi',
            'Ekonomi Islam',
            'Ilmu Hukum',
            'Administrasi Publik',
            'Administrasi Bisnis',
            'Ilmu Komunikasi',
            'Hubungan Internasional',
            'Keperawatan',
            'Kesehatan Masyarakat',
            'Gizi',
            'Kedokteran',
        ];

        foreach ($users as $index => $user) {

            /*
            |--------------------------------------------------------------------------
            | Tentukan gender dari nama / random
            |--------------------------------------------------------------------------
            */

            $gender = $faker->randomElement(['putra', 'putri']);

            /*
            |--------------------------------------------------------------------------
            | Reservasi Kamar sesuai gender
            |--------------------------------------------------------------------------
            */

            $selectedRoom = null;

            if ($gender === 'putra') {

                $availableRooms = $rooms->filter(function ($room) {

                    $buildingCode = strtoupper(
                        $room->floor?->building?->code ?? ''
                    );

                    return in_array($buildingCode, ['A', 'F']);
                });
            } else {

                $availableRooms = $rooms->filter(function ($room) {

                    $buildingCode = strtoupper(
                        $room->floor?->building?->code ?? ''
                    );

                    return in_array($buildingCode, ['B', 'C', 'D', 'E']);
                });
            }

            if ($availableRooms->count()) {
                $selectedRoom = $availableRooms->random();
            }

            /*
            |--------------------------------------------------------------------------
            | Create profile
            |--------------------------------------------------------------------------
            */

            StudentProfile::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'nim' => '2406012' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),

                    'jurusan' => $faker->randomElement($jurusanList),

                    'angkatan' => $faker->numberBetween(2021, 2024),

                    'alamat' => $faker->address,

                    'no_hp_ortu' => '08' . $faker->numerify('##########'),

                    'status_mahasiswa' => $faker->randomElement([
                        'penghuni',
                        'tidak_penghuni'
                    ]),

                    'room_id' => null,
                ]
            );
        }
    }
}
