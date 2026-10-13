<?php

use Illuminate\Support\Facades\Route;

// Dashboard is visible to any authenticated staff member, no extra permission needed
require __DIR__.'/dashboard.php';

Route::middleware('permission:send_notifications')->group(function () {
    require __DIR__.'/messages.php';
});

Route::middleware('permission:view_orders|view_payments|view_invoices|moderate_reviews|view_users|view_reports')
    ->group(function () {
        require __DIR__.'/ecommerce.php';
    });

Route::middleware('permission:view_products')->group(function () {
    require __DIR__.'/products.php';
});

Route::middleware('permission:manage_quotations|view_quotations')->group(function () {
    require __DIR__.'/quotations.php';
});

Route::middleware('permission:manage_blog')->group(function () {
    require __DIR__.'/blogs.php';
});

Route::middleware('permission:manage_pages')->group(function () {
    require __DIR__.'/content.php';
});

Route::middleware('permission:view_payments')->group(function () {
    require __DIR__.'/payments.php';
});

Route::middleware('permission:shipping_settings|location_pricing')->group(function () {
    require __DIR__.'/shipping.php';
});

Route::middleware('permission:newsletters')->group(function () {
    require __DIR__.'/newsletters.php';
});

Route::middleware('permission:media')->group(function () {
    require __DIR__.'/media.php';
});

Route::middleware('permission:manage_settings')->group(function () {
    require __DIR__.'/settings.php';
});

require __DIR__.'/system.php';
