<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PemeliharaanAset;
use App\Models\Aset;
use App\Models\Media;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\File;

class PemeliharaanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $asetIds = Aset::pluck('aset_id')->toArray();

        if(empty($asetIds)) return;

        // Siapkan folder
        $uploadPath = public_path('uploads/pemeliharaan');
        if (!File::exists($uploadPath)) File::makeDirectory($uploadPath, 0777, true, true);

        // Gambar sumber (pastikan ada)
        $sourceImage = public_path('assets-admin/images/samples/tools.jpg'); // Ganti jika tidak ada, misal architecture1.jpg
        if (!File::exists($sourceImage)) {
             // Fallback
             $sourceImage = public_path('assets-admin/images/logo/logo.png');
        }

        for ($i = 0; $i < 10; $i++) {
            $mtc = PemeliharaanAset::create([
                'aset_id'   => $faker->randomElement($asetIds),
                'tanggal'   => $faker->dateTimeBetween('-1 year', 'now'),
                'tindakan'  => $faker->sentence(6),
                'biaya'     => $faker->numberBetween(50000, 5000000),
                'pelaksana' => $faker->company
            ]);

            // Buat 2-3 bukti foto per pemeliharaan
            for ($j = 1; $j <= rand(2, 3); $j++) {
                $fileName = 'dummy_mtc_' . $mtc->pemeliharaan_id . '_' . $j . '.jpg';
                if (File::exists($sourceImage)) {
                    File::copy($sourceImage, $uploadPath . '/' . $fileName);

                    Media::create([
                        'ref_table' => 'pemeliharaan_aset',
                        'ref_id'    => $mtc->pemeliharaan_id,
                        'file_name' => $fileName,
                        'mime_type' => 'image/jpeg',
                        'caption'   => 'Bukti ' . $j,
                        'sort_order'=> $j
                    ]);
                }
            }
        }
    }
}
