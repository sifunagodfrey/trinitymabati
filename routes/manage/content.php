<?php

/* -------------------
   Admin content routes - site pages and FAQ management under
   manage.content.* names.
------------------- */

use App\Http\Controllers\Manage\Content\BannersController;
use App\Http\Controllers\Manage\Content\FaqsController;
use App\Http\Controllers\Manage\Content\PagesController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('content')->as('content.')->group(function () {

            // // ---------------
            // // Hero Banners
            // // ---------------
            // Route::prefix('banners')->as('banners.')->group(function () {
            //     Route::get('/',             [BannersController::class, 'index'])->name('index');
            //     Route::get('/create',       [BannersController::class, 'create'])->name('create');
            //     Route::post('/',            [BannersController::class, 'store'])->name('store');
            //     Route::get('/{id}/edit',    [BannersController::class, 'edit'])->name('edit');
            //     Route::put('/{id}',         [BannersController::class, 'update'])->name('update');
            //     Route::post('/{id}/toggle', [BannersController::class, 'toggle'])->name('toggle');
            //     Route::delete('/{id}',      [BannersController::class, 'destroy'])->name('destroy');
            // });

            // ---------------
            // Site Pages
            // ---------------
            Route::prefix('pages')->as('pages.')->group(function () {
                Route::get('/',             [PagesController::class, 'index'])->name('index');
                Route::get('/create',       [PagesController::class, 'create'])->name('create');
                Route::post('/',            [PagesController::class, 'store'])->name('store');
                Route::get('/{id}/edit',    [PagesController::class, 'edit'])->name('edit');
                Route::put('/{id}',         [PagesController::class, 'update'])->name('update');
                Route::post('/{id}/toggle', [PagesController::class, 'toggle'])->name('toggle');
                Route::delete('/{id}',      [PagesController::class, 'destroy'])->name('destroy');
            });

            // ---------------
            // FAQs
            // ---------------
            Route::prefix('faqs')->as('faqs.')->group(function () {
                Route::get('/',             [FaqsController::class, 'index'])->name('index');
                Route::get('/create',       [FaqsController::class, 'create'])->name('create');
                Route::post('/',            [FaqsController::class, 'store'])->name('store');
                Route::get('/{id}/edit',    [FaqsController::class, 'edit'])->name('edit');
                Route::put('/{id}',         [FaqsController::class, 'update'])->name('update');
                Route::post('/{id}/toggle', [FaqsController::class, 'toggle'])->name('toggle');
                Route::delete('/{id}',      [FaqsController::class, 'destroy'])->name('destroy');
            });
        });
    });
