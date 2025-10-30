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
    ProfileController,
    AddressController
};
use App\Http\Controllers\Auth\AdminLoginController;

/*
| - مخصصة للأدمن فقط
| - أي شخص غير مصرح له سيتم تحويله لصفحة تسجيل الدخول
*/
use Kreait\Firebase\Factory;

Route::get('/test-firebase', function () {
    try {
        $factory = (new Factory)->withServiceAccount(config('firebase.credentials.file'));
        $auth = $factory->createAuth();
        $userCount = iterator_count($auth->listUsers());

        return "✅ Firebase Connected Successfully! Total users: {$userCount}";
    } catch (\Exception $e) {
        return "❌ Connection failed: " . $e->getMessage();
    }
});


// تسجيل الدخول والخروج للأدمن
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin'])->group(function () {
    //الصفحة الرئيسية

    Route::get('/', fn() => redirect()->route('dashboard'));

    // لوحة التحكم
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //المنتجات
    Route::resource('products', ProductController::class)->except(['show']);

    // التصنيفات
    Route::resource('categories', CategoryController::class)->except(['show']);

    // الطلبات
    Route::prefix('orders')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('orders.show');

        //  تعديل حالة الطلب
        Route::post('/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        //  حذف الطلب
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    });

    //  العملاء
    Route::resource('customers', CustomerController::class)->only(['index', 'show', 'destroy']);

    //  إرسال إشعار للعميل
    Route::post('/customers/{id}/notify', [CustomerController::class, 'sendNotification'])->name('customers.notify');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');


    //  الكوبونات
    Route::resource('coupons', CouponController::class)->except(['show']);

    //  الإشعارات
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/send', [NotificationController::class, 'send'])->name('notifications.send');
        Route::get('/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    });

    //  إعدادات الموقع
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/update', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/addresses/{id}/set-default', [AddressController::class, 'setDefault'])->name('addresses.setDefault');


    //  البروفايل
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //  إدارة العناوين (Addresses)
    Route::resource('addresses', AddressController::class)->only(['index', 'show', 'destroy']);
    // إدارة البنرات
    Route::resource('banners', BannerController::class)->except(['show']);


    //  تنظيف الكاش
    Route::get('/clear-cache', function () {
        Artisan::call('optimize:clear');
        Artisan::call('storage:link');
        return '✅ Cache cleared successfully!';
    })->name('clear.cache');
});
