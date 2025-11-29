@extends('dashboard.layout')

@section('title', 'Dashboard')

@section('content')

<style>
    .dashboard-header { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 28px; }
    .dashboard-header h1 { margin: 0 0 4px 0; font-size: 28px; color: var(--text); font-weight: 700; }
    .dashboard-header p { margin: 0; font-size: 14px; color: var(--muted); }
    .user-info { display: flex; align-items: center; gap: 12px; }
    .user-details { text-align: right; }
    .user-details-name { font-weight: 700; color: var(--text); }
    .user-details-role { font-size: 12px; color: var(--muted); }
    .role-badge { background: linear-gradient(90deg, var(--pastel-accent), var(--pastel-accent-2)); color: #fff; padding: 6px 12px; border-radius: 8px; font-weight: 600; font-size: 12px; }

    .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 18px; margin-bottom: 28px; }
    .stat-card { background: var(--pastel-card); border-radius: 14px; padding: 22px; box-shadow: 0 8px 20px rgba(34,34,59,0.04); border: 1px solid rgba(199,183,255,0.1); }
    .stat-card h3 { margin: 0 0 12px 0; font-size: 14px; font-weight: 600; color: var(--muted); text-transform: uppercase; letter-spacing: 0.5px; }
    .stat-card p { margin: 0; font-size: 28px; font-weight: 700; color: var(--pastel-accent); }

    .activity-section { background: var(--pastel-card); border-radius: 14px; padding: 22px; box-shadow: 0 8px 20px rgba(34,34,59,0.04); border: 1px solid rgba(199,183,255,0.1); }
    .activity-section h3 { margin: 0 0 16px 0; font-size: 16px; font-weight: 700; color: var(--text); }
    .activity-list { list-style: none; margin: 0; padding: 0; }
    .activity-list li { padding: 10px 0; font-size: 14px; color: var(--text); border-bottom: 1px solid rgba(199,183,255,0.1); }
    .activity-list li:last-child { border-bottom: none; }
    .activity-list strong { color: var(--pastel-accent); font-weight: 600; }

    @media (max-width: 768px) {
        .dashboard-header { flex-direction: column; align-items: flex-start; }
        .stats-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-header">
    <div>
        <h1>Dashboard</h1>
        <p>Ringkasan performa dan aktivitas.</p>
    </div>

    <div class="user-info">
        @if(auth()->check())
            <div class="user-details">
                <div class="user-details-name">{{ auth()->user()->name }}</div>
                <div class="user-details-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
            <div class="role-badge">{{ strtoupper(auth()->user()->role) }}</div>
        @endif
    </div>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <h3>Penjualan Hari Ini</h3>
        <p>Rp 1.250.000</p>
    </div>

    <div class="stat-card">
        <h3>Total Bulanan</h3>
        <p>Rp 12.860.000</p>
    </div>

    <div class="stat-card">
        <h3>Admin Aktif</h3>
        <p>4 orang</p>
    </div>
</div>

<div class="activity-section">
    <h3>Aktivitas Terakhir</h3>
    <ul class="activity-list">
        <li>- Riwayat login admin: <strong>2 jam lalu</strong></li>
        <li>- Pesanan baru: <strong>3 pesanan</strong></li>
        <li>- Stok <strong>Baby Blooms Bouquet</strong> di bawah threshold</li>
    </ul>
</div>

@endsection
