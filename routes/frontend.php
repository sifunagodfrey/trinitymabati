<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\ReferralController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Payment\MpesaController;
use App\Http\Controllers\Payment\PaystackController;
use App\Http\Controllers\Payment\PesapalController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\OrderTrackingController;
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\BrandController;

use Illuminate\Support\Facades\Route;

// -------------------
// FRONTEND PAGES (PUBLIC)
// -------------------

// Home
Route::get('/', [HomeController::class, 'index'])
    ->name('frontend.home');

// About
Route::get('/about', function () {
    return view('frontend.about.index');
})->name('frontend.about');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('frontend.blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('frontend.blog.show');

// Categories
Route::get('/categories', [CategoryController::class, 'index'])->name('frontend.categories');

Route::get('/categories/{slug}', [CategoryController::class, 'show'])
    ->name('frontend.categories.show');

// Search
Route::get('/search', [SearchController::class, 'index'])->name('frontend.search');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('frontend.search.suggestions');

// Products
Route::get('/products', [ProductController::class, 'index'])
    ->name('frontend.products');

Route::get('/products/{slug}', [ProductController::class, 'show'])
    ->name('frontend.products.show');

// Public quotation builder (guest checkout supported)
Route::get('/quotation', [\App\Http\Controllers\Frontend\QuotationRequestController::class, 'index'])->name('frontend.quotation.index');
Route::get('/quotation/search', [\App\Http\Controllers\Frontend\QuotationRequestController::class, 'search'])->name('frontend.quotation.search');
Route::post('/quotation/add', [\App\Http\Controllers\Frontend\QuotationRequestController::class, 'add'])->name('frontend.quotation.add');
Route::post('/quotation/update', [\App\Http\Controllers\Frontend\QuotationRequestController::class, 'update'])->name('frontend.quotation.update');
Route::post('/quotation/remove', [\App\Http\Controllers\Frontend\QuotationRequestController::class, 'remove'])->name('frontend.quotation.remove');
Route::post('/quotation/submit', [\App\Http\Controllers\Frontend\QuotationRequestController::class, 'submit'])->middleware('throttle:8,1')->name('frontend.quotation.submit');

// -------------------
// REFERRAL LINKS
// -------------------
Route::get('/ref/{code}', [ReferralController::class, 'visit'])
    ->name('frontend.referral.visit')
    ->where('code', '[A-Za-z0-9]+');

// -------------------
// CART
// -------------------
Route::get('/cart', [CartController::class, 'index'])->name('frontend.cart');
Route::get('/cart/count', [CartController::class, 'count'])->name('frontend.cart.count');
Route::post('/cart/add', [CartController::class, 'add'])->name('frontend.cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('frontend.cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('frontend.cart.update');
Route::post('/cart/abandon', [CartController::class, 'abandon'])->name('frontend.cart.abandon')->middleware('auth');

// -------------------
// MPESA CALLBACK (public - called by Safaricom, no auth, CSRF exempt)
// -------------------
Route::post('/payments/mpesa/mpesa_stk_callback_handler', [MpesaController::class, 'handleCallback'])
    ->name('mpesa.callback')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::get('/payments/paystack/callback', [PaystackController::class, 'handleCallback'])
    ->name('frontend.checkout.paystack.callback');

Route::post('/payments/paystack/webhook', [PaystackController::class, 'handleWebhook'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('frontend.checkout.paystack.webhook');

Route::get('/payments/pesapal/callback', [PesapalController::class, 'handleCallback'])
    ->name('frontend.checkout.pesapal.callback');

Route::match(['get', 'post'], '/payments/pesapal/ipn', [PesapalController::class, 'handleIpn'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('frontend.checkout.pesapal.ipn');

// -------------------
// CHECKOUT (auth required)
// -------------------
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('frontend.checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('frontend.checkout.store');
    Route::get('/checkout/locations', [CheckoutController::class, 'locations'])->name('frontend.checkout.locations');
    Route::get('/checkout/payment', [CheckoutController::class, 'payment'])->name('frontend.checkout.payment');
    Route::post('/checkout/payment', [CheckoutController::class, 'processPayment'])->name('frontend.checkout.payment.store');

    // ---------------
    // Mpesa polling - after STK push is sent
    // ---------------
    Route::get('/checkout/mpesa/polling',  [MpesaController::class, 'pollingScreen'])->name('frontend.checkout.mpesa.polling');
    Route::get('/checkout/mpesa/status',   [MpesaController::class, 'pollStatus'])->name('frontend.checkout.mpesa.status');
    Route::post('/checkout/mpesa/timeout', [MpesaController::class, 'reportTimeout'])->name('frontend.checkout.mpesa.timeout');
});

// -------------------
// GENERAL
// -------------------
Route::get('/testimonials', [\App\Http\Controllers\Frontend\ClientStoriesController::class, 'testimonials'])->name('frontend.testimonials');
Route::get('/client-projects', [\App\Http\Controllers\Frontend\ClientStoriesController::class, 'projects'])->name('frontend.projects');
Route::get('/client-projects/{slug}', [\App\Http\Controllers\Frontend\ClientStoriesController::class, 'project'])->name('frontend.projects.show');

Route::get('/faq', [FaqController::class, 'index'])->name('frontend.faq');

Route::get('/contact', [App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('frontend.contact');

// ---------------
// Public order tracking (no login required)
// ---------------
Route::get('/track-order', [OrderTrackingController::class, 'show'])->name('frontend.track-order');
Route::post('/track-order', [OrderTrackingController::class, 'track'])->name('frontend.track-order.track');
Route::get('/contact-us', [App\Http\Controllers\Frontend\ContactController::class, 'index'])
    ->name('frontend.contact.us');
Route::post('/contact', [App\Http\Controllers\Frontend\ContactController::class, 'store'])->name('frontend.contact.store');

Route::post('/newsletter/subscribe', function () {
    return redirect()->back()->with('success', 'Subscribed successfully!');
})->name('frontend.newsletter.subscribe');

Route::get('/downloads', function () {
    return view('frontend.downloads.index');
})->name('frontend.downloads');
// -------------------
// ACCOUNT DELETION
// -------------------
Route::get('/account-deletion', function () {
    return view('frontend.account-deletion.index');
})->name('frontend.account-deletion');
// -------------------
// LEGAL
// -------------------
Route::get('/cookie-policy', fn () => app(PageController::class)->show('cookie-policy'))
    ->name('frontend.cookie-policy');

Route::get('/terms-conditions', fn () => app(PageController::class)->show('terms-and-conditions'))
    ->name('frontend.terms');

Route::get('/refund-policy', fn () => app(PageController::class)->show('refund-policy'))
    ->name('frontend.refund-policy');

Route::get('/privacy-policy', fn () => app(PageController::class)->show('privacy-policy'))
    ->name('frontend.privacy-policy.public');

Route::get('/pages/{slug}', [PageController::class, 'show'])->name('frontend.pages.show');
// -------------------
// ACCOUNT
// -------------------
Route::get('/account', fn() => view('frontend.account.index'))
    ->name('frontend.account');

Route::get('/favorites', fn() => view('frontend.favorites.index'))
    ->name('frontend.favorites');

// -------------------
// TOP BRANDS
// -------------------
Route::get('/brands', [BrandController::class, 'index'])->name('frontend.brands');
Route::get('/brands/{slug}', [BrandController::class, 'show'])->name('frontend.brands.show');
