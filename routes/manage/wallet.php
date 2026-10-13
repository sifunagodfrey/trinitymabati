<?php

use App\Http\Controllers\Manage\WalletController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('wallet')->as('wallet.')->group(function () {

            // ---------------
            // All Wallets
            // ---------------
            Route::get('/', [WalletController::class, 'index'])->name('index');

            // ---------------
            // Wallet Detail + Transactions
            // ---------------
            Route::get('/{id}', [WalletController::class, 'show'])->name('show');

            // ---------------
            // Freeze / Unfreeze Toggle
            // ---------------
            Route::post('/{id}/freeze', [WalletController::class, 'freeze'])->name('freeze');

            // ---------------
            // Manual Adjustment (Credit / Debit)
            // ---------------
            Route::get('/{id}/adjust', [WalletController::class, 'showAdjust'])->name('adjust');
            Route::post('/{id}/adjust', [WalletController::class, 'applyAdjustment'])->name('adjust.apply');
        });
    });
