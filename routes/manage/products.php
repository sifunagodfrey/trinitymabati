<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Manage\Products\BrandsController;
use App\Http\Controllers\Manage\Products\CategoriesController;
use App\Http\Controllers\Manage\Products\LabelsController;
use App\Http\Controllers\Manage\Products\ProductsController;
use App\Http\Controllers\Manage\Products\ReportsController;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('products')->as('products.')->group(function () {

            // ---------------
            // Media Library - JSON list of all uploaded product images for the picker modal
            // ---------------
            Route::get('/media-library', [ProductsController::class, 'mediaLibrary'])->name('mediaLibrary');

            // ---------------
            // Products (All / Create / Edit / Delete)
            // ---------------
            Route::prefix('all')->as('all.')->group(function () {
                Route::get('/',            [ProductsController::class, 'index'])->name('index');
                Route::get('/create',      [ProductsController::class, 'create'])->name('create');
                Route::post('/create',     [ProductsController::class, 'store'])->name('store');
                Route::get('/{id}',        [ProductsController::class, 'show'])->name('show');
                Route::get('/{id}/edit',   [ProductsController::class, 'edit'])->name('edit');
                Route::put('/{id}/edit',   [ProductsController::class, 'update'])->name('update');
                Route::delete('/{id}',     [ProductsController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/toggle-active', [ProductsController::class, 'toggleActive'])->name('toggle-active');
            });
            Route::post('/reviews/{reviewId}/status', [ProductsController::class, 'updateReviewStatus'])->name('reviews.status');
            Route::post('/upload-media', [ProductsController::class, 'uploadMedia'])->name('uploadMedia');
            // ---------------
            // Add Product (Quick add/create alias)
            // ---------------
            Route::prefix('add')->as('add.')->group(function () {
                Route::get('/create',      [ProductsController::class, 'create'])->name('create');
                Route::post('/create',     [ProductsController::class, 'store'])->name('store');
            });

            // ---------------
            // Categories 
            // ---------------
            Route::prefix('categories')->as('categories.')->group(function () {
                Route::get('/',            [CategoriesController::class, 'index'])->name('index');
                Route::get('/create',      [CategoriesController::class, 'create'])->name('create');
                Route::post('/create',     [CategoriesController::class, 'store'])->name('store');
                Route::get('/{id}/edit',   [CategoriesController::class, 'edit'])->name('edit');
                Route::post('/{id}/edit',  [CategoriesController::class, 'update'])->name('update');
                Route::delete('/{id}',     [CategoriesController::class, 'destroy'])->name('destroy');
            });

            // ---------------
            // Brands
            // ---------------
            Route::prefix('brands')->as('brands.')->group(function () {
                Route::get('/',            [BrandsController::class, 'index'])->name('index');
                Route::get('/create',      [BrandsController::class, 'create'])->name('create');
                Route::post('/create',     [BrandsController::class, 'store'])->name('store');
                Route::get('/{id}/edit',   [BrandsController::class, 'edit'])->name('edit');
                Route::post('/{id}/edit',  [BrandsController::class, 'update'])->name('update');
                Route::delete('/{id}',     [BrandsController::class, 'destroy'])->name('destroy');
            });

            // ---------------
            // Labels
            // ---------------
            Route::prefix('labels')->as('labels.')->group(function () {
                Route::get('/',            [LabelsController::class, 'index'])->name('index');
                Route::get('/create',      [LabelsController::class, 'create'])->name('create');
                Route::post('/create',     [LabelsController::class, 'store'])->name('store');
                Route::get('/{id}/edit',   [LabelsController::class, 'edit'])->name('edit');
                Route::post('/{id}/edit',  [LabelsController::class, 'update'])->name('update');
                Route::delete('/{id}',     [LabelsController::class, 'destroy'])->name('destroy');
            });

            // ---------------
            // Reports
            // ---------------
            Route::prefix('reports')->as('reports.')->group(function () {
                Route::get('/', [ReportsController::class, 'index'])->name('index');
            });

        });

    });
