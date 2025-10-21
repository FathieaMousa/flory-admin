<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

/**
 * 🎯 مسؤول عن الطلبات (Orders)
 * - عرض طلبات المستخدم
 * - إنشاء طلب جديد
 */
class OrderApiController extends Controller
{
    // ✅ عرض الطلبات الخاصة بالمستخدم الحالي
    public function index(Request $request)
    {
        return response()->json(
            Order::where('customer_id', $request->user()->id)
                ->with('items.product')
                ->latest()
                ->get()
        );
    }

    // ✅ إنشاء طلب جديد
public function store(Request $request)
{
    $data = $request->validate([
        'total' => 'required|numeric|min:0',
        'items' => 'required|array',  // سيكون عندك items مثل المنتج + الكمية + السعر
        'address' => 'nullable|string',
    ]);

    // ✨ 1. إنشاء رقم طلب تلقائي (Unique)
    $orderNumber = 'ORD-' . strtoupper(uniqid());

    // ✨ 2. إنشاء الطلب الأساسي
    $order = Order::create([
        'order_number' => $orderNumber,        // ✅ حل مشكلة قاعدة البيانات
        'customer_id'  => $request->user()->id,
        'status'       => 'pending',
        'total'        => $data['total'],
        'address'      => $data['address'] ?? null,
    ]);

    // ✨ 3. حفظ المنتجات التابعة للطلب (Order Items)
    foreach ($data['items'] as $item) {
        $order->items()->create([
            'product_id' => $item['product_id'],
            'qty'        => $item['quantity'],
            'price'      => $item['price'],
        ]);
    }

    return response()->json([
        'status'  => true,
        'message' => 'Order created successfully ✅',
        'order'   => $order->load('items.product')   // يجيب الطلب مع المنتجات
    ], 201);
}

}
