<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * عرض صفحة تعديل بروفايل الأدمن
     */
    public function edit()
    {
        return view('admin.profile.edit');
    }

    /**
     * تحديث بيانات الأدمن
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        // حفظ الاسم في الجلسة
        session(['admin_name' => $request->name]);

        // رفع الصورة إن وُجدت
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            session(['admin_avatar' => $path]);
        }

        // حفظ كلمة المرور الجديدة مؤقتًا (اختياري)
        if ($request->filled('password')) {
            session(['admin_password_changed' => true]);
        }

        return back()->with('success', 'Profile updated successfully 🌸');
    }

    /**
     * منع حذف الأدمن
     */
    public function destroy()
    {
        abort(403, 'Admin cannot be deleted.');
    }
}
