<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;


class CustomerApiController extends Controller
{
    public function index()
    {
        return response()->json(Customer::latest()->get());
    }

    public function show($id)
    {
        $customer = Customer::with('orders')->find($id);
        if (!$customer) return response()->json(['message' => 'Not found'], 404);
        return response()->json($customer);
    }
}
