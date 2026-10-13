<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // ---------------
    // Role slug → dashboard route map
    // ---------------
    private const DASHBOARD_ROUTES = [
        'super_admin' => 'manage.dashboard.index',
        'admin'       => 'manage.dashboard.index',
        'customer'    => 'client.dashboard',
    ];

    // ---------------
    // Enforce role-based portal access.
    // $roles = list of slugs allowed to enter this portal.
    // ---------------
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        // ---------------
        // Resolve the user's role slugs through the pivot
        // ---------------
        $slugs = $user->roles()->pluck('slug')->all();

        if (!array_intersect($slugs, $roles)) {
            $primary  = $slugs[0] ?? null;
            $redirect = self::DASHBOARD_ROUTES[$primary] ?? 'home';

            return redirect()->route($redirect)
                ->with('error', 'You do not have permission to access that area.');
        }

        return $next($request);
    }
}
