<?php

namespace App\Http\Middleware;

use App\Models\Core\Setting;
use App\Services\Seo\SeoService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StorefrontProtection
{
    public function handle(Request $request, Closure $next): Response
    {
        // Opt-in canonical origin redirect. APP_URL must be the verified live storefront.
        if (app()->environment('production') && $request->isMethodSafe()
            && ((string) config('seo.admin_domain', '') === '' || strcasecmp($request->getHost(), (string) config('seo.admin_domain')) !== 0)
            && $request->routeIs('frontend.*', 'home', 'seo.*')
            && Setting::get('seo_canonical_redirect', '0') === '1') {
            $preferred = rtrim((string) config('app.url'), '/');
            $parts = parse_url($preferred);
            $origin = $request->getSchemeAndHttpHost() . $request->getBaseUrl();
            if (!empty($parts['host']) && in_array($parts['scheme'] ?? '', ['http', 'https'], true)
                && rtrim($origin, '/') !== $preferred) {
                $query = $request->getQueryString();
                return redirect()->away($preferred . '/' . ltrim($request->path(), '/') . ($query ? '?' . $query : ''), 301);
            }
        }
        $response = $next($request);
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        if ($response->getStatusCode() >= 400 || !app(SeoService::class)->indexable($request)) {
            $response->headers->set('X-Robots-Tag', 'noindex, follow');
        }
        if ($request->routeIs('client.*', 'manage.*', 'frontend.checkout*', 'frontend.cart*', 'frontend.account', 'frontend.track-order*')) {
            $response->headers->set('Cache-Control', 'private, no-store, max-age=0');
        }
        return $response;
    }
}
