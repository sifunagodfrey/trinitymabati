<?php

use App\Http\Controllers\Manage\Settings\CurrencyController;
use App\Http\Controllers\Manage\Settings\EmailController;
use App\Http\Controllers\Manage\Settings\OptimizationController;
use App\Http\Controllers\Manage\Settings\VatController;
use App\Http\Controllers\Manage\Settings\BrandingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('settings')->as('settings.')->group(function () {

            Route::prefix('branding')->as('branding.')->group(function () {
                Route::get('/', [BrandingController::class, 'index'])->name('index');
                Route::post('/', [BrandingController::class, 'update'])->name('update');
            });

            // ---------------
            // VAT Settings
            // ---------------
            Route::prefix('vat')->as('vat.')->group(function () {
                Route::get('/', [VatController::class, 'index'])->name('index');
                Route::post('/', [VatController::class, 'store'])->name('store');
                Route::post('/{id}/apply', [VatController::class, 'apply'])->name('apply');
            });

            // ---------------
            // Email Settings
            // ---------------
            Route::prefix('email')->as('email.')->group(function () {
                Route::get('/', [EmailController::class, 'index'])->name('index');
                Route::post('/', [EmailController::class, 'update'])->name('update');
            });

            // ---------------
            // Currency Settings
            // ---------------
            Route::prefix('currency')->as('currency.')->group(function () {
                Route::get('/', [CurrencyController::class, 'index'])->name('index');
                Route::post('/', [CurrencyController::class, 'update'])->name('update');
            });

            // ---------------
            // Login Security Settings
            // ---------------
            Route::prefix('security')->as('security.')->group(function () {
                Route::get('/',  [\App\Http\Controllers\Manage\Settings\SecurityController::class, 'index'])->name('index');
                Route::post('/', [\App\Http\Controllers\Manage\Settings\SecurityController::class, 'update'])->name('update');
            });

            // ---------------
            // Contact & Social Settings
            // ---------------
            Route::prefix('contact')->as('contact.')->group(function () {
                Route::get('/',  [\App\Http\Controllers\Manage\Settings\ContactController::class, 'index'])->name('index');
                Route::post('/', [\App\Http\Controllers\Manage\Settings\ContactController::class, 'update'])->name('update');
            });

            // ---------------
            // SMS Settings
            // ---------------
            Route::prefix('sms')->as('sms.')->group(function () {
                Route::get('/',      [\App\Http\Controllers\Manage\Settings\SmsController::class, 'index'])->name('index');
                Route::post('/',     [\App\Http\Controllers\Manage\Settings\SmsController::class, 'update'])->name('update');
                Route::post('/test', [\App\Http\Controllers\Manage\Settings\SmsController::class, 'test'])->name('test');
            });

            // ---------------
            // Optimization Tools
            // ---------------
            Route::prefix('optimization')->as('optimization.')->group(function () {
                Route::get('/', [OptimizationController::class, 'index'])->name('index');
                Route::post('/clear-cache', [OptimizationController::class, 'clearCache'])->name('clear-cache');
                Route::post('/optimize-assets', [OptimizationController::class, 'optimizeAssets'])->name('optimize-assets');
                Route::post('/clean-database', [OptimizationController::class, 'cleanDatabase'])->name('clean-database');
            });

        });

    });
