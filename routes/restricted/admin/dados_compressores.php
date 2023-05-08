<?php

use App\Http\Controllers\Admin\Compressores\CompressoresController;
use App\Http\Controllers\Admin\Compressores\DadosController;
use Illuminate\Support\Facades\Route;

Route::name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::resource('dados_compressores', DadosController::class);
    });
