<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    // ---------------
    // URL path prefixes that should never be recorded
    // ---------------
    private array $skipPrefixes = [
        'manage',
        '_debugbar',
        'livewire',
    ];

    // ---------------
    // File extensions to ignore (static assets)
    // ---------------
    private array $skipExtensions = [
        'css', 'js', 'ico', 'png', 'jpg', 'jpeg', 'gif', 'svg',
        'woff', 'woff2', 'ttf', 'eot', 'map', 'webp', 'pdf',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // ---------------
        // Only record GET requests that return an HTML page
        // ---------------
        if (!$request->isMethod('GET')) {
            return $response;
        }

        // ---------------
        // Skip AJAX / XHR and JSON responses
        // ---------------
        if ($request->ajax() || $request->wantsJson()) {
            return $response;
        }

        // ---------------
        // Skip static asset extensions
        // ---------------
        $path      = ltrim($request->path(), '/');
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        if ($extension && \in_array($extension, $this->skipExtensions, true)) {
            return $response;
        }

        // ---------------
        // Skip admin panel and internal routes
        // ---------------
        foreach ($this->skipPrefixes as $prefix) {
            if ($path === $prefix || str_starts_with($path, $prefix . '/')) {
                return $response;
            }
        }

        // ---------------
        // Skip non-2xx responses (errors, redirects already handled)
        // ---------------
        $status = $response->getStatusCode();
        if ($status < 200 || $status >= 300) {
            return $response;
        }

        // ---------------
        // Record the visit
        // ---------------
        try {
            DB::table('su_visitors_logs')->insert([
                'ip_address'   => $request->ip(),
                'user_agent'   => substr($request->userAgent() ?? '', 0, 512),
                'visited_url'  => $request->fullUrl(),
                'referrer_url' => $request->headers->get('referer'),
                'session_id'   => $request->hasSession() ? $request->session()->getId() : null,
                'user_id'      => auth()->check() ? auth()->id() : null,
                'visit_time'   => now(),
                'country'      => null,
            ]);
        } catch (\Throwable) {
            // ---------------
            // Never let tracking failures break the response
            // ---------------
        }

        return $response;
    }
}
