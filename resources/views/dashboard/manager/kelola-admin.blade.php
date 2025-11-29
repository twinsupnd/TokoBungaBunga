@extends('dashboard.layout')

@section('title', 'Kelola Admin')

@section('content')

<div class="dashboard-header">
    <h1 class="page-title">Kelola Admin</h1>
    <p class="text-sm text-gray-500">Halaman manajemen admin — lihat, edit, atau hapus akun admin.</p>
</div>

@if(session('success'))
    <div style="margin-top:12px;background:#ecfccb;padding:10px;border-radius:6px;color:#365314;">
        {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div style="margin-top:12px;background:#fee2e2;padding:10px;border-radius:6px;color:#991b1b;">
        {{ session('error') }}
    </div>
@endif

<div style="margin-top:12px; display:flex; flex-direction:column; gap:12px;">
    <div style="display:flex; gap:12px; align-items:flex-start; justify-content:space-between; flex-wrap:wrap;">
        <div style="min-width:320px; flex:1 1 56%;">
            <div style="font-weight:700; margin-bottom:8px;">Filters</div>
        <form method="GET" action="{{ route('manager.kelola.index') }}" style="display:flex; gap:10px; align-items:center; flex-wrap:wrap;">
            <select name="role" style="padding:10px;border-radius:8px;border:1px solid #e6e7ea; min-width:150px;">
                <option value="">All Roles</option>
                @foreach(($roles ?? []) as $r)
                    <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>

            <select name="plan" style="padding:10px;border-radius:8px;border:1px solid #e6e7ea; min-width:150px;">
                <option value="">Select Plan</option>
                <option value="enterprise" {{ request('plan')==='enterprise' ? 'selected' : '' }}>Enterprise</option>
                <option value="team" {{ request('plan')==='team' ? 'selected' : '' }}>Team</option>
                <option value="basic" {{ request('plan')==='basic' ? 'selected' : '' }}>Basic</option>
            </select>

            <select name="status" style="padding:10px;border-radius:8px;border:1px solid #e6e7ea; min-width:140px;">
                <option value="">Select Status</option>
                <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" style="padding:8px 12px;background:#fff;border-radius:8px;border:1px solid #e6e7ea;color:#374151;">Filter</button>
        </form>

        </div>

        <div style="display:flex; gap:10px; align-items:center;">
            <div style="display:flex; gap:8px; align-items:center;">
                <button style="display:inline-flex; gap:8px; align-items:center; padding:8px 10px; border-radius:8px;border:1px solid #e6e7ea; background:#fff;"> 
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" stroke="#374151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 10l5 5 5-5" stroke="#374151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Export
                </button>
            </div>

            <form method="GET" action="{{ route('manager.kelola.index') }}" style="display:inline-block;">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Search User" style="padding:8px;border-radius:8px;border:1px solid #e6e7ea; min-width:220px;" />
            </form>

            <a href="{{ route('manager.kelola.create') }}" style="background:#7c3aed;color:white;padding:10px 16px;border-radius:8px;text-decoration:none;font-weight:700;">Add New User</a>
        </div>
    </div>
</div>

<div class="mt-6">
    <div class="stat-card">
        <h3>Daftar Admin</h3>
        <div style="margin-top:10px; overflow:auto;">
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align:left; border-bottom:1px solid #e6e7ea;">
                        <th style="padding:10px;width:36px;"><input type="checkbox" /></th>
                        <th style="padding:10px">User</th>
                        <th style="padding:10px">Email</th>
                        <th style="padding:10px">Role</th>
                        <th style="padding:10px">Plan</th>
                        <th style="padding:10px">Status</th>
                        <th style="padding:10px;text-align:right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:10px;vertical-align:middle;"><input type="checkbox" name="select[]" value="{{ $admin->id }}" /></td>
                            <td style="padding:10px;vertical-align:middle;">
                                <div style="display:flex; gap:8px; align-items:center;">
                                    <div style="width:36px;height:36px;border-radius:50%;background:#f3f4f6;display:flex;align-items:center;justify-content:center;color:#6b7280;font-weight:700;">{{ strtoupper(\Illuminate\Support\Str::substr($admin->name,0,1)) }}</div>
                                    <div>
                                        <div style="font-weight:700">{{ $admin->name }}</div>
                                        <div style="font-size:12px;color:#6b7280">{{ '@' . \Illuminate\Support\Str::slug($admin->name, '') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td style="padding:10px;vertical-align:middle;">{{ $admin->email }}</td>
                            <td style="padding:10px;vertical-align:middle;">
                                @php
                                    $roleLabel = ucfirst($admin->role);
                                @endphp
                                {{-- small role icon + label --}}
                                <div style="display:inline-flex; gap:8px; align-items:center;">
                                    @if($admin->role === 'manager')
                                        <div style="width:26px;height:26px;border-radius:6px;background:#ecfeff;display:inline-flex;align-items:center;justify-content:center;color:#0f766e;font-weight:700;font-size:12px;">M</div>
                                    @elseif($admin->role === 'admin')
                                        <div style="width:26px;height:26px;border-radius:6px;background:#eef2ff;display:inline-flex;align-items:center;justify-content:center;color:#3730a3;font-weight:700;font-size:12px;">A</div>
                                    @else
                                        <div style="width:26px;height:26px;border-radius:6px;background:#f3f4f6;display:inline-flex;align-items:center;justify-content:center;color:#6b7280;font-weight:700;font-size:12px;">U</div>
                                    @endif
                                    <span style="font-weight:700">{{ $roleLabel }}</span>
                                </div>
                            </td>
                            <td style="padding:10px;vertical-align:middle;">
                                @php
                                    $plan = $admin->role === 'admin' ? 'Enterprise' : ($admin->role === 'manager' ? 'Team' : '-');
                                @endphp
                                <span style="color:#374151">{{ $plan }}</span>
                            </td>
                            <td style="padding:10px;vertical-align:middle;">
                                @if($admin->email_verified_at)
                                    <span style="background:#dcfce7;color:#14532d;padding:6px 8px;border-radius:999px;font-weight:700;font-size:12px;">Active</span>
                                @else
                                    <span style="background:#f3f4f6;color:#6b7280;padding:6px 8px;border-radius:999px;font-weight:700;font-size:12px;">Inactive</span>
                                @endif
                            </td>
                            <td style="padding:10px;vertical-align:middle;text-align:right;">
                                <a href="{{ route('manager.kelola.edit', $admin) }}" title="Edit" style="margin-right:8px;color:var(--accent);display:inline-flex;align-items:center;gap:6px;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 21h3.75L18.81 8.94l-3.75-3.75L3 17.25V21z" stroke="#6d28d9" stroke-width="0" fill="#7c3aed"/></svg>
                                </a>

                                <form method="POST" action="{{ route('manager.kelola.destroy', $admin) }}" style="display:inline;" onsubmit="return confirm('Hapus admin {{ addslashes($admin->name) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Delete" style="background:none;border:none;color:#e11d48;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3 6h18" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 6v13a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M10 11v6" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M14 11v6" stroke="#ef4444" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding:8px">Belum ada admin terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div style="margin-top:12px; display:flex; justify-content:flex-end;">
                {{ $admins->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
