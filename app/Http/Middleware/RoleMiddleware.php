<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request and ensure the user has the required role(s).
     * Accepts a single role or comma-separated list (e.g. 'admin' or 'admin,manager').
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (! auth()->check()) {
            // Not authenticated — let the auth middleware handle redirects.
            abort(403);
        }

        if (empty($roles)) {
            // No specific role requested — allow access
            return $next($request);
        }

        // Roles may be passed either as a single comma-separated string or as multiple params.
        // Normalize: flatten, split comma separated items, trim and lowercase.
        $flattened = [];
        foreach ($roles as $r) {
            foreach (explode(',', (string) $r) as $item) {
                $item = trim(strtolower($item));
                if ($item !== '') {
                    $flattened[] = $item;
                }
            }
        }

        $allowed = array_unique($flattened);
        $userRole = strtolower(trim((string) (auth()->user()->role ?? '')));

        if (! $userRole || ! in_array($userRole, $allowed, true)) {
            abort(403);
        }

        return $next($request);
    }
}
