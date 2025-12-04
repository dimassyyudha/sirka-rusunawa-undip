<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class CreateKategoriAsetDummy extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        // Kita buat data kategori yang "masuk akal" untuk aplikasi Inventaris
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
            DB::table('kategori_aset')->insert([
                // 'nama' VARCHAR(100)
                'nama' => $kategori['nama'],

                // 'kode' VARCHAR(20) - Harus Unik
                'kode' => $kategori['kode'],

                // 'deskripsi' TEXT
                'deskripsi' => 'Kategori untuk ' . $kategori['nama'] . '. ' . $faker->sentence(10),

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
