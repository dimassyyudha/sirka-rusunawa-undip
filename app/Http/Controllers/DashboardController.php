<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\StudentProfile;
use App\Models\Room;
use App\Models\Reservation;
use App\Models\Payment;

class DashboardController extends Controller
{
    /**
     * Setelah login lari ke sini (route name: dashboard)
     * Logic:
     * - admin -> /admin/dashboard
     * - mahasiswa -> dashboard calon/penghuni lama
     */
    public function redirectByRole()
    {
        $role = auth()->user()->role;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        }

        abort(403, 'Role tidak dikenal.');
    }

    public function index()
    {
        $user = auth()->user();

        // ✅ ADMIN langsung ke admin panel
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // ✅ MAHASISWA
        // Aman: kalau profil belum ada, dianggap calon_penghuni
        $profile = $user->studentProfile; // relasi
        $status = $profile->status_mahasiswa ?? 'calon_penghuni';

        // Ambil reservasi aktif (sesuaikan status di tabel kamu)
        $activeReservation = null;
        if (class_exists(Reservation::class)) {
            $activeReservation = Reservation::with('room')
                ->where('user_id', $user->id)
                ->whereIn('status', ['pending', 'approved'])
                ->latest()
                ->first();
        }

        // Penghuni lama: tampilkan riwayat pembayaran terakhir
        if ($status === 'penghuni_lama') {
            $latestPayments = collect();
            if (class_exists(Payment::class)) {
                $latestPayments = Payment::where('user_id', $user->id)
                    ->latest()
                    ->take(5)
                    ->get();
            }

            return view('pages.mahasiswa.dashboard_penghuni_lama', [
                'profile' => $profile,
                'activeReservation' => $activeReservation,
                'latestPayments' => $latestPayments,
            ]);
        }

        // Default calon_penghuni
        return view('pages.mahasiswa.dashboard_calon', [
            'profile' => $profile,
            'activeReservation' => $activeReservation,
        ]);
    }

    /**
     * Admin dashboard (route name: admin.dashboard)
     * Biar Mazer panel punya data ringkasan.
     */
    public function admin()
    {
        // Kalau user nyasar ke sini tapi bukan admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Anda tidak punya akses ke halaman ini.');
        }

        // ✅ Statistik kamar (kalau model Room belum ada, biar ga error)
        $totalRooms = class_exists(Room::class) ? Room::count() : 0;

        // Kalau kamu pakai status_kamar: tersedia/terisi
        $roomsAvailable = class_exists(Room::class)
            ? Room::where('status', 'tersedia')->count()
            : 0;

        $roomsOccupied = class_exists(Room::class)
            ? Room::where('status', 'terisi')->count()
            : 0;

        // ✅ Reservasi terbaru
        // $latestReservations = collect();
        // if (class_exists(Reservation::class)) {
        //     $latestReservations = Reservation::with(['user', 'room'])
        //         ->latest()
        //         ->take(8)
        //         ->get();
        // }

        // // ✅ Pembayaran
        // $paymentsSuccessCount = class_exists(Payment::class)
        //     ? Payment::whereIn('status', ['paid', 'settlement'])->count()
        //     : 0;

        // $paymentsPendingCount = class_exists(Payment::class)
        //     ? Payment::where('status', 'pending')->count()
        //     : 0;

        // $totalIncome = class_exists(Payment::class)
        // ? Payment::whereIn('status', ['paid', 'settlement'])->sum('amount')
        // : 0;

        return view('pages.admin.dashboard', compact(
            'totalRooms',
            'roomsAvailable',
            'roomsOccupied',
            // 'latestReservations',
            // 'paymentsSuccessCount',
            // 'paymentsPendingCount',
            // 'totalIncome'
        ));
    }
}
