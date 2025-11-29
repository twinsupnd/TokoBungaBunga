@extends('dashboard.layout')

@section('title', 'Manager Dashboard')

@section('content')

<style>
    .page-header { margin-bottom: 28px; }
    .page-title { font-size: 28px; font-weight: 700; color: var(--text); margin: 0; }
    .page-subtitle { font-size: 14px; color: var(--muted); margin: 6px 0 0 0; }

    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px; margin-bottom: 28px; }
    .stat-card { background: var(--pastel-card); border-radius: 14px; padding: 22px; box-shadow: 0 8px 20px rgba(34,34,59,0.04); border: 1px solid rgba(199,183,255,0.1); }
    .stat-card h3 { margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card p { margin: 0; font-size: 28px; font-weight: 700; color: var(--pastel-accent); }

    .card { background: var(--pastel-card); border-radius: 14px; padding: 24px; box-shadow: 0 8px 20px rgba(34,34,59,0.04); border: 1px solid rgba(199,183,255,0.1); }
    .card h2 { margin: 0 0 18px 0; font-size: 18px; font-weight: 700; color: var(--text); }

    .table-wrapper { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    th { background: linear-gradient(90deg, rgba(199,183,255,0.08), rgba(255,214,224,0.08)); padding: 12px; text-align: left; font-weight: 600; color: var(--text); font-size: 12px; text-transform: uppercase; border-bottom: 2px solid rgba(199,183,255,0.1); }
    td { padding: 14px 12px; border-bottom: 1px solid rgba(199,183,255,0.08); color: var(--text); font-size: 14px; }
    tr:hover { background: rgba(199,183,255,0.04); }

    .empty-cell { text-align: center; padding: 24px; color: var(--muted); }
</style>

<div class="page-header">
    <h1 class="page-title">👔 Panel Manager</h1>
    <p class="page-subtitle">Kelola admin dan pengaturan tingkat tinggi sistem</p>
</div>

<!-- Statistik Admin -->
<div class="stats-grid">
    <div class="stat-card">
        <h3>Total Admin</h3>
        <p>{{ $admins->count() ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <h3>Admin Aktif</h3>
        <p>{{ $admins->where('created_at', '>=', now()->subDays(30))->count() ?? 0 }}</p>
    </div>
    <div class="stat-card">
        <h3>Total Pengguna</h3>
        <p>{{ \App\Models\User::count() ?? 0 }}</p>
    </div>
</div>

<!-- Daftar Admin -->
<div class="card">
    <h2>👥 Daftar Admin Terdaftar</h2>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Terdaftar</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr>
                        <td><strong>{{ $admin->name }}</strong></td>
                        <td>{{ $admin->email }}</td>
                        <td>{{ $admin->created_at->format('d M Y') }}</td>
                        <td>
                            <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: var(--pastel-accent); margin-right: 6px;"></span>
                            Aktif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="empty-cell">📭 Belum ada admin terdaftar dalam sistem</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
