<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthApiController extends Controller
{
public function register(Request $request)
{
    $data = $request->validate([
        'name'     => 'required|string|max:255',
        'email'    => 'required|email|unique:customers,email',
        'password' => 'required|min:6',
        'phone'    => 'nullable|string|max:20',
    ]);

    $customer = Customer::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
        'phone'    => $data['phone'] ?? null,
    ]);

    $token = $customer->createToken('flory_token')->plainTextToken;

    return response()->json([
        'status'  => true,
        'message' => 'Account created successfully',
        'user'    => $customer,
        'token'   => $token,
    ], 201);
}

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $customer = Customer::where('email', $data['email'])->first();

        if (! $customer || ! Hash::check($data['password'], $customer->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid email or password'],
            ]);
        }

        $token = $customer->createToken('flory_token')->plainTextToken;

        return response()->json([
            'status'  => true,
            'message' => 'Logged in successfully',
            'user'    => $customer,
            'token'   => $token,
        ]);
    }

    public function profile(Request $request)
    {
        return response()->json([
            'status'  => true,
            'message' => 'Current user data',
            'user'    => $request->user(),
        ]);
    }


    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Logged out successfully',
        ]);
    }


public function updateProfile(Request $request)
{
    $data = $request->validate([
        'name'     => 'sometimes|string|max:255',
        'email'    => 'sometimes|email|unique:customers,email,' . $request->user()->id,
        'password' => 'nullable|min:6',
        'phone'    => 'nullable|string|max:20',
        'image'    => 'nullable|image|max:2048',
    ]);

    $customer = $request->user();

     if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public/customers');
        $data['image_url'] = asset(str_replace('public/', 'storage/', $path));
    }

    if (!empty($data['password'])) {
        $data['password'] = Hash::make($data['password']);
    } else {
        unset($data['password']);
    }

    $customer->update($data);

    return response()->json([
        'status'  => true,
        'message' => 'Profile updated successfully',
        'user'    => $customer,
    ]);
}


}
