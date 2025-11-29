@extends('dashboard.layout')

@section('title', 'Manager Dashboard')

@section('content')

<div class="dashboard-header">
    <h1 class="page-title">Panel Manager</h1>
    <p class="text-sm text-gray-500">Kelola admin dan pengaturan tingkat tinggi.</p>
</div>

<div class="stats-grid" style="margin-top:14px;">
    <div class="stat-card">
        <h3>Total Admin</h3>
        <p>{{ $admins->count() ?? 0 }} orang</p>
    </div>
    <div class="stat-card">
        <h3>Aktivitas Terakhir</h3>
        <p>--</p>
    </div>
    <div class="stat-card">
        <h3>Notifikasi Sistem</h3>
        <p>--</p>
    </div>
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
                                <a href="#" style="color:var(--accent); font-weight:700;">Kelola</a>
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
