<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;

/**
 * 🎯 مسؤول عن بيانات العملاء
 */
class CustomerApiController extends Controller
{
    // ✅ عرض جميع العملاء (استخدام داخلي فقط)
    public function index()
    {
        return response()->json(Customer::latest()->get());
    }

    // ✅ عرض عميل محدد مع طلباته
    public function show($id)
    {
        $customer = Customer::with('orders')->find($id);
        if (!$customer) return response()->json(['message' => 'Not found'], 404);
        return response()->json($customer);
    }
}
