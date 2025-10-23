<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthApiController,
    ProductApiController,
    CategoryApiController,
    OrderApiController,
    CustomerApiController,
    CouponApiController,
    NotificationApiController
};

/*
|--------------------------------------------------------------------------
| 🚀 Flory API Routes (for Flutter App)
|--------------------------------------------------------------------------
| كل هذه المسارات يتم استدعاؤها من تطبيق الموبايل.
| - الحماية عبر Laravel Sanctum
| - الردود كلها بصيغة JSON
|---------------------------------------------------------------------------
*/

/* 🪪 مصادقة العملاء (Register / Login / Profile / Logout) */
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthApiController::class, 'register']);
    Route::post('/login', [AuthApiController::class, 'login']);

    // المسارات المحمية بالـ Token
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/profile', [AuthApiController::class, 'profile']);
        Route::post('/logout', [AuthApiController::class, 'logout']);
        Route::post('/update-profile', [AuthApiController::class, 'updateProfile']);

    });
});
/* العنواين */

use App\Http\Controllers\Api\AddressApiController;

Route::middleware('auth:sanctum')->prefix('addresses')->group(function () {
    Route::get('/', [AddressApiController::class, 'index']);      // عرض الكل
    Route::post('/', [AddressApiController::class, 'store']);     // إضافة جديد
    Route::put('/{id}', [AddressApiController::class, 'update']); // تعديل
    Route::delete('/{id}', [AddressApiController::class, 'destroy']); // حذف
});

/* 🛍️ المنتجات */
Route::get('/products', [ProductApiController::class, 'index']);
Route::get('/products/{id}', [ProductApiController::class, 'show']);

/* 🏷️ التصنيفات */
Route::get('/categories', [CategoryApiController::class, 'index']);
Route::get('/categories/{id}', [CategoryApiController::class, 'show']);


/* 📦 الطلبات (تتطلب تسجيل دخول) */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/orders', [OrderApiController::class, 'index']);
    Route::post('/orders', [OrderApiController::class, 'store']);
});

/* 🎟️ الكوبونات */
Route::get('/coupons', [CouponApiController::class, 'index']);
Route::get('/coupons/{code}', [CouponApiController::class, 'validateCoupon']);

/* 🔔 الإشعارات (للمستخدم المسجل فقط) */
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/notifications', [NotificationApiController::class, 'index']);
    Route::post('/notifications/send', [NotificationApiController::class, 'send']);
});

use App\Http\Controllers\Api\BannerApiController;

Route::get('/banners', [BannerApiController::class, 'index']);


/* 🧾 بيانات المستخدم الحالية (اختياري - للمطورين) */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json([
        'status' => true,
        'user' => $request->user()
    ]);
});
