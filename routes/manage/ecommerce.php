<?php

use App\Http\Controllers\Manage\Ecommerce\AbandonedCartsController;
use App\Http\Controllers\Manage\Ecommerce\CustomersController;
use App\Http\Controllers\Manage\Ecommerce\CouponsController;
use App\Http\Controllers\Manage\Ecommerce\ReferralsController;
use App\Http\Controllers\Manage\Ecommerce\FlashSalesController;
use App\Http\Controllers\Manage\Ecommerce\InvoicesController;
use App\Http\Controllers\Manage\Ecommerce\OrdersController;
use App\Http\Controllers\Manage\Ecommerce\ReportsController;
use App\Http\Controllers\Manage\Ecommerce\ReturnsController;
use App\Http\Controllers\Manage\Ecommerce\ReviewsController;
use App\Http\Controllers\Manage\Ecommerce\VatOrdersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->as('manage.')
    ->group(function () {

        Route::prefix('ecommerce')->as('ecommerce.')->group(function () {

            // ---------------
            // Orders
            // ---------------
            Route::prefix('orders')->as('orders.')->group(function () {
                Route::get('/',             [OrdersController::class, 'index'])->name('index');
                Route::get('/{id}',         [OrdersController::class, 'show'])->name('show');
                Route::post('/{id}/status', [OrdersController::class, 'updateStatus'])->name('update-status');

                // Deleting is limited to admins (used to clear dummy data)
                Route::middleware('role:super_admin,admin')->group(function () {
                    Route::post('/bulk-delete', [OrdersController::class, 'bulkDestroy'])->name('bulk-destroy');
                    Route::delete('/{id}',      [OrdersController::class, 'destroy'])->name('destroy');
                });
            });

            // ---------------
            // Order Returns
            // ---------------
            Route::prefix('returns')->as('returns.')->group(function () {
                Route::get('/',                        [ReturnsController::class, 'index'])->name('index');
                Route::get('/create',                  [ReturnsController::class, 'create'])->name('create');
                Route::post('/',                       [ReturnsController::class, 'store'])->name('store');
                Route::get('/order-items',             [ReturnsController::class, 'orderItems'])->name('order-items');
                Route::get('/{id}',                    [ReturnsController::class, 'show'])->name('show');
                Route::post('/{id}/approve',           [ReturnsController::class, 'approve'])->name('approve');
                Route::post('/{id}/reject',            [ReturnsController::class, 'reject'])->name('reject');
                Route::post('/{id}/refund',            [ReturnsController::class, 'refund'])->name('refund');
            });

            // ---------------
            // Invoices
            // ---------------
            Route::prefix('invoices')->as('invoices.')->group(function () {
                Route::get('/',     [InvoicesController::class, 'index'])->name('index');
                Route::get('/{id}', [InvoicesController::class, 'show'])->name('show');
            });

            // ---------------
            // Product Reviews
            // ---------------
            Route::prefix('reviews')->as('reviews.')->group(function () {
                Route::get('/',                  [ReviewsController::class, 'index'])->name('index');
                Route::get('/{id}',              [ReviewsController::class, 'show'])->name('show');
                Route::post('/{id}/approve',     [ReviewsController::class, 'approve'])->name('approve');
                Route::post('/{id}/reject',      [ReviewsController::class, 'reject'])->name('reject');
                Route::delete('/{id}',           [ReviewsController::class, 'destroy'])->name('destroy');
            });

            // ---------------
            // Customers
            // ---------------
            Route::prefix('customers')->as('customers.')->group(function () {
                Route::get('/',                        [CustomersController::class, 'index'])->name('index');
                Route::get('/{id}',                    [CustomersController::class, 'show'])->name('show');
                Route::get('/{id}/message',            [CustomersController::class, 'message'])->name('message');
                Route::post('/{id}/send-message',      [CustomersController::class, 'sendMessage'])->name('send-message');
                Route::post('/{id}/toggle-status',     [CustomersController::class, 'toggleStatus'])->name('toggle-status');

                // Deleting is limited to admins (used to clear dummy data)
                Route::middleware('role:super_admin,admin')->group(function () {
                    Route::post('/bulk-delete',        [CustomersController::class, 'bulkDestroy'])->name('bulk-destroy');
                    Route::delete('/{id}',             [CustomersController::class, 'destroy'])->name('destroy');
                });
            });

            // ---------------
            // Flash Sales
            // ---------------
            Route::prefix('flash-sales')->as('flash-sales.')->group(function () {
                Route::get('/', [FlashSalesController::class, 'index'])->name('index');
            });

            // ---------------
            // Coupon Codes
            // ---------------
            Route::prefix('coupons')->as('coupons.')->group(function () {
                Route::get('/',             [CouponsController::class, 'index'])->name('index');
                Route::get('/create',       [CouponsController::class, 'create'])->name('create');
                Route::post('/',            [CouponsController::class, 'store'])->name('store');
                Route::get('/{id}/edit',    [CouponsController::class, 'edit'])->name('edit');
                Route::put('/{id}',         [CouponsController::class, 'update'])->name('update');
                Route::post('/{id}/toggle', [CouponsController::class, 'toggleStatus'])->name('toggle');
                Route::delete('/{id}',      [CouponsController::class, 'destroy'])->name('destroy');
            });

            // ---------------
            // Referral Codes
            // ---------------
            Route::prefix('referrals')->as('referrals.')->group(function () {
                Route::get('/',             [ReferralsController::class, 'index'])->name('index');
                Route::get('/events',       [ReferralsController::class, 'events'])->name('events');
                Route::get('/settings',     [ReferralsController::class, 'settings'])->name('settings');
                Route::post('/settings',    [ReferralsController::class, 'updateSettings'])->name('settings.update');
                Route::post('/{id}/toggle', [ReferralsController::class, 'toggle'])->name('toggle');
                Route::post('/{id}/reward', [ReferralsController::class, 'markRewarded'])->name('reward');
            });

            // ---------------
            // VAT Orders
            // ---------------
            Route::prefix('vat-orders')->as('vat-orders.')->group(function () {
                Route::get('/', [VatOrdersController::class, 'index'])->name('index');
            });

            // ---------------
            // Abandoned Carts
            // ---------------
            Route::prefix('abandoned-carts')->as('abandoned-carts.')->group(function () {
                Route::get('/',                             [AbandonedCartsController::class, 'index'])->name('index');
                Route::get('/{id}',                        [AbandonedCartsController::class, 'show'])->name('show');
                Route::post('/{id}/mark-recovered',        [AbandonedCartsController::class, 'markRecovered'])->name('mark-recovered');
            });

            // ---------------
            // Reports
            // ---------------
            Route::prefix('reports')->as('reports.')->group(function () {
                Route::get('/', [ReportsController::class, 'index'])->name('index');
            });

        });

    });
