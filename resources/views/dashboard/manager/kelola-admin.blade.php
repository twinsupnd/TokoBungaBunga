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

<div style="margin-top:12px; display:flex; align-items:center; justify-content:space-between; gap:12px;">
    <div style="display:flex; gap:12px; align-items:center;">
        <form method="GET" action="{{ route('manager.kelola.index') }}" style="display:flex; gap:10px; align-items:center;">
            <select name="role" style="padding:10px;border-radius:8px;border:1px solid #e6e7ea;">
                <option value="">All Roles</option>
                @foreach(($roles ?? []) as $r)
                    <option value="{{ $r }}" {{ request('role') === $r ? 'selected' : '' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>

            <select name="plan" style="padding:10px;border-radius:8px;border:1px solid #e6e7ea;">
                <option value="">All Plans</option>
                <option value="enterprise" {{ request('plan')==='enterprise' ? 'selected' : '' }}>Enterprise</option>
                <option value="team" {{ request('plan')==='team' ? 'selected' : '' }}>Team</option>
                <option value="basic" {{ request('plan')==='basic' ? 'selected' : '' }}>Basic</option>
            </select>

            <select name="status" style="padding:10px;border-radius:8px;border:1px solid #e6e7ea;">
                <option value="">Any Status</option>
                <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Inactive</option>
            </select>

            <button type="submit" style="padding:8px 12px;background:#f3f4f6;border-radius:8px;border:1px solid #e6e7ea;">Filter</button>
        </form>
    </div>

    <div style="display:flex; gap:10px; align-items:center;">
        <div>
            <input type="text" name="q" value="{{ request('q') }}" formmethod="get" formaction="{{ route('manager.kelola.index') }}" placeholder="Search user" style="padding:10px;border-radius:8px;border:1px solid #e6e7ea;" />
        </div>
        <a href="{{ route('manager.kelola.create') }}" style="background:var(--accent);color:white;padding:8px 12px;border-radius:8px;text-decoration:none;font-weight:700;">Add New User</a>
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
                            <td style="padding:10px;vertical-align:middle;">{{ ucfirst($admin->role) }}</td>
                            <td style="padding:10px;vertical-align:middle;">-</td>
                            <td style="padding:10px;vertical-align:middle;">
                                @if($admin->email_verified_at)
                                    <span style="background:#dcfce7;color:#14532d;padding:6px 8px;border-radius:999px;font-weight:700;font-size:12px;">Active</span>
                                @else
                                    <span style="background:#f3f4f6;color:#6b7280;padding:6px 8px;border-radius:999px;font-weight:700;font-size:12px;">Inactive</span>
                                @endif
                            </td>
                            <td style="padding:10px;vertical-align:middle;text-align:right;">
                                <a href="{{ route('manager.kelola.edit', $admin) }}" title="Edit" style="margin-right:8px;color:var(--accent);font-weight:700;">Edit</a>

                                <form method="POST" action="{{ route('manager.kelola.destroy', $admin) }}" style="display:inline;" onsubmit="return confirm('Hapus admin {{ addslashes($admin->name) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none;border:none;color:#e11d48;font-weight:700;cursor:pointer;">Delete</button>
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
