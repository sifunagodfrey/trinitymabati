<?php

namespace App\Providers;

use App\Models\Manage\SystemMessage;
use App\Services\CurrencyConverterService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * -------------------
     * Register Services
     * -------------------
     */
    public function register(): void
    {
        // -------------------
        // Set Public Path to Root
        // -------------------
        $this->app->bind('path.public', function () {
            return base_path();
        });

        // -------------------
        // Currency service - singleton so rates are only fetched once per request
        // -------------------
        $this->app->singleton(CurrencyConverterService::class);
    }

    /**
     * -------------------
     * Bootstrap Services
     * -------------------
     */
    public function boot(): void
    {
        \Illuminate\Support\Facades\RateLimiter::for('storefront-auth', fn ($request) =>
            \Illuminate\Cache\RateLimiting\Limit::perMinute(6)->by(hash('sha256', $request->ip() . '|' . $request->path()))
        );
        \App\Models\Manage\Products\Product::observe(\App\Observers\SeoSlugObserver::class);
        \App\Models\Manage\Products\Category::observe(\App\Observers\SeoSlugObserver::class);
        $this->app['router']->pushMiddlewareToGroup('web', \App\Http\Middleware\StorefrontProtection::class);
        View::composer(['frontend.layouts.app', 'frontend.layouts.home'], function ($view) {
            $view->with('seo', app(\App\Services\Seo\SeoService::class)->metadata($view->getData()));
        });

        // Read the storefront name from su_settings. The .env APP_NAME remains
        // the fallback while the database is unavailable during installation.
        try {
            if (Schema::hasTable('su_settings')) {
                config([
                    'app.name' => \App\Models\Core\Setting::get('site_name', config('app.name')),
                ]);
            }
        } catch (\Throwable $e) {
            // Keep the configured fallback when the database is unavailable.
        }

        // -------------------
        // Add Platform Views
        // -------------------
        // This does NOT override Laravel defaults
        // It EXTENDS them safely
        //
        // Priority:
        // 1. platform/
        // 2. resources/views/
        // -------------------
        View::addLocation(base_path('platform'));

        // -------------------
        // Currency - share active currency data with all user-facing views
        // Covers: frontend.* and client.* portals
        // -------------------
        View::composer('*', function ($view) {
            try {
                $branding = \App\Models\Core\Setting::siteBranding();
            } catch (\Throwable $e) {
                $branding = [
                    'site_name' => config('app.name'),
                    'logo_main' => url('public/images/suweka-logo.png'),
                    'logo_white' => url('public/images/suweka-logo.png'),
                    'logo_dark' => url('public/images/suweka-logo.png'),
                    'site_icon' => url('public/images/suweka-icon.png'),
                    'apple_touch_icon' => url('public/images/suweka-icon.png'),
                    'primary_color' => '#713FCE',
                    'secondary_color' => '#AD70D4',
                    'tertiary_color' => '#201436',
                ];
            }
            $view->with('branding', $branding);
        });

        View::composer(['frontend.*', 'client.*'], function ($view) {
            /** @var CurrencyConverterService $currency */
            $currency = app(CurrencyConverterService::class);
            $code     = $currency->getActiveCurrency();

            $view->with([
                'activeCurrency'      => $code,
                'currencySymbol'      => $currency->getSymbol($code),
                'currencyRate'        => $currency->getRate($code),
                'availableCurrencies' => $currency->getAvailableCurrencies(),
                'site'                => \App\Models\Core\Setting::siteContact(),
            ]);
        });

        // ---------------
        // Admin topbar/sidebar badge counts - share real data with manage partials
        // ---------------
        View::composer(['manage.partials.topbar', 'manage.partials.sidebar'], function ($view) {
            $adminId = auth()->id();

            if (!$adminId) {
                $view->with([
                    'unreadMessages'      => 0,
                    'unreadNotifications' => 0,
                    'recentNotifications' => collect(),
                    'todayVisitors'       => 0,
                ]);
                return;
            }

            $unreadMessages = SystemMessage::forAdmin($adminId)
                ->unread()
                ->count();

            $unreadNotifications = DB::table('su_notifications')
                ->where('user_id', $adminId)
                ->where('is_read', 0)
                ->count();

            $recentNotifications = DB::table('su_notifications')
                ->where('user_id', $adminId)
                ->where('is_read', 0)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get()
                ->map(function ($n) {
                    $n->time_ago = Carbon::parse($n->created_at)->diffForHumans();
                    return $n;
                });

            // ---------------
            // Visitor badge - count visits since admin last viewed the visitors log page
            // ---------------
            $lastViewed = DB::table('su_settings')
                ->where('setting_key', 'visitors_log_last_viewed_at')
                ->value('setting_value');

            $todayVisitors = DB::table('su_visitors_logs')
                ->when($lastViewed, fn ($q) => $q->where('visit_time', '>', $lastViewed))
                ->count();

            $view->with(compact('unreadMessages', 'unreadNotifications', 'recentNotifications', 'todayVisitors'));
        });

        // -------------------
        // @price($amount) - format a KES-base amount in the active currency
        // Usage: @price($product->price)  or  @price($varMin ?? 0)
        // -------------------
        Blade::directive('price', function ($expression) {
            return "<?php echo app(\App\Services\CurrencyConverterService::class)->format((float)({$expression})); ?>";
        });
    }
}
