<?php

use App\Http\Controllers\AsetController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeveloperController;
use App\Http\Controllers\KategoriAsetController;
use App\Http\Controllers\LokasiAsetController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MutasiAsetController;
use App\Http\Controllers\PemeliharaanAsetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WargaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. GROUP GUEST (Belum Login)
|--------------------------------------------------------------------------
 */
// Redirect halaman awal ke login
Route::get('/', function () {
    return redirect()->route('auth.login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('register', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| 2. GROUP AUTHENTICATED (Sudah Login)
|--------------------------------------------------------------------------
 */
Route::group(['middleware' => ['checkislogin']], function () {

    // Logout (Bisa diakses siapa saja yang login)
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // -----------------------------------------------------------
    // LEVEL 1: AKSES UMUM (Admin, Staff, Kades)
    // -----------------------------------------------------------
    Route::group(['middleware' => ['checkrole:admin,staff,kades']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/developer', [DeveloperController::class, 'index'])->name('developer.index');
    });

    // -----------------------------------------------------------
    // LEVEL 2: AKSES OPERASIONAL (Admin & Staff)
    // -----------------------------------------------------------
    Route::group(['middleware' => ['checkrole:admin,staff']], function () {
        // CRUD Aset & Lainnya
        Route::resource('aset', AsetController::class);
        Route::resource('kategori', KategoriAsetController::class);
        Route::resource('warga', WargaController::class);
        Route::resource('lokasi-aset', LokasiAsetController::class);
        Route::resource('mutasi', MutasiAsetController::class);

        // --- PERBAIKAN: Letakkan Route Custom DI ATAS Resource ---
        // Agar tidak tertimpa oleh route 'show' milik resource
        Route::get('pemeliharaan/delete-bukti/{id}', [PemeliharaanAsetController::class, 'deleteBukti'])
            ->name('pemeliharaan.delete-bukti');

        Route::resource('pemeliharaan', PemeliharaanAsetController::class);

        // Upload Media
        Route::post('/media/store', [MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/destroy/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
    });

    // -----------------------------------------------------------
    // LEVEL 3: AKSES MONITORING (Khusus Kades)
    // -----------------------------------------------------------
    // Kades bisa melihat Index (Daftar) dan Show (Detail), tapi tidak bisa Edit/Hapus.

    Route::group(['middleware' => ['checkrole:kades']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Ubah Route::get manual menjadi Route::resource dengan only(['index', 'show'])
        Route::resource('aset', AsetController::class)->only(['index', 'show']);
        Route::resource('warga', WargaController::class)->only(['index', 'show']);
        Route::resource('lokasi-aset', LokasiAsetController::class)->only(['index', 'show']);
        Route::resource('mutasi', MutasiAsetController::class)->only(['index', 'show']);
        Route::resource('pemeliharaan', PemeliharaanAsetController::class)->only(['index', 'show']);
        Route::resource('kategori', KategoriAsetController::class)->only(['index', 'show']);
    });

    // -----------------------------------------------------------
    // LEVEL 3: AKSES SUPER (Khusus Admin)
    // -----------------------------------------------------------
    Route::group(['middleware' => ['checkrole:admin']], function () {
        Route::resource('user', UserController::class);
    });

});
