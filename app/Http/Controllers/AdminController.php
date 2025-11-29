<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
    /**
     * Display a listing of admins.
     */
    public function index(): RedirectResponse
    {
        return redirect()->route('dashboard')->with('info', 'Fitur pengelolaan admin dinonaktifkan.');
    }

    /**
     * Show the form for creating a new admin.
     */
    public function create(): RedirectResponse
    {
        return redirect()->route('dashboard')->with('info', 'Fitur pembuatan admin dinonaktifkan.');
    }

    /**
     * Store a newly created admin in database.
     */
    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('dashboard')->with('info', 'Fitur pembuatan admin dinonaktifkan.');
    }

    /**
     * Show the form for editing an admin.
     */
    public function edit(User $admin): RedirectResponse
    {
        if (!in_array($admin->role, ['admin', 'manager'])) {
            abort(403, 'User bukan admin atau manager');
        }
        return redirect()->route('dashboard')->with('info', 'Fitur pengubahan admin dinonaktifkan.');
    }

    /**
     * Update the specified admin in database.
     */
    public function update(Request $request, User $admin): RedirectResponse
    {
        if (!in_array($admin->role, ['admin', 'manager'])) {
            abort(403, 'User bukan admin atau manager');
        }
        return redirect()->route('dashboard')->with('info', 'Fitur pengubahan admin dinonaktifkan.');
    }

    /**
     * Remove the specified admin from database.
     */
    public function destroy(User $admin): RedirectResponse
    {
        if (!in_array($admin->role, ['admin', 'manager'])) {
            abort(403, 'User bukan admin atau manager');
        }
        return redirect()->route('dashboard')->with('info', 'Fitur penghapusan admin dinonaktifkan.');
    }
}
