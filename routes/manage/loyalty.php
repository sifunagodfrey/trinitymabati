<?php

use App\Http\Controllers\Manage\Loyalty\AdjustController;
use App\Http\Controllers\Manage\Loyalty\MembersController;
use App\Http\Controllers\Manage\Loyalty\SettingsController;
use App\Http\Controllers\Manage\Loyalty\TiersController;
use App\Http\Controllers\Manage\Loyalty\TransactionsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('loyalty')->as('loyalty.')->group(function () {

            // ---------------
            // Programme Settings
            // ---------------
            Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
            Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

            // ---------------
            // Tier Management
            // ---------------
            Route::get('/tiers', [TiersController::class, 'index'])->name('tiers.index');
            Route::get('/tiers/{id}/edit', [TiersController::class, 'edit'])->name('tiers.edit');
            Route::put('/tiers/{id}', [TiersController::class, 'update'])->name('tiers.update');

            // ---------------
            // Members
            // ---------------
            Route::get('/members', [MembersController::class, 'index'])->name('members.index');

            // ---------------
            // Transactions
            // ---------------
            Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');

            // ---------------
            // Manual Point Adjustment
            // ---------------
            Route::get('/adjust', [AdjustController::class, 'create'])->name('adjust.create');
            Route::post('/adjust', [AdjustController::class, 'store'])->name('adjust.store');
        });
    });
