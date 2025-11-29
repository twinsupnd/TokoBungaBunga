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

<div style="margin-top:12px;">
    <a href="{{ route('manager.kelola.create') }}" style="background:var(--accent);color:white;padding:8px 12px;border-radius:6px;text-decoration:none;font-weight:700;">Buat Admin Baru</a>
</div>

<div class="mt-6">
    <div class="stat-card">
        <h3>Daftar Admin</h3>
        <div style="margin-top:10px; overflow:auto;">
            <table style="width:100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align:left; border-bottom:1px solid #e6e7ea;">
                        <th style="padding:8px">Nama</th>
                        <th style="padding:8px">Email</th>
                        <th style="padding:8px">Terdaftar</th>
                        <th style="padding:8px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $admin)
                        <tr style="border-bottom:1px solid #f3f4f6;">
                            <td style="padding:8px">{{ $admin->name }}</td>
                            <td style="padding:8px">{{ $admin->email }}</td>
                            <td style="padding:8px">{{ $admin->created_at->format('Y-m-d') }}</td>
                            <td style="padding:8px">
                                <a href="{{ route('manager.kelola.edit', $admin) }}" style="color:var(--accent); font-weight:700; margin-right:8px;">Edit</a>

                                <form method="POST" action="{{ route('manager.kelola.destroy', $admin) }}" style="display:inline;" onsubmit="return confirm('Hapus admin {{ addslashes($admin->name) }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none;border:none;color:#e11d48;font-weight:700;cursor:pointer;">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding:8px">Belum ada admin terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
