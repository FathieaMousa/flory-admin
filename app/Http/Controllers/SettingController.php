<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::firstOrCreate(); // ينشئ سجل افتراضي إذا مش موجود
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'app_name' => 'required|string|max:255',
            'email'    => 'nullable|email',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
            'logo'     => 'nullable|image|max:2048',
            'favicon'  => 'nullable|image|max:1024',
        ]);

        $settings = Setting::first();

        // ✅ حفظ الصور إن وُجدت
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('settings', 'public');
        }

        if ($request->hasFile('favicon')) {
            $data['favicon'] = $request->file('favicon')->store('settings', 'public');
        }

        $settings->update($data);

        return back()->with('success', 'Settings updated successfully ✅');
    }
}
