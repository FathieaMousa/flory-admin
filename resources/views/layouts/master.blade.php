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
   توحيد ألوان السايدبار بالكامل
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
    background-color: #819067 !important; /* اللون الأساسي */
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

/* 🔹 نصوص وأيقونات السايدبار */
.aside *,
.sidebar * {
    color: #fff !important;
}

/* أضيفيه داخل style للـ aside أو ملف CSS */
aside {
    scrollbar-width: none;        /* ✅ يعمل على Firefox */
}

aside::-webkit-scrollbar {
    display: none;               /* ✅ يعمل على Chrome, Edge, Safari */
}

/* 🔹 الروابط داخل السايدبار */
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

/* Hover */
.aside .nav-link:hover,
.sidebar .nav-link:hover {
    background-color: #A3B58D !important; /* درجة أفتح */
    color: #fff !important;
    transform: translateX(3px);
}

/* Active / Selected */
.aside .nav-link.active,
.sidebar .nav-link.active {
    background-color: #6E8259 !important; /* درجة أغمق */
    color: #fff !important;
    font-weight: 600;
}

/* أيقونات الروابط */
.aside .nav-link i,
.sidebar .nav-link i {
    margin-right: 10px;
    font-size: 1.1rem;
}

/* 🔹 صورة الأدمن والشعار */
.aside-logo img,
.sidebar img {
    border: 2px solid #fff;
    border-radius: 50%;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
}

/* 🔹 اسم الأدمن */
.aside-logo span,
.sidebar span {
    font-weight: 600;
}

/* 🔹 المحتوى الرئيسي */
.content {
    margin-left: 250px;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

/* 🔹 الهيدر */
.header {
    background: #fff;
    padding: 20px 25px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    position: sticky;
    top: 0;
    z-index: 10;
}

/* 🔹 منطقة المحتوى */
.main-content {
    padding: 30px;
}

/* 🔹 الفوتر */
.footer {
    background: #fff;
    text-align: center;
    padding: 15px;
    border-top: 1px solid #eee;
    color: #666;
    font-size: 0.9rem;
}

/* 🔹 زر إضافة منتج */
.btn-primary, .btn.btn-primary {
    background-color: #819067;
    border-color: #819067;
    color: #fff;
    transition: all 0.3s ease;
}
.btn-primary:hover {
    background-color: #6E8259;
    border-color: #6E8259;
}

/* 🔹 أزرار أخرى */
.btn-warning {
    background-color: #F1C40F;
    border: none;
}
.btn-danger {
    background-color: #E74C3C;
    border: none;
}

/* 🔹 تحسين لمظهر التمرير (scrollbar) */
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

    @stack('scripts')
</body>
</html>
