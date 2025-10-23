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
    /* ================================
       🌿 FLORY DASHBOARD STYLE
       ================================ */

    body {
        font-family: 'Inter', sans-serif;
        background-color: #FAF7F3;
        margin: 0;
        padding: 0;
        display: flex;
    }

    /* 🔹 Sidebar */
    .sidebar,
    .aside,
    .aside-dark,
    .bg-dark {
        background-color: #819067 !important;
        color: #fff !important;
        min-height: 100vh;
        width: 250px;
        position: fixed;
        left: 0;
        top: 0;
        bottom: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 2px 0 6px rgba(0, 0, 0, 0.05);
    }

    .aside *, .sidebar * {
        color: #fff !important;
    }

    aside {
        scrollbar-width: none;
    }

    aside::-webkit-scrollbar {
        display: none;
    }

    /* 🔹 روابط السايدبار */
    .aside .nav-link,
    .sidebar .nav-link {
        color: #fff !important;
        display: flex;
        align-items: center;
        padding: 12px 18px;
        border-radius: 8px;
        margin: 4px 8px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .aside .nav-link:hover,
    .sidebar .nav-link:hover {
        background-color: #A3B58D !important;
        transform: translateX(3px);
    }

    .aside .nav-link.active,
    .sidebar .nav-link.active {
        background-color: #6E8259 !important;
        font-weight: 600;
    }

    .aside .nav-link i,
    .sidebar .nav-link i {
        margin-right: 10px;
        font-size: 1.1rem;
    }

    /* 🔹 المحتوى */
    .content {
        margin-left: 250px;
        flex: 1;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .header {
        background: #fff;
        padding: 20px 25px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .main-content {
        padding: 30px;
    }

    .footer {
        background: #fff;
        text-align: center;
        padding: 15px;
        border-top: 1px solid #eee;
        color: #666;
        font-size: 0.9rem;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-thumb {
        background: #A3B58D;
        border-radius: 4px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #819067;
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

    {{-- ✅ إصلاح ألوان الأزرار بعد تحميل Metronic --}}
    <style>
    body {
      --bs-primary: #819067 !important;
      --bs-primary-rgb: 129,144,103 !important;
      --bs-btn-bg: #819067 !important;
      --bs-btn-border-color: #819067 !important;
      --bs-btn-hover-bg: #9BAE7D !important;
      --bs-btn-hover-border-color: #9BAE7D !important;
      --bs-btn-active-bg: #6E8259 !important;
      --bs-btn-active-border-color: #6E8259 !important;
      --bs-btn-focus-shadow-rgb: 129,144,103 !important;
    }

    /* ✅ Primary */
    .btn-primary,
    .btn.btn-primary {
        background-color: #819067 !important;
        border-color: #819067 !important;
        color: #fff !important;
        transition: all 0.3s ease;
        box-shadow: none !important;
    }

    .btn-primary:hover {
        background-color: #9BAE7D !important;
        border-color: #9BAE7D !important;
        transform: translateY(-2px);
    }

    .btn-primary:active,
    .btn-primary:focus {
        background-color: #6E8259 !important;
        border-color: #6E8259 !important;
        box-shadow: none !important;
        outline: none !important;
    }

    /* ✅ Success */
    .btn-success {
        background-color: #7CB342 !important;
        border-color: #7CB342 !important;
        color: #fff !important;
    }
    .btn-success:hover {
        background-color: #9CCC65 !important;
        border-color: #9CCC65 !important;
    }
    .btn-success:active {
        background-color: #689F38 !important;
    }

    /* ✅ Warning */
    .btn-warning {
        background-color: #F1C40F !important;
        border-color: #F1C40F !important;
        color: #fff !important;
    }
    .btn-warning:hover {
        background-color: #F5D657 !important;
        border-color: #F5D657 !important;
    }
    .btn-warning:active {
        background-color: #D4AC0D !important;
    }

    /* ✅ Danger */
    .btn-danger {
        background-color: #E74C3C !important;
        border-color: #E74C3C !important;
        color: #fff !important;
    }
    .btn-danger:hover {
        background-color: #FF6B5A !important;
        border-color: #FF6B5A !important;
    }
    .btn-danger:active {
        background-color: #C0392B !important;
    }

    /* ✅ إزالة أي تأثير أزرق من Bootstrap/Metronic */
    .btn:focus,
    .btn:active,
    .btn:focus-visible {
        outline: none !important;
        box-shadow: none !important;
    }
    </style>

    @stack('scripts')
</body>
</html>
