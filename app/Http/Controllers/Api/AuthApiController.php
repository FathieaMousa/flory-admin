<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * 🎯 AuthApiController
 * هذا الكلاس مسؤول عن تسجيل العملاء وتسجيل الدخول عبر الـ API
 * - register(): إنشاء حساب جديد
 * - login(): تسجيل الدخول وإرجاع Token
 * - profile(): جلب بيانات المستخدم المسجل حالياً
 */
class AuthApiController extends Controller
{
    /**
     * 🧩 إنشاء حساب جديد (Register)
     */
    public function register(Request $request)
    {
        // ✅ التحقق من البيانات المُدخلة
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:customers,email',
            'password' => 'required|min:6',
        ]);

        // 🧠 إنشاء حساب جديد في جدول customers مع تشفير كلمة المرور
        $customer = Customer::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // 🔐 إنشاء توكن (token) جديد باستخدام Sanctum
        $token = $customer->createToken('flory_token')->plainTextToken;

        // 📤 نرجع استجابة JSON تحتوي على بيانات المستخدم والتوكن
        return response()->json([
            'status'  => true,
            'message' => 'تم إنشاء الحساب بنجاح ✅',
            'user'    => $customer,
            'token'   => $token,
        ], 201);
    }

    /**
     * 🔑 تسجيل الدخول (Login)
     */
    public function login(Request $request)
    {
        // ✅ التحقق من صحة البيانات
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 🔍 البحث عن المستخدم
        $customer = Customer::where('email', $data['email'])->first();

        // ❌ في حال الإيميل أو الباسورد خطأ
        if (! $customer || ! Hash::check($data['password'], $customer->password)) {
            throw ValidationException::withMessages([
                'email' => ['البريد الإلكتروني أو كلمة المرور غير صحيحة. ❌'],
            ]);
        }

        // 🔄 إنشاء توكن جديد بعد تسجيل الدخول
        $token = $customer->createToken('flory_token')->plainTextToken;

        // ✅ إرجاع البيانات والتوكن
        return response()->json([
            'status'  => true,
            'message' => 'تم تسجيل الدخول بنجاح ✅',
            'user'    => $customer,
            'token'   => $token,
        ]);
    }

    /**
     * 👤 عرض ملف المستخدم الحالي (Profile)
     * يتطلب Authorization: Bearer {token}
     */
    public function profile(Request $request)
    {
        return response()->json([
            'status'  => true,
            'message' => 'بيانات المستخدم الحالي ✅',
            'user'    => $request->user(),
        ]);
    }

    /**
     * 🚪 تسجيل الخروج (Logout)
     * حذف جميع التوكنات الخاصة بالمستخدم
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'تم تسجيل الخروج بنجاح 🚪',
        ]);
    }
}
