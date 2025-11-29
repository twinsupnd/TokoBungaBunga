<div class="sidebar">

    <div class="sidebar-header">
        <h2>Toko Bunga</h2>
    </div>

    <ul class="sidebar-menu">
        <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a></li>
        <li><a href="/dashboard/profil" class="{{ request()->is('dashboard/profil') ? 'active' : '' }}">Profil</a></li>
        <li><a href="/dashboard/analitik" class="{{ request()->is('dashboard/analitik') ? 'active' : '' }}">Analitik Keuangan</a></li>
        <li><a href="/dashboard/admin" class="{{ request()->is('dashboard/admin') ? 'active' : '' }}">Data Admin</a></li>
        @if(auth()->check() && in_array(auth()->user()->role, ['admin','manager']))
            <li><a href="{{ route('dashboard.jenis.index') }}" class="{{ request()->is('dashboard/jenis*') ? 'active' : '' }}">Kelola Produk</a></li>
        @endif
        @if(auth()->check() && auth()->user()->role === 'manager')
            <li><a href="{{ route('manager.dashboard') }}" class="{{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">Panel Manager</a></li>
            <li><a href="/dashboard/manage-admins" class="{{ request()->is('dashboard/manage-admins') ? 'active' : '' }}">Kelola Admin</a></li>
        @endif
        <li><a href="/dashboard/laporan" class="{{ request()->is('dashboard/laporan') ? 'active' : '' }}">Laporan</a></li>
    </ul>

    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

</div>
