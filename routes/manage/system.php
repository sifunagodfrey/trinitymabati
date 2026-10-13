<?php

use App\Http\Controllers\Manage\System\AjaxSearchController;
use App\Http\Controllers\Manage\System\ContactController;
use App\Http\Controllers\Manage\System\PermissionsController;
use App\Http\Controllers\Manage\System\SystemUsersController;
use App\Http\Controllers\Manage\System\VisitorsLogController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        // -------------------
        // Ajax Live Search
        // -------------------
        Route::get('ajax/search', [AjaxSearchController::class, 'search'])->name('ajax.search');

        // -------------------
        // Visitors Log
        // -------------------
        Route::prefix('visitors-log')->as('visitors-log.')->group(function () {
            Route::get('/', [VisitorsLogController::class, 'index'])->name('index');
        });

        // -------------------
        // System Users
        // -------------------
        Route::prefix('system-users')->as('system-users.')->group(function () {
            Route::get('/', [SystemUsersController::class, 'index'])->name('index');
            Route::get('/create', [SystemUsersController::class, 'create'])->name('create');
            Route::post('/', [SystemUsersController::class, 'store'])->name('store');
            Route::get('/{id}', [SystemUsersController::class, 'show'])->name('show');
            Route::get('/{id}/edit', [SystemUsersController::class, 'edit'])->name('edit');
            Route::put('/{id}', [SystemUsersController::class, 'update'])->name('update');
            Route::delete('/{id}', [SystemUsersController::class, 'destroy'])->name('destroy');            
        });

        // -------------------
        // Permission Management
        // -------------------
        Route::prefix('permissions')->as('permissions.')->group(function () {
            Route::get('/', [PermissionsController::class, 'index'])->name('index');
            Route::post('/update', [PermissionsController::class, 'update'])->name('update');
        });

        // -------------------
        // Contact
        // -------------------
        Route::prefix('contact')->as('contact.')->group(function () {
            Route::get('/',          [ContactController::class, 'index'])->name('index');
            Route::get('/{id}',      [ContactController::class, 'show'])->name('show');
            Route::post('/{id}/reply', [ContactController::class, 'reply'])->name('reply');
        });

    });