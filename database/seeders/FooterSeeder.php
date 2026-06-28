<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FooterSeeder extends Seeder
{
    public function run(): void
    {
        $payload = [
            'brand' => 'SIRKA Rusunawa UNDIP',
            'description' => 'Sistem Informasi Reservasi Kamar Rusunawa Universitas Diponegoro.',
            'whatsapp' => '+62 878-2130-5379',
            'whatsapp_link' => 'https://wa.me/6287821305379',
            'email' => 'rusunawa@undip.ac.id',
            'address' => 'Rusunawa UNDIP, Tembalang, Kota Semarang',
            'columns' => [
                [
                    'title' => 'Navigasi',
                    'links' => [
                        ['label' => 'Beranda', 'url' => '/'],
                        ['label' => 'Reservasi Kamar', 'url' => '/cari-kamar'],
                        ['label' => 'Galeri', 'url' => '/galeri'],
                        ['label' => 'Tentang', 'url' => '/tentang'],
                    ],
                ],
                [
                    'title' => 'Layanan',
                    'links' => [
                        ['label' => 'Reservasi Kamar', 'url' => '/cari-kamar'],
                        ['label' => 'Alur Reservasi', 'url' => '/alur'],
                        ['label' => 'FAQ', 'url' => '/faq'],
                        ['label' => 'Kontak', 'url' => '/kontak'],
                    ],
                ],
                [
                    'title' => 'Dukungan',
                    'links' => [
                        ['label' => 'Bantuan Admin', 'url' => '/kontak'],
                        ['label' => 'Informasi Pembayaran', 'url' => '/faq'],
                        ['label' => 'Syarat Hunian', 'url' => '/faq'],
                    ],
                ],
            ],
            'socials' => [
                ['icon' => 'bi-instagram', 'url' => '#'],
                ['icon' => 'bi-youtube', 'url' => '#'],
                ['icon' => 'bi-facebook', 'url' => '#'],
            ],
            'copyright' => '© ' . date('Y') . ' SIRKA Rusunawa UNDIP. All rights reserved.',
        ];

        SiteSetting::updateOrCreate(

            [
                'key' => 'footer',
            ],

            [
               'value' => $payload,
            ]
        );
    }
}
