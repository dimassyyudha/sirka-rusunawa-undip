<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LokasiAset;
use App\Models\Aset;
use App\Models\Media;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\File;

class LokasiAsetSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $asetIds = Aset::pluck('aset_id')->toArray();

        if (empty($asetIds)) return;

        $path = public_path('uploads/lokasi');
        if (!File::exists($path)) File::makeDirectory($path, 0777, true, true);
        $sourceImage = public_path('assets-admin/images/seed/pcr.jpg');
        $hasSource = File::exists($sourceImage);

        for ($i = 1; $i <= 50; $i++) {
            $lokasi = LokasiAset::create([
                'aset_id' => $faker->randomElement($asetIds),
                'lokasi_text' => $faker->address,
                'rt' => str_pad($faker->numberBetween(1, 10), 3, '0', STR_PAD_LEFT),
                'rw' => str_pad($faker->numberBetween(1, 5), 3, '0', STR_PAD_LEFT),
                'keterangan' => $faker->sentence,
            ]);

            // 20 Data Pertama: Foto Denah
            if ($i <= 20 && $hasSource) {
                $fileName = 'dummy_lokasi_' . $i . '.png';
                File::copy($sourceImage, $path . '/' . $fileName);

                Media::create([
                    'ref_table' => 'lokasi_aset',
                    'ref_id' => $lokasi->lokasi_id,
                    'file_name' => $fileName,
                    'mime_type' => 'image/png',
                    'caption' => 'Denah Lokasi',
                    'sort_order' => 1
                ]);
            }
        }
    }
}