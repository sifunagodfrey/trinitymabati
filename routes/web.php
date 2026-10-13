<?php

use Illuminate\Support\Facades\Route;

// -------------------
// Web Routes Entry Point
// -------------------

// Root Homepage - only on main domain, not admin subdomain
if (env('ADMIN_DOMAIN', '') === '' || request()->getHost() !== env('ADMIN_DOMAIN', '')) {
    Route::get('/', function () {
        return view('frontend.home.index');
    })->name('home');
}

// Load Route Groups
require __DIR__.'/auth.php';
require __DIR__.'/client.php';
require __DIR__.'/manage.php';
require __DIR__.'/frontend.php';