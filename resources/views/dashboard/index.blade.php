@extends('dashboard.layout')

@section('title', 'Dashboard')

@section('content')

<h1 class="page-title">Dashboard</h1>

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

@endsection
