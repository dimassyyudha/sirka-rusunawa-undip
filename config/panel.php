<?php

return [

    'mahasiswa' => [

        'title' => 'SIRKA',
        'subtitle' => 'Portal Mahasiswa',

        'menus' => [

            [
                'section' => 'Menu Utama',
            ],

            [
                'label' => 'Beranda',
                'route' => 'mahasiswa.dashboard',
                'active' => 'mahasiswa.dashboard',
            ],

            [
                'section' => 'Hunian Saya',
            ],

            [
                'label' => 'Kamar Saya',
                'route' => 'mahasiswa.kamar-saya',
                'active' => 'mahasiswa.kamar-saya',
            ],

            [
                'label' => 'Reservasi',
                'route' => 'mahasiswa.reservasi',
                'active' => [
                    'mahasiswa.reservasi',
                    'mahasiswa.reservasi.*',
                ],
            ],

            [
                'label' => 'Registrasi Ulang',
                'route' => 'mahasiswa.registrasi-ulang.index',
                'active' => 'mahasiswa.registrasi-ulang.*',
            ],

            [
                'section' => 'Keuangan',
            ],

            [
                'label' => 'Pembayaran',
                'route' => 'mahasiswa.pembayaran',
                'active' => [
                    'mahasiswa.pembayaran',
                    'mahasiswa.pembayaran.*',
                ],
            ],

            [
                'section' => 'Akun',
            ],

            [
                'label' => 'Profil Saya',
                'route' => 'mahasiswa.profil',
                'active' => 'mahasiswa.profil',
            ],

            [
                'label' => 'Logout',
                'route' => 'logout',
                'active' => 'logout',
                'icon' => 'logout',
                'color' => 'red',
            ],

        ],

    ],

    'admin' => [

        'title' => 'SIRKA Admin',
        'subtitle' => 'Panel Administrator',

        'menus' => [

            [
                'section' => 'Dashboard',
            ],

            [
                'label' => 'Dashboard Admin',
                'route' => 'admin.dashboard',
                'active' => 'admin.dashboard',
            ],

            [
                'section' => 'Registrasi Hunian',
            ],

            [
                'label' => 'Periode Registrasi',
                'route' => 'admin.occupancy-periods.index',
                'active' => [
                    'admin.occupancy-periods.*',
                ],
            ],

            [
                'label' => 'Pengajuan Registrasi Ulang',
                'route' => 'admin.registrasi-ulang.index',
                'active' => [
                    'admin.registrasi-ulang.*',
                ],
            ],

            [
                'section' => 'Manajemen Rusunawa',
            ],

            [
                'label' => 'Gedung',
                'route' => 'admin.buildings.index',
                'active' => 'admin.buildings.*',
            ],

            [
                'label' => 'Lantai',
                'route' => 'admin.floors.index',
                'active' => 'admin.floors.*',
            ],

            [
                'label' => 'Kamar',
                'route' => 'admin.rooms.index',
                'active' => 'admin.rooms.*',
            ],

            [
                'label' => 'Penghuni',
                'route' => 'admin.penghuni.index',
                'active' => 'admin.penghuni.*',
            ],

            [
                'section' => 'Keuangan',
            ],

            [
                'label' => 'Invoice',
                'route' => 'admin.invoices.index',
                'active' => 'admin.invoices.*',
            ],

            [
                'label' => 'Pembayaran',
                'route' => 'admin.payments.index',
                'active' => 'admin.payments.*',
            ],
            [
                'label' => 'Transactions',
                'route' => 'admin.transactions.index',
                'active' => 'admin.transactions.*',
            ],

            [
                'label' => 'Verifikasi Reservasi',
                'route' => 'admin.verifikasi.index',
                'active' => 'admin.verifikasi.*',
            ],

            [
                'label' => 'Laporan Keuangan',
                'route' => 'admin.financial.index',
                'active' => 'admin.financial.*',
            ],

            [
                'section' => 'Pengaturan Website',
            ],

            [
                'label' => 'Beranda',
                'route' => 'admin.settings.beranda.index',
                'active' => 'admin.settings.beranda.*',
            ],

            [
                'label' => 'Tentang Kami',
                'route' => 'admin.settings.tentang-kami.index',
                'active' => 'admin.settings.tentang-kami.*',
            ],

            [
                'label' => 'Rekomendasi Kamar',
                'route' => 'admin.settings.recommendation.index',
                'active' => 'admin.settings.recommendation.*',
            ],

            [
                'label' => 'Alur Reservasi',
                'route' => 'admin.settings.alur.index',
                'active' => 'admin.settings.alur.*',
            ],

            [
                'label' => 'Reservasi Kamar',
                'route' => 'admin.settings.cari-kamar.index',
                'active' => 'admin.settings.cari-kamar.*',
            ],

            [
                'label' => 'FAQ',
                'route' => 'admin.settings.faq.index',
                'active' => 'admin.settings.faq.*',
            ],

            [
                'label' => 'Syarat & Ketentuan',
                'route' => 'admin.settings.syarat-ketentuan.index',
                'active' => 'admin.settings.syarat-ketentuan.*',
            ],

            [
                'section' => 'Akun',
            ],

            [
                'label' => 'Logout',
                'route' => 'logout',
                'active' => 'logout',
                'icon' => 'logout',
                'color' => 'red',
            ],

        ],

    ],

];
