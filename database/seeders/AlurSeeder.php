<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AlurSeeder extends Seeder
{
    public function run(): void
    {
        $payload = [
            'badge' => 'Cara Reservasi',
            'title' => 'Alur Reservasi Kamar Rusunawa',
            'description' => 'Ikuti langkah-langkah berikut untuk melakukan reservasi kamar di Rusunawa UNDIP secara mudah, transparan, dan terstruktur.',
            'steps' => [
                [
                    'title' => 'Pilih Kamar',
                    'desc' => 'Mahasiswa dapat melihat daftar kamar yang tersedia melalui sistem. Informasi seperti gedung, lantai, kapasitas, dan harga ditampilkan secara lengkap untuk membantu dalam memilih kamar yang sesuai dengan kebutuhan dan preferensi.',
                    'sort_order' => 1,
                    'is_active' => true,
                ],
                [
                    'title' => 'Ajukan Reservasi',
                    'desc' => 'Setelah menemukan kamar yang diinginkan, mahasiswa dapat langsung mengajukan reservasi dengan mengisi formulir yang telah disediakan. Pastikan seluruh data yang diinput sudah benar dan sesuai dengan identitas resmi.',
                    'sort_order' => 2,
                    'is_active' => true,
                ],
                [
                    'title' => 'Lengkapi Data & Dokumen',
                    'desc' => 'Mahasiswa diwajibkan melengkapi data tambahan serta mengunggah dokumen pendukung seperti KTP, KTM, atau dokumen lain yang dibutuhkan sebagai syarat administrasi untuk proses verifikasi.',
                    'sort_order' => 3,
                    'is_active' => true,
                ],
                [
                    'title' => 'Lakukan Pembayaran',
                    'desc' => 'Setelah reservasi disetujui, mahasiswa akan mendapatkan informasi tagihan. Pembayaran dapat dilakukan melalui metode yang tersedia pada sistem sesuai dengan nominal yang tertera.',
                    'sort_order' => 4,
                    'is_active' => true,
                ],
                [
                    'title' => 'Proses Verifikasi',
                    'desc' => 'Tim pengelola Rusunawa akan melakukan pengecekan terhadap data dan dokumen yang telah dikirimkan. Proses ini memastikan bahwa seluruh informasi valid dan sesuai dengan ketentuan yang berlaku.',
                    'sort_order' => 5,
                    'is_active' => true,
                ],
                [
                    'title' => 'Kamar Siap Ditempati',
                    'desc' => 'Setelah pembayaran berhasil diverifikasi, status reservasi akan berubah menjadi aktif. Mahasiswa dapat segera menempati kamar sesuai dengan jadwal yang telah ditentukan oleh pengelola.',
                    'sort_order' => 6,
                    'is_active' => true,
                ],
            ],
        ];

        DB::table('site_settings')->updateOrInsert(
            ['key' => 'alur'],
            [
                'value' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

    }
}
