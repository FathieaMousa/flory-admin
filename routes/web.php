<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\{
    DashboardController,
    BannerController,
    CategoryController,
    CouponController,
    CustomerController,
    NotificationController,
    OrderController,
    ProductController,
    SettingController,
    ProfileController
};
use App\Http\Controllers\Auth\AdminLoginController;

/*
|--------------------------------------------------------------------------
| Flory Dashboard Routes (Admin Only)
|--------------------------------------------------------------------------
*/

// ✅ تسجيل الدخول والخروج للأدمن
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// ✅ المسارات المحمية - فقط الأدمن يمكنه الوصول إليها
Route::middleware(['admin'])->group(function () {

    // إعادة توجيه الصفحة الرئيسية إلى الداشبورد
    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // لوحة التحكم
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // المنتجات
    Route::resource('products', ProductController::class)->except(['show']);

    // التصنيفات
    Route::resource('categories', CategoryController::class)->except(['show']);

    // الطلبات
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/store', [OrderController::class, 'store'])->name('orders.store');
        Route::post('/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    });

    // العملاء
    Route::resource('customers', CustomerController::class)->only(['index', 'show', 'destroy']);

    // الكوبونات
    Route::resource('coupons', CouponController::class)->except(['show']);

    // الإشعارات
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/send', [NotificationController::class, 'send'])->name('notifications.send');
        Route::get('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    // الإعدادات
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');

    // 👤 بروفايل الأدمن
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // 🧹 صيانة النظام
    Route::get('/clear-cache', function () {
        Artisan::call('optimize:clear');
        Artisan::call('storage:link');
        return '✅ Cache cleared successfully!';
    })->name('clear.cache');
});
