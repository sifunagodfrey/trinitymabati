<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// ---------------
// Admin Portal Entry Point
// In production, set ADMIN_DOMAIN=admin.yourdomain.com in .env to restrict
// all manage routes to that subdomain (e.g. admin.yourdomain.com/dashboard).
// Leave ADMIN_DOMAIN empty on localhost and routes remain accessible via
// the /manage/ path prefix (e.g. localhost/manage/dashboard).
// ---------------
$adminDomain = request()->getHost() === env('ADMIN_DOMAIN', '__none__') ? env('ADMIN_DOMAIN') : '';

if ($adminDomain) {

    // ---------------
    // Redirect root to admin login - direct URL avoids redirect loops
    // ---------------
    Route::domain($adminDomain)->group(function () use ($adminDomain) {
        Route::get('/', function () use ($adminDomain) {
            if (Auth::check()) {
                return redirect()->route('manage.dashboard.index');
            }
            return redirect('https://' . $adminDomain . '/login');
        });
    });

    // ---------------
    // Production: subdomain replaces the /manage/ path prefix
    // ---------------
    Route::domain($adminDomain)
        ->middleware(['auth', 'role:super_admin,admin,manager', 'remember.session'])
        ->group(function () {
            require __DIR__.'/manage/groups.php';
        });

} else {

    // ---------------
    // Local: redirect /manage/ root to login
    // ---------------
    Route::prefix('manage')->group(function () {
        Route::get('/', function () {
            if (Auth::check()) {
                return redirect()->route('manage.dashboard.index');
            }
            return redirect()->route('manage.auth.login');
        });
    });

    // ---------------
    // Local: /manage/ path prefix applied here for all sub-modules
    // ---------------
    Route::prefix('manage')
        ->middleware(['auth', 'role:super_admin,admin,manager', 'remember.session'])
        ->group(function () {
            require __DIR__.'/manage/groups.php';
        });
}
