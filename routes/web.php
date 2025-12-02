<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\KategoriAsetController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;

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
    // LEVEL 1: AKSES UMUM (Admin, Staff, Pimpinan)
    // -----------------------------------------------------------
    Route::group(['middleware' => ['checkrole:admin,staff,pimpinan']], function () {
        Route::get('/dashboard', [InventarisController::class, 'index'])->name('dashboard');
    });

    // -----------------------------------------------------------
    // LEVEL 2: AKSES OPERASIONAL (Admin & Staff)
    // -----------------------------------------------------------
    Route::group(['middleware' => ['checkrole:admin,staff']], function () {
        // CRUD Utama
        Route::resource('aset', AsetController::class);
        Route::resource('kategori', KategoriAsetController::class);
        Route::resource('warga', WargaController::class);

        // Upload Media
        Route::post('/media/store', [MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/destroy/{id}', [MediaController::class, 'destroy'])->name('media.destroy');
    });

    // -----------------------------------------------------------
    // LEVEL 3: AKSES SUPER (Khusus Admin)
    // -----------------------------------------------------------
    Route::group(['middleware' => ['checkrole:admin']], function () {
        Route::resource('user', UserController::class);
    });

});