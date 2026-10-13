<?php

use App\Http\Controllers\Manage\NewslettersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('newsletters')->as('newsletters.')->group(function () {
            Route::get('/', [NewslettersController::class, 'index'])->name('index');
            Route::post('/store', [NewslettersController::class, 'store'])->name('store');
            Route::delete('/{id}', [NewslettersController::class, 'destroy'])->name('destroy');
        });

    });
