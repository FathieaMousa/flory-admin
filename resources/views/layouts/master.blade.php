<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Flory Admin')</title>

    {{-- 🔹 Metronic CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color:#FAF7F3 ;
            margin: 0;
            padding: 0;
            display: flex; /* 👈 sidebar + content بجانب بعض */
        }

        .sidebar {
            width: 250px;
            background-color: #819067;
            color: white;
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
        }

        .content {
            margin-left: 250px; /* 👈 تباعد عن sidebar */
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background: white;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .main-content {
            padding: 30px;
        }

        .footer {
            background: white;
            text-align: center;
            padding: 15px;
            border-top: 1px solid #eee;
        }

        .nav-link {
            color: #b8c1ec;
            display: flex;
            align-items: center;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 8px;
        }

        .nav-link:hover, .nav-link.active {
            background: #1b2340;
            color: white;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        @include('layouts.partials.sidebar')
    </div>

    {{-- Content --}}
    <div class="content">
        {{-- Header --}}
        <div class="header">
            @include('layouts.partials.header')
        </div>

        {{-- Main --}}
        <main class="main-content">
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="footer">
            @include('layouts.partials.footer')
        </footer>
    </div>

    {{-- Scripts --}}
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>

    @stack('scripts')
</body>
</html>
