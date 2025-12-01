<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard</title>
    @if (class_exists(\Illuminate\Foundation\Vite::class))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @endif
    <style>
        :root {
            --pastel-bg: #F8F6FF;
            --pastel-card: #FFF8FB;
            --pastel-accent: #C7B7FF;
            --pastel-accent-2: #FFD6E0;
            --muted: #7B7B8B;
            --text: #22223B;
            --sidebar-width: 260px;
        }

        html,
        body,
        #app {
            height: 100%;
        }

        body {
            font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, 'Helvetica Neue', Arial;
            background: var(--pastel-bg);
            color: var(--text);
            margin: 0;
        }

        .dashboard-container {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        /* Sidebar fixed column */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--pastel-card), #FFF);
            border-right: 1px solid rgba(34, 34, 59, 0.04);
            box-shadow: 0 6px 18px rgba(180, 170, 200, 0.05);
            display: flex;
            flex-direction: column;
        }

        /* Make only the menu scrollable */
        .sidebar .sidebar-header {
            padding: 16px;
            flex: 0 0 auto;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar .sidebar-logo {
            width: 40px;
            height: 40px;
            object-fit: contain;
            border-radius: 8px;
        }

        .sidebar .sidebar-header a {
            text-decoration: none;
            color: var(--text);
            font-weight: 700;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .sidebar-menu-wrapper {
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
            padding: 12px 16px;
            flex: 1;
        }

        .sidebar .sidebar-menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .sidebar .sidebar-menu li {
            margin-bottom: 6px;
        }

        .sidebar .sidebar-menu a {
            display: block;
            padding: 10px 12px;
            border-radius: 8px;
            color: var(--text);
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .sidebar .sidebar-menu a:hover {
            background: rgba(199, 183, 255, 0.1);
        }

        .sidebar .sidebar-menu a.active {
            background: linear-gradient(90deg, var(--pastel-accent), var(--pastel-accent-2));
            color: #fff;
            box-shadow: 0 4px 12px rgba(199, 183, 255, 0.18);
        }

        .sidebar-bottom {
            padding-top: 12px;
            border-top: 1px solid rgba(34, 34, 59, 0.08);
            flex: 0 0 auto;
        }

        .logout-btn {
            width: 100%;
            padding: 10px 12px;
            border: none;
            border-radius: 8px;
            background: rgba(199, 183, 255, 0.1);
            color: var(--text);
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .logout-btn:hover {
            background: rgba(199, 183, 255, 0.2);
        }

        /* Main content area scrolls independently */
        .main-content {
            flex: 1 1 auto;
            overflow-y: auto;
            padding: 28px;
        }

        .card {
            background: var(--pastel-card);
            border-radius: 14px;
            padding: 18px;
            box-shadow: 0 8px 20px rgba(34, 34, 59, 0.04);
        }

        /* Responsive tweaks */
        @media (max-width: 900px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                flex: 0 0 auto;
            }

            .sidebar .sidebar-menu-wrapper {
                max-height: 220px;
            }
        }
    </style>
</head>

<body>
    <div id="app" class="dashboard-container">
        <aside class="sidebar" role="navigation" aria-label="Sidebar">
            <div class="sidebar-header">
                <img src="{{ asset('images/logo.png') }}" alt="Toko Bunga Logo" class="sidebar-logo">
                <a href="{{ route('dashboard') }}" class="brand">Toko Bunga</a>
            </div>
            <div class="sidebar-menu-wrapper">
                @include('dashboard.sidebar')
            </div>
            <div class="sidebar-bottom">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button class="logout-btn">Logout</button>
                </form>
            </div>
        </aside>

        <section class="main-content" role="main">
            @yield('content')
        </section>
    </div>
</body>

</html>
