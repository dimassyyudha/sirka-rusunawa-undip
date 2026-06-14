<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriAset;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class CreateKategoriAsetDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker dengan locale Indonesia (opsional, tapi disarankan)
        $faker = Faker::create('id_ID');

        // Loop untuk membuat 100 data
        for ($i = 1; $i <= 50; $i++) {

            // 1. Generate Nama Kategori unik (misalnya: Kursi Kantor, Alat Kebersihan Publik)
            $namaUnik = $faker->unique()->word() . ' ' . $faker->randomElement(['Kantor', 'Desa', 'Peralatan', 'Inventaris', 'Publik']);

            // 2. Generate Kode Unik 5 karakter (misalnya: HGR12, KPL45)
            // Menggunakan unique() pada Faker untuk menjamin kode tidak ada yang sama dalam 100 loop ini
            $kodeUnik = Str::upper($faker->unique()->lexify('???') . $faker->randomNumber(2, true));

            KategoriAset::create([
                'nama' => $namaUnik,
                'kode' => $kodeUnik,
                'deskripsi' => $faker->sentence(10), // Deskripsi acak 10 kata
            ]);
        }

        // Opsional: Tambahkan 1 kategori utama manual agar lebih mudah diuji
        KategoriAset::create([
            'nama' => 'Peralatan Testing Manual',
            'kode' => 'TST01',
            'deskripsi' => 'Kategori khusus untuk pengujian manual.',
        ]);
    }
}
