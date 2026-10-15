<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manage\Payments\TransactionsController;
use App\Http\Controllers\Manage\Payments\MethodsController;
use App\Http\Controllers\Manage\Payments\LogsController;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        // All payment admin routes
        Route::prefix('payments')->as('payments.')->group(function () {

            // Transactions
            Route::get('/transactions', [TransactionsController::class, 'index'])->name('transactions.index');
            Route::get('/transactions/{id}', [TransactionsController::class, 'show'])->name('transactions.show');
            Route::post('/transactions/{id}/approve', [TransactionsController::class, 'approve'])->whereNumber('id')->name('transactions.approve');
            Route::post('/transactions/{id}/reject', [TransactionsController::class, 'reject'])->whereNumber('id')->name('transactions.reject');
            Route::get('/transactions/{id}/proof', [TransactionsController::class, 'proof'])->whereNumber('id')->name('transactions.proof');

            // Payment Methods
            Route::get('/methods', [MethodsController::class, 'index'])->name('methods.index');
            Route::get('/methods/{id}/edit', [MethodsController::class, 'edit'])->name('methods.edit');
            Route::put('/methods/{id}', [MethodsController::class, 'update'])->name('methods.update');
            Route::patch('/methods/{id}/toggle', [MethodsController::class, 'toggleStatus'])->name('methods.toggle');

            // Payment Logs
            Route::get('/logs', [LogsController::class, 'index'])->name('logs.index');
            Route::get('/logs/{id}', [LogsController::class, 'show'])->name('logs.show');
        });
    });