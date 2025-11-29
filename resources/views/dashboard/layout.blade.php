<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>

<body class="dashboard-body">

    @include('dashboard.sidebar')

    <main class="main-content">
        @yield('content')
    </main>

</body>
</html>
