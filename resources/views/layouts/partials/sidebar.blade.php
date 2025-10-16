<div class="aside aside-dark aside-hoverable bg-dark" id="kt_aside">
    <!-- 🔹 الشعار وبيانات الأدمن -->
    <div class="aside-logo flex-column-auto text-center py-4 border-bottom">
        <h4 class="text-white fw-bold mb-2">🌸 Flory Dashboard</h4>

        <div class="d-flex flex-column align-items-center">
            <a href="{{ route('profile.edit') }}" class="text-decoration-none">
                <img
                    src="{{ session('admin_avatar') ? asset('storage/' . session('admin_avatar')) : asset('assets/flory-logo.jpgda') }}"
                    alt="Admin Avatar" width="60" height="60"
                    class="rounded-circle mb-2 shadow border border-light"
                    style="object-fit: cover;">
            </a>
            <span class="text-white fw-semibold">{{ session('admin_name', 'Admin') }}</span>
            <small class="text-muted">Administrator</small>
        </div>
    </div>

    <!-- 🔹 قائمة التنقل -->
    <div class="aside-menu flex-column-fluid mt-3">
        <ul class="nav flex-column px-3">
            <li class="nav-item mb-2">
                <a href="{{ route('dashboard') }}" class="nav-link text-white {{ request()->routeIs('dashboard') ? 'fw-bold active bg-primary rounded' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('products.index') }}" class="nav-link text-white {{ request()->is('products*') ? 'fw-bold active bg-primary rounded' : '' }}">
                    <i class="bi bi-box me-2"></i> Products
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('categories.index') }}" class="nav-link text-white {{ request()->is('categories*') ? 'fw-bold active bg-primary rounded' : '' }}">
                    <i class="bi bi-grid me-2"></i> Categories
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('orders.index') }}" class="nav-link text-white {{ request()->is('orders*') ? 'fw-bold active bg-primary rounded' : '' }}">
                    <i class="bi bi-bag-check me-2"></i> Orders
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('customers.index') }}" class="nav-link text-white {{ request()->is('customers*') ? 'fw-bold active bg-primary rounded' : '' }}">
                    <i class="bi bi-people me-2"></i> Customers
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('coupons.index') }}" class="nav-link text-white {{ request()->is('coupons*') ? 'fw-bold active bg-primary rounded' : '' }}">
                    <i class="bi bi-ticket me-2"></i> Coupons
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('notifications.index') }}" class="nav-link text-white {{ request()->is('notifications*') ? 'fw-bold active bg-primary rounded' : '' }}">
                    <i class="bi bi-bell me-2"></i> Notifications
                </a>
            </li>

            <li class="nav-item mb-2">
                <a href="{{ route('settings.index') }}" class="nav-link text-white {{ request()->is('settings*') ? 'fw-bold active bg-primary rounded' : '' }}">
                    <i class="bi bi-gear me-2"></i> Settings
                </a>
            </li>
        </ul>
    </div>

    <!-- 🔹 زر تسجيل الخروج -->
    <div class="aside-footer p-3 border-top text-center">
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                <i class="bi bi-box-arrow-right me-1"></i> Logout
            </button>
        </form>
    </div>
</div>
