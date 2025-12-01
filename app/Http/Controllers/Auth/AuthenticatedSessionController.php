<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Role-first redirect: manager -> manager dashboard, admin -> dashboard
        $user = $request->user();
        if ($user && isset($user->role)) {
            $role = strtolower(trim((string) $user->role));
            if ($role === 'manager') {
                return redirect()->route('manager.dashboard');
            }
            if ($role === 'admin') {
                return redirect()->route('dashboard');
            }
        }

        // Fallback to intended or Fortify home for other roles
        return redirect()->intended(config('fortify.home', '/'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
