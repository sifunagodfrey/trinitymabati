<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manage\MessagesController;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('messages')->as('messages.')->group(function () {
            Route::get('/', [MessagesController::class, 'index'])->name('index');
            Route::get('/{id}', [MessagesController::class, 'show'])->name('show');
            Route::post('/bulk-action', [MessagesController::class, 'bulkAction'])->name('bulk-action');
            Route::post('/mark-all-read', [MessagesController::class, 'markAllRead'])->name('mark-all-read');
        });

    });