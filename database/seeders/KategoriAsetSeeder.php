<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriAset;

class KategoriAsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
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
            KategoriAset::create([
                'nama' => $kategori['nama'],
                'kode' => $kategori['kode'],
                'deskripsi' => 'Kategori aset untuk ' . $kategori['nama'],
            ]);
        }
    }
}
