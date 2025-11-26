<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }} - Login</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        @include('auth._login-modal')
        <script>
            // If the page was visited directly (non-JS fallback), show modal
            document.addEventListener('DOMContentLoaded', function(){ if(window.location.search.indexOf('show_modal') !== -1){ if(window.openAuthModal) window.openAuthModal(); } });
        </script>
    </body>
</html>