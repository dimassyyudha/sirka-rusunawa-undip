<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\InventarisController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [InventarisController::class, 'index']);

// Route untuk auth
Route::get('login', [AuthController::class, 'showLoginForm'])->name('auth.login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('auth.login');
});

Route::post('/media/store', [MediaController::class, 'store'])->name('media.store');
Route::delete('/media/destroy/{id}', [MediaController::class, 'destroy'])->name('media.destroy');

Route::group(['middleware' => ['checkislogin']], function () {
// Route untuk dashboard admin
    Route::get('/dashboard', [InventarisController::class, 'index'])->name('dashboard');

    Route::resource('aset', AsetController::class);

    Route::resource('warga', WargaController::class);

    Route::resource('kategori', KategoriAsetController::class);
});

 Route::resource('user', UserController::class);

// Route::group(['middleware' => ['checkrole:']], function () {
//     Route::get('user', [UserController::class, 'index'])->name('user.index');
// });
