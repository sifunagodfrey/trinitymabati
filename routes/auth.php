<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Manage\Auth\ManageForgotPasswordController;
use Illuminate\Support\Facades\Route;

// ---------------
// Admin Login + 2FA Routes
// Separate from the standard auth flow - admin-only, role-gated after 2FA.
// ---------------
$adminDomain = request()->getHost() === 'admin.haromienergy.com' ? 'admin.haromienergy.com' : '';

if ($adminDomain) {
    Route::domain($adminDomain)->as('manage.auth.')->group(function () {

        Route::middleware('guest')->group(function () {
            Route::get('login', [AdminLoginController::class, 'showLogin'])->name('login');
            Route::post('login', [AdminLoginController::class, 'login'])->middleware('throttle:storefront-auth')->name('login.submit');
        });

        // No auth middleware - partial session state guards these routes in the controller
        Route::get('verify-2fa', [AdminLoginController::class, 'showVerify'])->name('verify2fa');
        Route::post('verify-2fa', [AdminLoginController::class, 'verify'])->middleware('throttle:storefront-auth')->name('verify2fa.submit');

        // ---------------
        // Admin forgot password - OTP-based, three-step flow
        // ---------------
        Route::get('forgot-password',          [ManageForgotPasswordController::class, 'showRequest']) ->name('forgot-password');
        Route::post('forgot-password',         [ManageForgotPasswordController::class, 'sendCode'])->middleware('throttle:storefront-auth')    ->name('forgot-password.send');
        Route::get('forgot-password/verify',   [ManageForgotPasswordController::class, 'showVerify'])  ->name('forgot-password.verify');
        Route::post('forgot-password/verify',  [ManageForgotPasswordController::class, 'verifyCode'])->middleware('throttle:storefront-auth')  ->name('forgot-password.verify.submit');
        Route::get('forgot-password/reset',    [ManageForgotPasswordController::class, 'showReset'])   ->name('forgot-password.reset');
        Route::post('forgot-password/reset',   [ManageForgotPasswordController::class, 'resetPassword'])->middleware('throttle:storefront-auth')->name('forgot-password.reset.submit');

    });
} else {
    Route::prefix('manage')->as('manage.auth.')->group(function () {

        Route::middleware('guest')->group(function () {
            Route::get('login', [AdminLoginController::class, 'showLogin'])->name('login');
            Route::post('login', [AdminLoginController::class, 'login'])->middleware('throttle:storefront-auth')->name('login.submit');
        });

        // No auth middleware - partial session state guards these routes in the controller
        Route::get('verify-2fa', [AdminLoginController::class, 'showVerify'])->name('verify2fa');
        Route::post('verify-2fa', [AdminLoginController::class, 'verify'])->middleware('throttle:storefront-auth')->name('verify2fa.submit');

        // ---------------
        // Admin forgot password - OTP-based, three-step flow
        // ---------------
        Route::get('forgot-password',          [ManageForgotPasswordController::class, 'showRequest']) ->name('forgot-password');
        Route::post('forgot-password',         [ManageForgotPasswordController::class, 'sendCode'])->middleware('throttle:storefront-auth')    ->name('forgot-password.send');
        Route::get('forgot-password/verify',   [ManageForgotPasswordController::class, 'showVerify'])  ->name('forgot-password.verify');
        Route::post('forgot-password/verify',  [ManageForgotPasswordController::class, 'verifyCode'])->middleware('throttle:storefront-auth')  ->name('forgot-password.verify.submit');
        Route::get('forgot-password/reset',    [ManageForgotPasswordController::class, 'showReset'])   ->name('forgot-password.reset');
        Route::post('forgot-password/reset',   [ManageForgotPasswordController::class, 'resetPassword'])->middleware('throttle:storefront-auth')->name('forgot-password.reset.submit');

    });
}

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store'])->middleware('throttle:storefront-auth');

    Route::get('register/verify', [RegisteredUserController::class, 'showVerify'])
        ->name('register.verify');

    Route::post('register/verify', [RegisteredUserController::class, 'verify'])->middleware('throttle:storefront-auth')
        ->name('register.verify.submit');

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store'])->middleware('throttle:storefront-auth');

    // ---------------
    // Client forgot password - OTP-based, three-step flow
    // ---------------
    Route::get('forgot-password',         [ForgotPasswordController::class, 'showRequest'])   ->name('password.request');
    Route::post('forgot-password',        [ForgotPasswordController::class, 'sendCode'])->middleware('throttle:storefront-auth')      ->name('password.email');
    Route::get('forgot-password/verify',  [ForgotPasswordController::class, 'showVerify'])    ->name('password.verify');
    Route::post('forgot-password/verify', [ForgotPasswordController::class, 'verifyCode'])->middleware('throttle:storefront-auth')    ->name('password.verify.submit');
    Route::get('forgot-password/reset',   [ForgotPasswordController::class, 'showReset'])     ->name('password.do-reset');
    Route::post('forgot-password/reset',  [ForgotPasswordController::class, 'resetPassword'])->middleware('throttle:storefront-auth') ->name('password.do-reset.submit');
});

// ---------------
// Client / Seller 2FA Verify Routes
// Outside guest middleware - partial session state guards access in the controller
// ---------------
Route::get('login/verify-2fa', [AuthenticatedSessionController::class, 'showVerify'])->name('login.verify2fa');
Route::post('login/verify-2fa', [AuthenticatedSessionController::class, 'verify'])->middleware('throttle:storefront-auth')->name('login.verify2fa.submit');

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:storefront-auth')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store'])->middleware('throttle:storefront-auth');

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});