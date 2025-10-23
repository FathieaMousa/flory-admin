<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * 🎯 AuthApiController
 * This class handles customer authentication and registration via API.
 * - register(): Create a new account.
 * - login(): Login and return a token.
 * - profile(): Get the currently logged-in user data.
 */
class AuthApiController extends Controller
{
    /**
     * 🧩 Register a new customer account
     */
 /**
 * 🧩 Register a new customer account
 */
public function register(Request $request)
{
    // ✅ Validate input
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:customers,email',
        'password' => 'required|min:6',
        'phone'    => 'nullable|string|max:20', // 🆕 أضفنا الهاتف
    ]);

    // 🧠 Create new customer with hashed password
    $customer = Customer::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
        'phone'    => $data['phone'] ?? null, // 🆕 أضفنا هذا السطر
    ]);

    // 🔐 Create Sanctum token
    $token = $customer->createToken('flory_token')->plainTextToken;

    // 📤 Return JSON response
    return response()->json([
        'status'  => true,
        'message' => 'Account created successfully ✅',
        'user'    => $customer,
        'token'   => $token,
    ], 201);
}

    /**
     * 🔑 Login (Authentication)
     */
    public function login(Request $request)
    {
        // ✅ Validate the input data
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // 🔍 Search for the customer
        $customer = Customer::where('email', $data['email'])->first();

        // ❌ If email or password is incorrect
        if (! $customer || ! Hash::check($data['password'], $customer->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password ❌'],
            ]);
        }

        // 🔄 Generate a new token after successful login
        $token = $customer->createToken('flory_token')->plainTextToken;

        // ✅ Return the user and token
        return response()->json([
            'status'  => true,
            'message' => 'Logged in successfully ✅',
            'user'    => $customer,
            'token'   => $token,
        ]);
    }

    /**
     * 👤 Get current user profile
     * Requires Authorization: Bearer {token}
     */
    public function profile(Request $request)
    {
        return response()->json([
            'status'  => true,
            'message' => 'Current user data ✅',
            'user'    => $request->user(),
        ]);
    }

    /**
     * 🚪 Logout
     * Delete all user tokens
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Logged out successfully 🚪',
        ]);
    }


        /**
     * ✏️ Update current user profile
     * Requires Authorization: Bearer {token}
     */
  /**
 * ✏️ Update current user profile
 * Requires Authorization: Bearer {token}
 */
public function updateProfile(Request $request)
{
    // 🧩 Validate the request data
    $data = $request->validate([
        'name'     => 'sometimes|string|max:255',
        'email'    => 'sometimes|email|unique:customers,email,' . $request->user()->id,
        'password' => 'nullable|min:6',
        'phone'    => 'nullable|string|max:20', // 🆕 أضفنا رقم الجوال هنا
        'image'    => 'nullable|image|max:2048', // Optional profile image
    ]);

    $customer = $request->user();

    // 📸 Handle image upload (optional)
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public/customers');
        $data['image_url'] = asset(str_replace('public/', 'storage/', $path));
    }

    // 🔒 Hash the password if provided
    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']); // prevent overwriting with null
    }

    // 🧠 Update user data (including phone now)
    $customer->update($data);

    return response()->json([
        'status'  => true,
        'message' => 'Profile updated successfully ✅',
        'user'    => $customer,
    ]);
}


}
