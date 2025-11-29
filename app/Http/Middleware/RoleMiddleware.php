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
    public function handle(Request $request, Closure $next, string $roles = null)
    {
        if (! auth()->check()) {
            // Not authenticated — let the auth middleware handle redirects.
            abort(403);
        }

        if (empty($roles)) {
            // No specific role requested — allow access
            return $next($request);
        }

        $allowed = array_map('trim', explode(',', $roles));
        $userRole = auth()->user()->role ?? null;

        if (! $userRole || ! in_array($userRole, $allowed)) {
            abort(403);
        }

        return $next($request);
    }
}
