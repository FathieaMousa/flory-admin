<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    /**
     * عرض صفحة تسجيل الدخول
     */
    public function showLoginForm()
    {
        return view('auth.admin-login');
    }

    /**
     * تنفيذ عملية تسجيل الدخول للأدمن الوحيد
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // جلب بيانات الأدمن من .env
        $adminEmail = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');

        if (
            $request->email === $adminEmail &&
            $request->password === $adminPassword
        ) {
            // حفظ جلسة الأدمن
            session(['admin_logged_in' => true]);
            return redirect()->route('dashboard')->with('success', 'Welcome back, Admin!');
        }

        return back()->withErrors(['email' => 'Invalid admin credentials.']);
    }

    /**
     * تنفيذ عملية تسجيل الخروج
     */
    public function logout(Request $request)
    {
        session()->forget('admin_logged_in');
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Logged out successfully.');
    }
}
