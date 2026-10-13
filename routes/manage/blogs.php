<?php

use App\Http\Controllers\Manage\Blogs\CategoriesController;
use App\Http\Controllers\Manage\Blogs\PostsController;
use App\Http\Controllers\Manage\Blogs\TagsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('blogs')->as('blogs.')->group(function () {

            // ---------------
            // Blog Posts
            // ---------------
            Route::prefix('posts')->as('posts.')->group(function () {
                Route::get('/', [PostsController::class, 'index'])->name('index');
                Route::get('/create', [PostsController::class, 'create'])->name('create');
                Route::post('/create', [PostsController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [PostsController::class, 'edit'])->name('edit');
                Route::post('/{id}/edit', [PostsController::class, 'update'])->name('update');
                Route::post('/{id}/delete', [PostsController::class, 'destroy'])->name('destroy');
                Route::post('/{id}/toggle-publish', [PostsController::class, 'togglePublish'])->name('toggle-publish');
                Route::post('/upload-media', [PostsController::class, 'uploadMedia'])->name('uploadMedia');
            });

            // ---------------
            // Blog Categories
            // ---------------
            Route::prefix('categories')->as('categories.')->group(function () {
                Route::get('/', [CategoriesController::class, 'index'])->name('index');
                Route::get('/create', [CategoriesController::class, 'create'])->name('create');
                Route::post('/create', [CategoriesController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [CategoriesController::class, 'edit'])->name('edit');
                Route::post('/{id}/edit', [CategoriesController::class, 'update'])->name('update');
                Route::post('/{id}/delete', [CategoriesController::class, 'destroy'])->name('destroy');
            });

            // ---------------
            // Blog Tags
            // ---------------
            Route::prefix('tags')->as('tags.')->group(function () {
                Route::get('/', [TagsController::class, 'index'])->name('index');
                Route::post('/create', [TagsController::class, 'store'])->name('store');
                Route::post('/{id}/edit', [TagsController::class, 'update'])->name('update');
                Route::post('/{id}/delete', [TagsController::class, 'destroy'])->name('destroy');
            });

        });

    });
