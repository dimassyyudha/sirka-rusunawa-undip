<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Recommendation;
use App\Models\Room;
use App\Models\SiteSetting;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function beranda()
    {
        // ===== HERO / BERANDA SETTINGS =====
        // ===== BERANDA SETTINGS =====
        $beranda = SiteSetting::getValue('beranda', [
            'headline' => 'Reservasi Rusunawa UNDIP',
            'subheadline' => 'Mudah, cepat, transparan.',
            'cta_text' => 'Reservasi Kamar',
            'background_images' => [
                [
                    'image' => 'assets-admin/images/hero-1.jpg',
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => 1,
                ],
                [
                    'image' => 'assets-admin/images/hero-2.jpg',
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => 2,
                ],
                [
                    'image' => 'assets-admin/images/hero-3.jpg',
                    'is_active' => true,
                    'is_featured' => true,
                    'sort_order' => 3,
                ],
            ],
        ]);

        // FILTER SEPERTI FAQ
        $berandaItemsHome = collect($beranda['background_images'] ?? [])
            ->filter(fn($item) => !empty($item['image']))
            ->sortBy('sort_order')
            ->values()
            ->all();

        // ===== FAQ SETTINGS =====
        $faq = SiteSetting::getValue('faq', [
            'title'    => 'Pertanyaan yang sering diajukan',
            'subtitle' => 'Klik salah satu pertanyaan di bawah untuk melihat jawabannya.',
            'items'    => [],
        ]);

        // FAQ untuk landing page: hanya aktif + featured
        $faqItemsHome = collect($faq['items'] ?? [])
            ->filter(function ($item) {
                return !empty($item['is_active']) && !empty($item['is_featured']);
            })
            ->sortBy('sort_order')
            ->values()
            ->all();

        // ===== STATS KAMAR =====
        $totalRooms = Room::count();

        $availableRooms = (int) Room::query()
            ->join('floors', 'rooms.floor_id', '=', 'floors.floor_id')
            ->where('rooms.status', 'tersedia')
            ->whereRaw('(COALESCE(floors.room_capacity, 2) - COALESCE(rooms.occupied, 0)) > 0')
            ->count();

        $availableByBuildingRaw = Room::query()
            ->join('floors', 'rooms.floor_id', '=', 'floors.floor_id')
            ->join('buildings', 'floors.building_id', '=', 'buildings.building_id')
            ->selectRaw('UPPER(buildings.code) as gedung, COUNT(*) as total')
            ->where('rooms.status', 'tersedia')
            ->whereRaw('(COALESCE(floors.room_capacity, 2) - COALESCE(rooms.occupied, 0)) > 0')
            ->groupByRaw('UPPER(buildings.code)')
            ->pluck('total', 'gedung')
            ->toArray();

        $availableByBuilding = [];

        $buildings = Building::where('is_active', true)
            ->orderBy('code')
            ->get();

        foreach ($buildings as $building) {
            $code = strtoupper($building->code);

            $availableByBuilding[$code] = [
                'name' => $building->name,
                'code' => $code,
                'total' => (int) ($availableByBuildingRaw[$code] ?? 0),
            ];
        }

        $totalCapacity = (int) Room::query()
            ->join('floors', 'rooms.floor_id', '=', 'floors.floor_id')
            ->sum('floors.room_capacity');
        $totalOccupied = (int) Room::query()->sum('occupied');

        $occupancyRate = $totalCapacity > 0
            ? round(($totalOccupied / $totalCapacity) * 100)
            : 0;

        // ===== SECTION SETTINGS =====
        $kenapa = SiteSetting::getValue('kenapa_rusunawa', [
            'badge' => 'Kenapa Rusunawa?',
            'title' => 'Bukan sekadar tempat tinggal, tapi lingkungan belajar yang nyaman',
            'description' => 'Rusunawa UNDIP dirancang untuk mahasiswa: strategis, aman, dan tertib.',
            'cards' => [],
        ]);


        $recommendations = Recommendation::with([
            'room.photos',
            'room.floor.building',
        ])

            ->where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->filter(function ($item) {

                $room = $item->room;

                if (!$room || !$room->floor || !$room->floor->building) {
                    return false;
                }

                $capacity = (int) ($room->floor->room_capacity ?? 2);
                $occupied = (int) ($room->occupied ?? 0);

                return $room->status === 'tersedia'
                    && ($capacity - $occupied) > 0;
            })
            ->values();

        $alur = SiteSetting::getValue('alur', [
            'badge' => 'Cara Reservasi',
            'title' => 'Cuma 3 langkah',
            'subtitle' => 'Proses reservasi dirancang sederhana, transparan, dan mudah dipahami mahasiswa.',
            'items' => [],
        ]);

        $testimonials = Testimonial::with('user')->get();

        $footer = SiteSetting::getValue('footer', [
            'brand' => 'SIRKA Rusunawa UNDIP',
            'description' => 'Sistem Informasi Reservasi Kamar Rusunawa Universitas Diponegoro.',
            'whatsapp' => '+62 878-2130-5379',
            'whatsapp_link' => 'https://wa.me/6287821305379',
            'email' => 'rusunawa@undip.ac.id',
            'address' => 'Rusunawa UNDIP, Tembalang, Kota Semarang',
            'columns' => [],
            'socials' => [],
            'copyright' => '© ' . date('Y') . ' SIRKA Rusunawa UNDIP.',
        ]);

        return view('frontend.home', compact(
            'beranda',
            'berandaItemsHome',
            'faq',
            'faqItemsHome',
            'totalRooms',
            'availableRooms',
            'availableByBuilding',
            'occupancyRate',
            'recommendations',
            'testimonials',
            'kenapa',
            'alur',
            'footer',
        ));
    }

    public function galeri()
    {
        return view('frontend.galeri');
    }

    public function testimoni()
    {
        $testimonials = Testimonial::with('user')->get();
        return view('frontend.testimonials.index', compact('testimonials'));
    }

    public function tentang()
    {
        $tentang = SiteSetting::getValue('tentang_kami', [
            'blocks' => [],
        ]);

        return view('frontend.tentang.tentang', compact('tentang'));
    }

    public function kontak()
    {
        return view('frontend.contact.contact');
    }

    public function alur()
    {
        $alur = SiteSetting::getValue('alur', []);
        return view('frontend.alur', compact('alur'));
    }

    public function faq()
    {
        $faq = SiteSetting::getValue('faq', [
            'title'    => 'Pertanyaan yang sering diajukan',
            'subtitle' => 'Klik salah satu pertanyaan di bawah untuk melihat jawabannya.',
            'items'    => [],
        ]);

        // Semua FAQ aktif tampil di halaman /faq
        $items = collect($faq['items'] ?? [])
            ->filter(function ($item) {
                return !empty($item['is_active']);
            })
            ->sortBy('sort_order')
            ->values()
            ->all();

        return view('frontend.faq.index', compact('faq', 'items'));
    }

    public function syaratKetentuan()
    {
        $syaratKetentuan = SiteSetting::getValue('syarat-ketentuan', [
            'title' => 'Syarat & Ketentuan',
            'subtitle' => '',
            'items' => [],
        ]);

        return view(
            'frontend.syarat-ketentuan.index',
            compact('syaratKetentuan')
        );
    }


    public function visiMisi()
    {
        return view('pages.about.visi-misi');
    }

    public function gedung()
    {
        return view('pages.about.gedung');
    }

    public function fasilitasUmum()
    {
        return view('pages.about.fasilitas');
    }

    public function aturanTataTertib()
    {
        return view('pages.about.aturan');
    }
}
