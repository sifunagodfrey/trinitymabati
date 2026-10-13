<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnforceRememberSession
{
    // ---------------
    // Enforce the custom remember-me duration stored in session.
    // Only applies when the user chose "remember me" at login.
    // Uses a sliding window - activity extends the session each request.
    // ---------------
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->session()->has('session_expires_at')) {

            $expiresAt = $request->session()->get('session_expires_at');

            if (now()->isAfter($expiresAt)) {
                // ---------------
                // Session has expired - determine correct login page before logging out
                // ---------------
                /** @var \App\Models\User $user */
                $user = Auth::user();
                $user->loadMissing('role');
                $slug = $user->role?->slug ?? '';

                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                $loginRoute = in_array($slug, ['super_admin', 'admin'], true)
                    ? 'manage.auth.login'
                    : 'login';

                return redirect()->route($loginRoute)
                    ->withErrors(['email' => 'Your session has expired. Please log in again.']);
            }

            // ---------------
            // Still valid - extend expiry (sliding window)
            // ---------------
            $minutes = $request->session()->get('session_remember_minutes', 1440);
            $request->session()->put('session_expires_at', now()->addMinutes($minutes)->toDateTimeString());
        }

        return $next($request);
    }
}
