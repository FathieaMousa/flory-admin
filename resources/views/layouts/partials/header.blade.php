<div class="header py-4 bg-white shadow-sm">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>

        <div>
            <a href="{{ url('/clear-cache') }}" class="btn btn-sm btn-light">🧹 Clear Cache</a>
        </div>
    </div>
</div>
