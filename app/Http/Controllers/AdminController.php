<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    /**
     * عرض جميع المدراء
     */
    public function index()
    {
        $admins = Admin::latest()->paginate(10);
        return view('admin.admins.index', compact('admins'));
    }

    /**
     * عرض صفحة إنشاء مدير جديد
     */
    public function create()
    {
        return view('admin.admins.create');
    }

    // حفظ بيانات الادمن

 public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $admin = Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        // ✅ تسجيل الأدمن مباشرة
        Auth::guard('web')->login($admin);

        // ✅ توجيهه للداشبورد
        return redirect()->route('dashboard')->with('success', 'Welcome, Admin!');
    }

    /**
     * صفحة تعديل بيانات المدير
     */
    public function edit($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * تحديث بيانات المدير
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        } else {
            unset($data['password']);
        }

        $admin->update($data);
        return redirect()->route('admins.index')->with('success', 'Admin updated successfully ✏️');
    }

    /**
     * حذف مدير
     */
    public function destroy($id)
    {
        Admin::findOrFail($id)->delete();
        return back()->with('success', 'Admin deleted 🗑️');
    }
}
