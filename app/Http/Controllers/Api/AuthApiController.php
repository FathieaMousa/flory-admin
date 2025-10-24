<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Api\ProfileUpdateRequest;
use App\Helpers\ApiResponse;

/**
 * 🎯 AuthApiController
 * This class handles customer authentication and registration via API.
 * 
 * @group Authentication
 * 
 * APIs for user authentication, registration, and profile management.
 * All protected endpoints require Firebase authentication token.
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
        'phone'    => 'nullable|string|max:20',
        'firebase_uid' => 'required|string|unique:customers,firebase_uid',
    ]);

    // 🧠 Create new customer with Firebase UID
    $customer = Customer::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'password' => Hash::make($data['password']),
        'phone'    => $data['phone'] ?? null,
        'firebase_uid' => $data['firebase_uid'],
    ]);

    // 📤 Return JSON response
    return ApiResponse::created('Account created successfully', $customer);
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
                'email' => ['Invalid email or password'],
            ]);
        }

        // ✅ Return the user data
        return ApiResponse::success('Logged in successfully', $customer);
    }

    /**
     * Get Current User Profile
     * 
     * Retrieve the profile information of the currently authenticated user.
     * This endpoint automatically creates a customer record if it doesn't exist
     * based on the Firebase user data.
     * 
     * @authenticated
     * 
     * @response 200 {
     *   "status": true,
     *   "message": "Current user data ✅",
     *   "user": {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "john@example.com",
     *     "firebase_uid": "firebase-uid-123",
     *     "phone": "+1234567890",
     *     "email_verified_at": "2025-01-16T10:00:00.000000Z",
     *     "created_at": "2025-01-16T10:00:00.000000Z",
     *     "updated_at": "2025-01-16T10:00:00.000000Z"
     *   }
     * }
     * 
     * @response 401 {
     *   "status": false,
     *   "message": "Invalid or expired token"
     * }
     */
    public function profile(Request $request)
    {
        $firebaseUid = $request->get('firebase_uid');
        $firebaseUser = $request->get('firebase_user');
        
        // Find or create customer based on Firebase UID
        $customer = Customer::where('firebase_uid', $firebaseUid)->first();
        
        if (!$customer) {
            // Create customer if doesn't exist
            $customer = Customer::create([
                'name' => $firebaseUser->claims()->get('name', ''),
                'email' => $firebaseUser->claims()->get('email', ''),
                'firebase_uid' => $firebaseUid,
                'email_verified_at' => $firebaseUser->claims()->get('email_verified') ? now() : null,
            ]);
        }
        
        return response()->json([
            'status'  => true,
            'message' => 'Current user data ✅',
            'user'    => $customer,
        ]);
    }

    /**
     * 🚪 Logout
     * Firebase handles logout on client side
     */
    public function logout(Request $request)
    {
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
public function updateProfile(ProfileUpdateRequest $request)
{
    $data = $request->validated();

    $firebaseUid = $request->get('firebase_uid');
    $customer = Customer::where('firebase_uid', $firebaseUid)->firstOrFail();

    // 📸 Handle image upload (optional)
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('public/customers');
        $data['image_url'] = asset(str_replace('public/', 'storage/', $path));
    }

    // Remove password field as Firebase handles authentication

    // 🧠 Update user data (including phone now)
    $customer->update($data);

    return ApiResponse::success('Profile updated successfully', $customer);
}


}
