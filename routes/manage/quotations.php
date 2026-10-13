<?php

use App\Http\Controllers\Manage\Quotations\QuotationsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('quotations')->as('quotations.')->group(function () {
            Route::get('/', [QuotationsController::class, 'index'])->name('index');
            Route::get('/create', [QuotationsController::class, 'create'])->name('create');
            Route::post('/', [QuotationsController::class, 'store'])->name('store');
            Route::get('/{id}', [QuotationsController::class, 'show'])->name('show');
            Route::put('/{id}/status', [QuotationsController::class, 'updateStatus'])->name('status');
            Route::post('/{id}/convert', [QuotationsController::class, 'convert'])->name('convert');
            Route::delete('/{id}', [QuotationsController::class, 'destroy'])->name('destroy');
        });

    });
