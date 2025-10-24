<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;

/**
 * 🎯 Responsible for handling Orders (Orders)
 * - Display user orders
 * - Create new orders linked to saved addresses
 */
class OrderApiController extends Controller
{
    /**
     * ✅ Display all orders for the current logged-in user
     */
    public function index(Request $request)
    {
        $firebaseUid = $request->get('firebase_uid');
        $customer = \App\Models\Customer::where('firebase_uid', $firebaseUid)->first();
        
        if (!$customer) {
            return response()->json([
                'status' => false,
                'message' => 'Customer not found'
            ], 404);
        }

        $orders = Order::where('customer_id', $customer->id)
            ->with(['items.product', 'address'])
            ->latest()
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Orders retrieved successfully',
            'data'    => $orders
        ]);
    }

    /**
     * ✅ Create a new order linked to user's address
     */
public function store(Request $request)
{
    $firebaseUid = $request->get('firebase_uid');
    $customer = \App\Models\Customer::where('firebase_uid', $firebaseUid)->first();
    
    if (!$customer) {
        return response()->json([
            'status' => false,
            'message' => 'Customer not found'
        ], 404);
    }

    $data = $request->validate([
        'total'      => 'required|numeric|min:0',
        'items'      => 'required|array',
        'address_id' => 'nullable|integer',
    ]);

    // ✅ إذا المستخدم ما أرسل عنوان → استخدم الافتراضي
    if (empty($data['address_id'])) {
        $defaultAddress = $customer->addresses()->where('selected', true)->first();

        if (!$defaultAddress) {
            return response()->json([
                'status'  => false,
                'message' => 'Please add or select a default address first'
            ], 400);
        }

        $data['address_id'] = $defaultAddress->id;
    }

    // ✅ تحقق من أن العنوان يخص المستخدم
    $address = $customer->addresses()->find($data['address_id']);
    if (!$address) {
        return response()->json([
            'status'  => false,
            'message' => 'Invalid address'
        ], 403);
    }

    // ✨ اجعل العنوان المختار هو الافتراضي
    Address::where('customer_id', $customer->id)->update(['selected' => false]);
    $address->update(['selected' => true]);

    // ✅ إنشاء رقم الطلب
    $orderNumber = 'ORD-' . strtoupper(uniqid());

    // ✅ إنشاء الطلب
    $order = Order::create([
        'order_number' => $orderNumber,
        'customer_id'  => $customer->id,
        'address_id'   => $data['address_id'],
        'status'       => 'Pending',
        'total'        => $data['total'],
    ]);

    // ✅ إضافة المنتجات
    foreach ($data['items'] as $item) {
        $order->items()->create([
            'product_id' => $item['product_id'],
            'qty'        => $item['quantity'],
            'price'      => $item['price'],
        ]);
    }

    return response()->json([
        'status'  => true,
        'message' => 'Order created successfully',
        'data'    => $order->load(['items.product', 'address'])
    ], 201);
}


}
