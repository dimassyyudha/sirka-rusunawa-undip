<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
// use App\Models\Room; // misal buat hitung kamar

class LandingController extends Controller
{
    public function index()
    {
        $beranda = SiteSetting::getValue('beranda', [
            'headline'      => 'Reservasi Rusunawa UNDIP',
            'subheadline'   => 'Mudah, cepat, transparan.',
            'cta_text'      => 'Book Now',
            'cta_link'      => '#',
            'cta_book_card' => 'Book Now',
            'slides'        => [],
        ]);

        // TODO: nanti ganti hitungan kamar beneran
        $availableRooms = 0;
        $totalRooms     = 0;

        return view('frontend.home', compact(
            'beranda',
            'slides',
            'availableRooms',
            'totalRooms'
        ));
    }
}
