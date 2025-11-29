<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

        html, body, #app { height: 100%; }
        body { font-family: Inter, system-ui, -apple-system, "Segoe UI", Roboto, 'Helvetica Neue', Arial; background: var(--pastel-bg); color: var(--text); margin: 0; }

        .dashboard-container { display: flex; height: 100vh; overflow: hidden; }

        /* Sidebar fixed column */
        .sidebar { width: var(--sidebar-width); background: linear-gradient(180deg, var(--pastel-card), #FFF); border-right: 1px solid rgba(34,34,59,0.04); box-shadow: 0 6px 18px rgba(180,170,200,0.05); display: flex; flex-direction: column; }

        /* Make only the menu scrollable */
        .sidebar .sidebar-header { padding: 20px; flex: 0 0 auto; }
        .sidebar .sidebar-menu-wrapper { overflow-y: auto; -webkit-overflow-scrolling: touch; padding: 12px 16px; }
        .sidebar .sidebar-menu { list-style: none; margin: 0; padding: 0; }
        .sidebar .sidebar-menu li { margin-bottom: 6px; }
        .sidebar .sidebar-menu a { display: block; padding: 10px 12px; border-radius: 8px; color: var(--text); text-decoration: none; }
        .sidebar .sidebar-menu a.active { background: linear-gradient(90deg, var(--pastel-accent), var(--pastel-accent-2)); color: #fff; box-shadow: 0 4px 12px rgba(199,183,255,0.18); }

        /* Main content area scrolls independently */
        .main-content { flex: 1 1 auto; overflow-y: auto; padding: 28px; }
        .card { background: var(--pastel-card); border-radius: 14px; padding: 18px; box-shadow: 0 8px 20px rgba(34,34,59,0.04); }

        /* Responsive tweaks */
        @media (max-width: 900px) {
            .dashboard-container { flex-direction: column; }
            .sidebar { width: 100%; flex: 0 0 auto; }
            .sidebar .sidebar-menu-wrapper { max-height: 220px; }
        }
    </style>
</head>
<body>
    <div id="app" class="dashboard-container">
        <aside class="sidebar" role="navigation" aria-label="Sidebar">
            <div class="sidebar-header">
                <a href="{{ route('dashboard') }}" class="brand">Toko Bunga</a>
            </div>
            <div class="sidebar-menu-wrapper">
                @include('dashboard.sidebar')
            </div>
        </aside>

        <section class="main-content" role="main">
            @yield('content')
        </section>
    </div>
</body>
</html>
            --card-bg: #ffffff;
        }

        html,body{height:100%;}
        body.dashboard-body{margin:0;font-family: Inter, system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:var(--bliss-3); color:var(--text-dark);}

        .dashboard-container{display:flex;min-height:100vh;}

        /* Sidebar */
        .sidebar{width:260px; background:var(--card-bg); padding:20px 18px; box-shadow: 2px 0 10px rgba(0,0,0,0.03); display:flex; flex-direction:column;}
        .sidebar-header{padding:8px 0 18px;border-bottom:1px solid #f1eaea}
        .sidebar-header h2{margin:0;color:var(--bliss-1);font-weight:700}

        .sidebar-menu{margin:0;padding:0;list-style:none;flex:1;overflow:auto}
        .sidebar-menu li{margin:0}
        .sidebar-menu a{display:block;padding:12px 10px;border-radius:8px;color:var(--text-dark);text-decoration:none;font-weight:600;margin:6px 2px}
        .sidebar-menu a.active{background:var(--bliss-2);box-shadow:inset 0 0 0 1px rgba(236,72,153,0.06)}
        .sidebar-bottom{padding-top:12px;border-top:1px solid #f1eaea}

        /* Main content */
        .main-content{flex:1;padding:28px 36px;}

        /* Make menu scroll only - hide body scroll when inside dashboard */
        .main-content{overflow:auto}

        @media(max-width:900px){
            .sidebar{width:100%;position:relative;}
            .dashboard-container{flex-direction:column}
        }
    </style>
</head>

<body class="dashboard-body">

    <div class="dashboard-container">
        @include('dashboard.sidebar')
        <main class="main-content">
            @yield('content')
        </main>
    </div>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>
</html>
