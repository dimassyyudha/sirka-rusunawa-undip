<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\StudentProfile;
use Illuminate\Database\Seeder;

class StudentProfileSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'mahasiswa')->get();

        foreach ($users as $index => $user) {

            StudentProfile::updateOrCreate(

                [
                    'user_id' => $user->user_id,
                ],

                [
                    'nim' => '2406012' . str_pad($index + 1, 5, '0', STR_PAD_LEFT),

                    'fakultas' => 'FSM',

                    'jurusan' => 'Informatika',

                    'angkatan' => 2024,

                    'alamat' => fake()->address(),

                    'nama_ortu' => fake()->name(),

                    'no_hp_ortu' => '08' . fake()->numerify('##########'),

                    'jalur_pembiayaan' => fake()->boolean(30)
                        ? 'Bidikmisi/KIP-K'
                        : 'Non-Bidikmisi/KIP-K',

                    'status_mahasiswa' => 'tidak_penghuni',

                    // isi jika room_id nullable
                    'room_id' => null,
                ]
            );
        }
    }
}
