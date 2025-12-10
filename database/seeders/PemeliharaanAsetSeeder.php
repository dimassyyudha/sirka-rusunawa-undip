<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PemeliharaanAset;
use App\Models\Aset;
use App\Models\Media;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\File;

class PemeliharaanAsetSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $asetIds = Aset::pluck('aset_id')->toArray();

        if (empty($asetIds)) return;

        $path = public_path('uploads/pemeliharaan');
        if (!File::exists($path)) File::makeDirectory($path, 0777, true, true);
        $sourceImage = public_path('assets-admin/images/seed/pemeliharaan.jpg');
        $hasSource = File::exists($sourceImage);

        for ($i = 1; $i <= 50; $i++) {
            $mtc = PemeliharaanAset::create([
                'aset_id' => $faker->randomElement($asetIds),
                'tanggal' => $faker->dateTimeBetween('-1 year', 'now'),
                'tindakan' => $faker->sentence(5),
                'biaya' => $faker->numberBetween(50000, 2000000),
                'pelaksana' => $faker->company,
            ]);

            // 20 Data Pertama: Bukti Foto (Bisa lebih dari 1 file)
            if ($i <= 20 && $hasSource) {
                $fileName = 'dummy_mtc_' . $i . '.png';
                File::copy($sourceImage, $path . '/' . $fileName);

                Media::create([
                    'ref_table' => 'pemeliharaan_aset',
                    'ref_id' => $mtc->pemeliharaan_id,
                    'file_name' => $fileName,
                    'mime_type' => 'image/png',
                    'caption' => 'Bukti Pengerjaan',
                    'sort_order' => 1
                ]);
            }
        }
    }
}