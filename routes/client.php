<?php

use App\Http\Controllers\Client\AddressController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\ProductReviewController;  
use App\Http\Controllers\Client\WalletController;
use App\Http\Controllers\Client\WishlistController;
use App\Http\Controllers\Client\ReferralController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\AccountSettingsController;
use App\Http\Controllers\Client\InboxController;

// -------------------
// CLIENT PORTAL
// -------------------

Route::prefix('account')
    ->middleware(['auth', 'role:super_admin,admin,customer', 'remember.session'])
    ->as('client.')
    ->group(function () {

        // -------------------
        // Dashboard
        // -------------------
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // -------------------
        // Orders
        // -------------------
        Route::prefix('orders')->as('orders.')->group(function () {

            Route::get('/', [OrderController::class, 'index'])
                ->name('index');

            Route::get('/{id}', [OrderController::class, 'show'])
                ->name('show');

            Route::post('/{id}/cancel', [OrderController::class, 'cancel'])
                ->name('cancel');

            Route::get('/{id}/invoice', [OrderController::class, 'invoice'])
                ->name('invoice');
        });

        // -------------------
        // Product Review (from completed orders)
        // -------------------
        Route::post('/review/store', [ProductReviewController::class, 'store'])
            ->name('review.store');

        // -------------------
        // Inbox
        // -------------------
        Route::prefix('inbox')->as('inbox.')->group(function () {
            Route::get('/', [InboxController::class, 'index'])->name('index');
            Route::get('/{id}', [InboxController::class, 'show'])->name('show');
        });

        // -------------------
        // Address
        // -------------------
        Route::prefix('address')->as('address.')->group(function () {

            Route::get('/', [AddressController::class, 'index'])
                ->name('index');

            Route::get('/set', [AddressController::class, 'create'])
                ->name('create');

            Route::get('/locations', [AddressController::class, 'locations'])
                ->name('locations');

            Route::post('/set', [AddressController::class, 'store'])
                ->name('store');
        });

        // -------------------
        // Wallet
        // -------------------
        Route::prefix('wallet')->as('wallet.')->group(function () {

            Route::get('/',             [WalletController::class, 'index'])        ->name('index');
            Route::get('/topup',        [WalletController::class, 'topup'])        ->name('topup');
            Route::get('/transactions', [WalletController::class, 'transactions']) ->name('transactions');
            Route::get('/withdraw',     [WalletController::class, 'withdraw'])     ->name('withdraw');
            Route::post('/withdraw',    [WalletController::class, 'processWithdraw']) ->name('withdraw.store');

            // ---------------
            // AJAX - payment gateway initiation and polling
            // ---------------
            Route::post('/topup/mpesa',             [WalletController::class, 'initiateTopupMpesa'])             ->name('topup.mpesa');
            Route::get('/topup/poll',               [WalletController::class, 'pollTopupStatus'])               ->name('topup.poll');
            Route::post('/topup/timeout',           [WalletController::class, 'reportTopupTimeout'])            ->name('topup.timeout');
        });

        // -------------------
        // Loyalty Points
        // -------------------
        Route::prefix('loyalty')->as('loyalty.')->group(function () {

            Route::get('/', [\App\Http\Controllers\Client\LoyaltyController::class, 'index'])
                ->name('index');

            Route::get('/history', [\App\Http\Controllers\Client\LoyaltyController::class, 'history'])
                ->name('history');

            Route::get('/redeem', [\App\Http\Controllers\Client\LoyaltyController::class, 'showRedeem'])
                ->name('redeem');

            Route::post('/redeem', fn () => redirect()->route('client.loyalty.index')
                ->with('info', 'Redemption will be applied at checkout.'))
                ->name('redeem.store');
        });

        // -------------------
        // Account Settings
        // -------------------
        Route::prefix('settings')->as('settings.')->group(function () {

            Route::get('/account', [AccountSettingsController::class, 'edit'])
                ->name('account');

            Route::post('/account', [AccountSettingsController::class, 'updateProfile'])
                ->name('account.update');

            Route::post('/account/password', [AccountSettingsController::class, 'updatePassword'])
                ->name('password.update');

            Route::get('/payment', fn () => view('client.payment-settings.index'))
                ->name('payment');

            Route::post('/payment', fn () => redirect()->route('client.settings.payment')
                ->with('success', 'Payment settings updated!'))
                ->name('payment.update');
        });

        // -------------------
        // Newsletter
        // -------------------
        Route::prefix('newsletter')->as('newsletter.')->group(function () {

            Route::get('/', [\App\Http\Controllers\Client\NewsletterController::class, 'index'])
                ->name('index');

            Route::post('/update', [\App\Http\Controllers\Client\NewsletterController::class, 'update'])
                ->name('update');
        });

        // -------------------
        // Referrals
        // -------------------
        Route::prefix('referrals')->as('referrals.')->group(function () {

            Route::get('/', [ReferralController::class, 'index'])
                ->name('index');

            Route::post('/generate', [ReferralController::class, 'generate'])
                ->name('generate');

            Route::post('/toggle', [ReferralController::class, 'toggle'])
                ->name('toggle');
        });

        // -------------------
        // Wishlist
        // -------------------
        Route::prefix('wishlist')->as('wishlist.')->group(function () {

            Route::get('/', [WishlistController::class, 'index'])
                ->name('index');

            Route::post('/toggle/{productId}', [WishlistController::class, 'toggle'])
                ->name('toggle');

            Route::post('/remove/{productId}', [WishlistController::class, 'remove'])
                ->name('remove');
        });

        // -------------------
        // Payment Settings
        // -------------------
        Route::get('/settings/payment', [App\Http\Controllers\Client\PaymentSettingsController::class, 'edit'])
            ->name('settings.payment');

        Route::post('/settings/payment', [App\Http\Controllers\Client\PaymentSettingsController::class, 'update'])
            ->name('settings.payment.update');

    });
