<div class="sidebar">

    <div class="sidebar-header">
        <h2>Toko Bunga</h2>
    </div>

    <ul class="sidebar-menu">

        {{-- Dashboard --}}
        <li>
            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>
        </li>

        {{-- Profil --}}
        <li>
            <a href="{{ route('dashboard.profile') }}"
               class="{{ request()->routeIs('dashboard.profile') ? 'active' : '' }}">
                Profil
            </a>
        </li>

        {{-- Analitik Keuangan --}}
        <li>
            <a href="{{ route('dashboard.analytics') }}"
               class="{{ request()->routeIs('dashboard.analytics') ? 'active' : '' }}">
                Analitik Keuangan
            </a>
        </li>

        {{-- Kelola Produk untuk admin/manager --}}
        @if(auth()->check() && in_array(auth()->user()->role, ['admin','manager']))
            <li>
                <a href="{{ route('dashboard.jenis.index') }}"
                   class="{{ request()->is('dashboard/jenis*') ? 'active' : '' }}">
                    Kelola Produk
                </a>
            </li>
        @endif

        {{-- PANEL MANAGER --}}
        @if(auth()->check() && auth()->user()->role === 'manager')

            {{-- Manager Dashboard --}}
            <li>
                <a href="{{ route('manager.dashboard') }}"
                   class="{{ request()->routeIs('manager.dashboard') ? 'active' : '' }}">
                    Panel Manager
                </a>
            </li>

            {{-- Kelola Admin --}}
            <li>
                <a href="{{ route('manager.kelolaAdmin') }}"
                   class="{{ request()->routeIs('manager.kelolaAdmin') ? 'active' : '' }}">
                    Kelola Admin
                </a>
            </li>

        @endif

        {{-- Laporan --}}
        <li>
            <a href="/dashboard/laporan"
               class="{{ request()->is('dashboard/laporan') ? 'active' : '' }}">
                Laporan
            </a>
        </li>

    </ul>

    <div class="sidebar-bottom">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>

</div>