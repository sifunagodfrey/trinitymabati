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
            Route::post('/{id}/send', [QuotationsController::class, 'send'])->name('send');            Route::post('/{id}/convert', [QuotationsController::class, 'convert'])->name('convert');

            // Deleting needs the manage_quotations permission (view-only staff cannot delete)
            Route::middleware('permission:manage_quotations')->group(function () {
                Route::post('/bulk-delete', [QuotationsController::class, 'bulkDestroy'])->name('bulk-destroy');
                Route::delete('/{id}',      [QuotationsController::class, 'destroy'])->name('destroy');
            });
        });

    });
