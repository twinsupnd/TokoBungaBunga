@extends('dashboard.layout')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-header" style="display:flex; align-items:center; justify-content:space-between; gap:12px;">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="text-sm text-gray-500">Ringkasan performa dan aktivitas.</p>
    </div>

    <div style="display:flex; align-items:center; gap:12px;">
        @if(auth()->check())
            <div style="text-align:right">
                <div style="font-weight:700">{{ auth()->user()->name }}</div>
                <div style="font-size:12px; color:#6b7280">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
            <div style="background:var(--accent); color:#fff; padding:6px 10px; border-radius:8px; font-weight:700">{{ strtoupper(auth()->user()->role) }}</div>
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

<div class="mt-6">
    <div class="stat-card" style="padding:16px;">
        <h3>Aktivitas Terakhir</h3>
        <ul class="text-sm" style="margin-top:8px; color:#4b5563;">
            <li>- Riwayat login admin: 2 jam lalu</li>
            <li>- Pesanan baru: 3 pesanan</li>
            <li>- Stok <strong>Baby Blooms Bouquet</strong> di bawah threshold</li>
        </ul>
    </div>
</div>

@endsection
