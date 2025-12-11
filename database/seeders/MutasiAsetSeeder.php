<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MutasiAset;
use App\Models\Aset;
use Faker\Factory as Faker;

class MutasiAsetSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $asetIds = Aset::pluck('aset_id')->toArray();

        if (empty($asetIds)) return;

        // Daftar Enum Baru
        $jenisList = ['Pemindahan', 'Penghapusan', 'Perubahan Status', 'Peminjaman', 'Pengembalian'];

        for ($i = 1; $i <= 50; $i++) {
            MutasiAset::create([
                'aset_id' => $faker->randomElement($asetIds),
                'tanggal' => $faker->dateTimeBetween('-6 months', 'now'),
                'jenis_mutasi' => $faker->randomElement($jenisList), // Pakai list baru
                'keterangan' => $faker->sentence,
            ]);
        }
    }
}