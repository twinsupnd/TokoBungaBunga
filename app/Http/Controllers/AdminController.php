<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('dashboard.manager.kelola-admin', compact('admins'));
    }

    public function create()
    {
        return view('dashboard.manager.create-admin');
    }

    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'admin',
            'promoted_to_admin_at' => now(),
        ]);

        return redirect()->route('manager.kelolaAdmin')->with('success', 'Admin berhasil dibuat.');
    }

    public function edit(User $user)
    {
        if ($user->role !== 'admin') {
            abort(404);
        }

        return view('dashboard.manager.edit-admin', compact('user'));
    }

    public function update(UpdateAdminRequest $request, User $user)
    {
        if ($user->role !== 'admin') {
            abort(404);
        }

        $data = $request->validated();

        $user->name = $data['name'];
        $user->email = $data['email'];
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return redirect()->route('manager.kelolaAdmin')->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'admin') {
            abort(404);
        }

        // Prevent deleting last admin
        $adminCount = User::where('role', 'admin')->count();
        if ($adminCount <= 1) {
            return redirect()->route('manager.kelolaAdmin')->with('error', 'Tidak dapat menghapus admin terakhir.');
        }

        $user->delete();

        return redirect()->route('manager.kelolaAdmin')->with('success', 'Admin berhasil dihapus.');
    }
}
