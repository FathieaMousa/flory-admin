<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    /**
     * ✅ Display all orders for the current logged-in user
     */
    public function index(Request $request)
    {
        $orders = Order::where('customer_id', $request->user()->id)
            ->with(['items.product', 'address'])
            ->latest()
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Orders retrieved successfully ✅',
            'orders'  => $orders
        ]);
    }

    /**
     * ✅ Create a new order linked to user's address
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'total'      => 'required|numeric|min:0',
            'items'      => 'required|array',
            'address_id' => 'nullable|integer',
        ]);

        // ✅ إذا المستخدم ما أرسل عنوان → استخدم الافتراضي
        if (empty($data['address_id'])) {
            $defaultAddress = $request->user()->addresses()->where('selected', true)->first();

            if (!$defaultAddress) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Please add or select a default address first ❗'
                ], 400);
            }

            $data['address_id'] = $defaultAddress->id;
        }

        // ✅ تحقق من أن العنوان يخص المستخدم
        $address = $request->user()->addresses()->find($data['address_id']);
        if (!$address) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid address ❌'
            ], 403);
        }

        // ✨ اجعل العنوان المختار هو الافتراضي فقط إذا لم يكن كذلك
        if (!$address->selected) {
            Address::where('customer_id', $request->user()->id)->update(['selected' => false]);
            $address->update(['selected' => true]);
        }

        // ✅ إنشاء رقم الطلب
        $orderNumber = 'ORD-' . strtoupper(uniqid());

        // ✅ إنشاء الطلب
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_id'  => $request->user()->id,
            'address_id'   => $data['address_id'],
            'status'       => 'pending',
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
            'message' => 'Order created successfully ✅',
            'order'   => $order->load(['items.product', 'address'])
        ], 201);
    }

    /**
     * ✏️ Update order status or total
     */
    public function update(Request $request, $id)
    {
        $order = Order::where('customer_id', $request->user()->id)->findOrFail($id);

        $data = $request->validate([
            'status' => 'nullable|string|in:pending,processing,shipped,delivered,cancelled',
            'total'  => 'nullable|numeric|min:0'
        ]);

        $order->update($data);

        return response()->json([
            'status'  => true,
            'message' => 'Order updated successfully ✏️',
            'order'   => $order
        ]);
    }

    /**
     * 🗑️ Delete order
     */
    public function destroy(Request $request, $id)
    {
        $order = Order::where('customer_id', $request->user()->id)->findOrFail($id);

        $order->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Order deleted successfully 🗑️'
        ]);
    }
}
