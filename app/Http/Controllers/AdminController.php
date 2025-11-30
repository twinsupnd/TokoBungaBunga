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
	 * Export the current admin listing as CSV (spreadsheet-like) using active filters.
	 */
	public function export(\Illuminate\Http\Request $request)
	{
		// Build the same query as index to respect filters
		$query = User::query();

		if ($request->filled('role')) {
			$query->where('role', $request->input('role'));
		} else {
			$query->where('role', 'admin');
		}

		if ($request->filled('status')) {
			if ($request->input('status') === 'active') {
				$query->whereNotNull('email_verified_at');
			} elseif ($request->input('status') === 'inactive') {
				$query->whereNull('email_verified_at');
			}
		}

		if ($request->filled('q')) {
			$q = $request->input('q');
			$query->where(function ($qbuilder) use ($q) {
				$qbuilder->where('name', 'like', "%{$q}%")
					->orWhere('email', 'like', "%{$q}%");
			});
		}

		$users = $query->orderBy('created_at', 'desc')->get();

		$filename = 'admins-export-' . now()->format('Y-m-d_His') . '.csv';

		return response()->streamDownload(function () use ($users) {
			$handle = fopen('php://output', 'w');
			// CSV header
			fputcsv($handle, ['Name', 'Email', 'Role', 'Status', 'Created At']);
			foreach ($users as $u) {
				fputcsv($handle, [
					$u->name,
					$u->email,
					$u->role,
					$u->email_verified_at ? 'Active' : 'Inactive',
					$u->created_at ? $u->created_at->toDateTimeString() : '',
				]);
			}
			fclose($handle);
		}, $filename, [
			'Content-Type' => 'text/csv; charset=utf-8',
			'Content-Disposition' => "attachment; filename=\"{$filename}\"",
		]);
	}

	/**
	 * Display a listing of admins.
	 */
	public function index(\Illuminate\Http\Request $request): View
	{
		// List users from users table for management. Support filters and search.
		$query = User::query();

		// Only treat 'admin' role listing by default, but allow filtering by role param
		if ($request->filled('role')) {
			$query->where('role', $request->input('role'));
		} else {
			// Default to showing admin accounts only on this page
			$query->where('role', 'admin');
		}

		// Status filter: active = email_verified_at not null, inactive = null
		if ($request->filled('status')) {
			if ($request->input('status') === 'active') {
				$query->whereNotNull('email_verified_at');
			} elseif ($request->input('status') === 'inactive') {
				$query->whereNull('email_verified_at');
			}
		}

		// Simple search across name and email
		if ($request->filled('q')) {
			$q = $request->input('q');
			$query->where(function ($qbuilder) use ($q) {
				$qbuilder->where('name', 'like', "%{$q}%")
					->orWhere('email', 'like', "%{$q}%");
			});
		}

		// Order and pagination
		$admins = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();

		// Provide available roles for filters
		$roles = User::select('role')->distinct()->pluck('role')->filter()->values();

		return view('dashboard.manager.kelola-admin', compact('admins', 'roles'));
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

		// handle status: if provided, set email_verified_at accordingly after create
		$status = $data['status'] ?? 'active';
		unset($data['status']);

		$admin = User::create($data + ['promoted_to_admin_at' => now()]);

		if ($status === 'active') {
			$admin->email_verified_at = $admin->email_verified_at ?? now();
		} else {
			$admin->email_verified_at = null;
		}
		$admin->save();

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

		// Handle status update (active/inactive) — active sets email_verified_at, inactive clears it
		if (array_key_exists('status', $data)) {
			if ($data['status'] === 'active') {
				$data['email_verified_at'] = $admin->email_verified_at ?? now();
			} else {
				// explicitly clear verification
				$data['email_verified_at'] = null;
			}
			unset($data['status']);
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
