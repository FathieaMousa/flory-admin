<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function edit()
    {
        return view('admin.profile.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        session(['admin_name' => $request->name]);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            session(['admin_avatar' => $path]);
        }

        if ($request->filled('password')) {
            session(['admin_password_changed' => true]);
        }

        return back()->with('success', 'Profile updated successfully');
    }
    public function destroy()
    {
        abort(403, 'Admin cannot be deleted.');
    }
}
