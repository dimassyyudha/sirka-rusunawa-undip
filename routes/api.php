<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MidtransController;

Route::post('/midtrans/callback', [MidtransController::class, 'callback'])
    ->name('api.midtrans.callback');
