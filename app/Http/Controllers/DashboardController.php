<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\User;
use App\Models\LokasiAset;
use App\Models\KategoriAset;
use App\Models\PemeliharaanAset;
use App\Models\MutasiAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. CARD STATISTIK UTAMA
        $totalAset    = Aset::count();
        $totalLokasi  = LokasiAset::count();
        $totalUser    = User::count();
        $totalMutasi  = MutasiAset::count();

        // 2. STATISTIK KEUANGAN (Sum)
        $totalNilaiAset = Aset::sum('nilai_perolehan');
        $totalBiayaMt   = PemeliharaanAset::sum('biaya');

        // 3. CHART DATA: ASET BERDASARKAN KONDISI
        // Output: [ 'Baik' => 10, 'Rusak Ringan' => 5, 'Rusak Berat' => 2 ]
        $chartKondisi = Aset::select('kondisi', DB::raw('count(*) as total'))
                            ->groupBy('kondisi')
                            ->pluck('total', 'kondisi')
                            ->toArray();

        // 4. TABEL: 5 ASET TERBARU
        $latestAsets = Aset::with('kategoriAset')
                           ->latest()
                           ->take(5)
                           ->get();

        // 5. TABEL: 5 PEMELIHARAAN TERAKHIR
        $latestMt = PemeliharaanAset::with('aset')
                                    ->latest('tanggal')
                                    ->take(2)
                                    ->get();

        return view('pages.dashboard.dashboard', compact(
            'totalAset', 'totalLokasi', 'totalUser', 'totalMutasi',
            'totalNilaiAset', 'totalBiayaMt',
            'chartKondisi', 'latestAsets', 'latestMt'
        ));
    }
}