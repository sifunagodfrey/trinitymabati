<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manage\Shipping\SettingsController;
use App\Http\Controllers\Manage\Shipping\PricingController;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('shipping')->as('shipping.')->group(function () {

            // ---------------
            // Shipping Settings
            // ---------------
            Route::prefix('settings')->as('settings.')->group(function () {
                Route::get('/', [SettingsController::class, 'index'])->name('index');
                Route::post('/', [SettingsController::class, 'update'])->name('update');
            });

            // ---------------
            // Location-Based Pricing
            // ---------------
            Route::prefix('pricing')->as('pricing.')->group(function () {
                Route::get('/', [PricingController::class, 'index'])->name('index');
                Route::post('/', [PricingController::class, 'store'])->name('store');
                Route::delete('/{id}', [PricingController::class, 'destroy'])->name('destroy');
            });

        });

    });
