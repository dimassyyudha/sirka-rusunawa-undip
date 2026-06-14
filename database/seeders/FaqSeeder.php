<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'question' => 'Bagaimana cara melakukan reservasi kamar?',
                'answer' => 'Pilih kamar pada halaman pencarian, lalu klik "Lihat Detail" dan ajukan reservasi dengan mengisi data yang diminta.',
                'is_featured' => true,
            ],
            [
                'question' => 'Berapa biaya sewa kamar di Rusunawa?',
                'answer' => 'Biaya sewa berbeda tergantung tipe kamar dan fasilitas. Silakan cek detail kamar untuk informasi harga terbaru.',
                'is_featured' => true,
            ],
            [
                'question' => 'Apakah bisa memilih kamar sendiri?',
                'answer' => 'Ya, kamu bisa memilih kamar yang tersedia sesuai preferensi saat melakukan reservasi.',
                'is_featured' => true,
            ],
            [
                'question' => 'Bagaimana cara melakukan pembayaran?',
                'answer' => 'Pembayaran dilakukan melalui sistem setelah reservasi berhasil diajukan.',
                'is_featured' => true,
            ],
            [
                'question' => 'Apakah bisa memperpanjang masa sewa?',
                'answer' => 'Bisa. Penghuni dapat mengajukan perpanjangan langsung melalui sistem.',
                'is_featured' => false,
            ],
            [
                'question' => 'Apa saja fasilitas yang tersedia di Rusunawa?',
                'answer' => 'Fasilitas meliputi kamar tidur, kamar mandi, area parkir, dan fasilitas umum lainnya.',
                'is_featured' => false,
            ],
        ];

        // tambahkan sort_order otomatis
        $items = collect($items)->map(function ($item, $index) {
            return [
                'question'   => $item['question'],
                'answer'     => $item['answer'],
                'sort_order' => $index + 1,
                'is_active'  => true,
                'is_featured'=> $item['is_featured'],
            ];
        })->toArray();

        $payload = [
            'title' => 'Pertanyaan yang Sering Diajukan',
            'subtitle' => 'Temukan jawaban atas pertanyaan umum seputar Rusunawa UNDIP.',
            'items' => $items,
        ];

        DB::table('site_settings')->updateOrInsert(
            ['key' => 'faq'],
            [
                'value' => json_encode($payload, JSON_UNESCAPED_UNICODE),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

    }
}