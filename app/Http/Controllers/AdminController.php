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
	public function index(): View
	{
		// List all admin users (role = admin) for management
		$admins = User::where('role', 'admin')->orderBy('created_at', 'desc')->get();
		return view('dashboard.manager.kelola-admin', compact('admins'));
	}

	/**
	 * Show the form for creating a new admin.
	 */
	public function create(): View
	{
		return view('dashboard.manager.create-admin');
	}

	/**
	 * Store a newly created admin in database.
	 */
	public function store(\App\Http\Requests\StoreAdminRequest $request): RedirectResponse
	{
		$data = $request->validated();
		$data['role'] = 'admin';

		// Hash password explicitly for clarity
		$data['password'] = Hash::make($data['password']);

		$admin = User::create($data + ['promoted_to_admin_at' => now()]);

		return redirect()->route('manager.kelola.index')->with('success', "Admin {$admin->name} berhasil dibuat.");
	}

	/**
	 * Show the form for editing an admin.
	 */
	public function edit(User $admin): View
	{
		if (!in_array($admin->role, ['admin', 'manager'])) {
			abort(403, 'User bukan admin atau manager');
		}
		return view('dashboard.manager.edit-admin', ['user' => $admin]);
	}

	/**
	 * Update the specified admin in database.
	 */
	public function update(\App\Http\Requests\UpdateAdminRequest $request, User $admin): RedirectResponse
	{
		if (!in_array($admin->role, ['admin', 'manager'])) {
			abort(403, 'User bukan admin atau manager');
		}
		$data = $request->validated();

		if (!empty($data['password'] ?? null)) {
			$data['password'] = Hash::make($data['password']);
		} else {
			unset($data['password']);
		}

		$admin->update($data);

		return redirect()->route('manager.kelola.index')->with('success', "Admin {$admin->name} berhasil diperbarui.");
	}

	/**
	 * Remove the specified admin from database.
	 */
	public function destroy(User $admin): RedirectResponse
	{
		if (!in_array($admin->role, ['admin', 'manager'])) {
			abort(403, 'User bukan admin atau manager');
		}
		// Prevent deleting last remaining admin
		$totalAdmins = User::where('role', 'admin')->count();
		if ($totalAdmins <= 1 && $admin->role === 'admin') {
			return back()->with('error', 'Tidak dapat menghapus admin terakhir.');
		}

		// Prevent deleting account in use by the authenticated user
		if (auth()->check() && auth()->id() === $admin->id) {
			return back()->with('error', 'Tidak dapat menghapus akun yang sedang digunakan.');
		}

		$admin->delete();

		return redirect()->route('manager.kelola.index')->with('success', "Admin {$admin->name} berhasil dihapus.");
	}
}
