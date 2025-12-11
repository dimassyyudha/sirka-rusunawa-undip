<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriAset;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class KategoriAsetSeeder extends Seeder
{
    public function run(): void
    {
        $daftarKategori = [
            ['nama' => 'Elektronik', 'kode' => 'ELK'],
            ['nama' => 'Furniture Kantor', 'kode' => 'FUR'],
            ['nama' => 'Kendaraan Dinas', 'kode' => 'KND'],
            ['nama' => 'Alat Tulis Kantor', 'kode' => 'ATK'],
            ['nama' => 'Peralatan Kebersihan', 'kode' => 'KBR'],
            ['nama' => 'Mesin & Alat Berat', 'kode' => 'MSN'],
            ['nama' => 'Tanah & Bangunan', 'kode' => 'TNB'],
            ['nama' => 'Aset Tak Berwujud', 'kode' => 'ATB'],
        ];

        foreach ($daftarKategori as $kategori) {
            KategoriAset::firstOrCreate(
                ['kode' => $kategori['kode']],
                [
                    'nama' => $kategori['nama'],
                    'deskripsi' => 'Kategori aset untuk ' . $kategori['nama']
                ]
            );
        }

        // 2. Kategori Dummy Tambahan (50 Data)
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            $kodeUnik = Str::upper($faker->unique()->bothify('KAT-###'));

            KategoriAset::create([
                'kode' => $kodeUnik,
                'nama' => $faker->word . ' ' . $faker->randomElement(['Elektronik', 'Mebel', 'Kendaraan', 'Mesin']),
                'deskripsi' => $faker->sentence,
            ]);
        }
    }
}