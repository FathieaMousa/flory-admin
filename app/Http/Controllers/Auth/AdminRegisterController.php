<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminRegisterController extends Controller
{
    /**
     * عرض صفحة التسجيل
     */
    public function showRegistrationForm()
    {
        return view('auth.admin-register');
    }

    /**
     * معالجة عملية التسجيل
     */
    public function register(Request $request)
    {
        // ✅ التحقق من صحة البيانات
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // ✅ إنشاء الأدمن في قاعدة البيانات
        $admin = Admin::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin', // تأكيد أنه أدمن
        ]);

        // ✅ تسجيل الدخول مباشرة بعد التسجيل
        Auth::guard('web')->login($admin);

        // ✅ إعادة توجيهه إلى لوحة التحكم
        return redirect()->route('dashboard')->with('success', 'Admin account created successfully!');
    }
}
