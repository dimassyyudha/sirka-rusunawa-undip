<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aset;
use App\Models\KategoriAset;
use App\Models\Media; // Import Model Media
use Faker\Factory as Faker;
use Illuminate\Support\Facades\File; // Import Facade File

class AsetSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ambil ID Kategori
        $kategoriIds = KategoriAset::pluck('kategori_id')->toArray();
        if (empty($kategoriIds)) {
            $this->command->error('Error: Kategori kosong!');
            return;
        }

        // Pastikan folder uploads ada
        $uploadPath = public_path('uploads');
        if (!File::exists($uploadPath)) {
            File::makeDirectory($uploadPath, 0777, true, true);
        }

        // --- SUMBER GAMBAR DUMMY ---
        // Kita pinjam gambar logo/default template untuk dijadikan dummy aset
        // Pastikan path ini benar ada di laptop Anda
        $sourceImage = public_path('assets-admin/images/seed/office.jpg');

        // Jika file logo tidak ada, kode akan skip proses copy agar tidak error
        $hasSourceImage = File::exists($sourceImage);

        $namaBarang = [
            'Laptop Asus ROG', 'Macbook Pro M1', 'Kamera Canon EOS',
            'Proyektor Sony', 'Meja Rapat Oval', 'Kursi Direktur',
            'Lemari Besi', 'Brankas Uang', 'AC Panasonic 2PK',
            'Motor Honda Vario', 'Mobil Avanza Dinas', 'Server Rakitan'
        ];

        for ($i = 1; $i <= 50; $i++) {

            // 1. BUAT DATA ASET
            $aset = Aset::create([
                'kode_aset'       => 'AST-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'nama_aset'       => $faker->randomElement($namaBarang) . ' #' . $i,
                'kategori_id'     => $faker->randomElement($kategoriIds),
                'tgl_perolehan'   => $faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
                'nilai_perolehan' => $faker->numberBetween(1000000, 25000000),
                'kondisi'         => $faker->randomElement(['Baik', 'Rusak Ringan', 'Rusak Berat']),
            ]);

            // 2. KHUSUS 20 DATA PERTAMA: BUATKAN FOTO DUMMY
            if ($i <= 20 && $hasSourceImage) {

                // Buat nama file unik baru
                $newFileName = 'dummy_aset_' . $i . '_' . time() . '.png';

                // Copy file dari sumber (logo) ke folder uploads
                File::copy($sourceImage, public_path('uploads/' . $newFileName));

                // Input ke tabel Media
                Media::create([
                    'ref_table' => 'aset',           // Table tujuan
                    'ref_id'    => $aset->aset_id,   // ID Aset yang baru dibuat
                    'file_name' => $newFileName,
                    'mime_type' => 'image/png',
                    'caption'   => 'Foto Aset Dummy ' . $i,
                    'sort_order'=> 0
                ]);
            }
        }
    }
}
