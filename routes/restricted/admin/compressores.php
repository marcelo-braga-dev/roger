<?php

use App\Http\Controllers\Admin\Compressores\CompressoresController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('compressores', CompressoresController::class);
    });
