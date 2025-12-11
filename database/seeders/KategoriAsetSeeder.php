<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriAset;
use Faker\Factory as Faker;
use Illuminate\Support\Str; // <--- BARIS INI YANG KURANG SEBELUMNYA

class KategoriAsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat Kategori Tetap (Static)
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
            KategoriAset::create([
                'nama' => $kategori['nama'],
                'kode' => $kategori['kode'],
                'deskripsi' => 'Kategori aset untuk ' . $kategori['nama'],
            ]);
        }

        // 2. Buat Kategori Dummy Tambahan (50 Data)
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            KategoriAset::create([
                'kode' => Str::upper($faker->bothify('KAT-###')), // Sekarang Str sudah dikenali
                'nama' => $faker->word . ' ' . $faker->randomElement(['Elektronik', 'Mebel', 'Kendaraan', 'Mesin']),
                'deskripsi' => $faker->sentence,
            ]);
        }
    }
}