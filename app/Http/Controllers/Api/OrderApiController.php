<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;

class OrderApiController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('customer_id', $request->user()->id)
            ->with(['items.product', 'address'])
            ->latest()
            ->get();

        return response()->json([
            'status'  => true,
            'message' => 'Orders retrieved successfully',
            'orders'  => $orders
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'total'      => 'required|numeric|min:0',
            'items'      => 'required|array',
            'address_id' => 'nullable|integer',
        ]);

        if (empty($data['address_id'])) {
            $defaultAddress = $request->user()->addresses()->where('selected', true)->first();

            if (!$defaultAddress) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Please add or select a default address first'
                ], 400);
            }

            $data['address_id'] = $defaultAddress->id;
        }

        $address = $request->user()->addresses()->find($data['address_id']);
        if (!$address) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid address'
            ], 403);
        }

        if (!$address->selected) {
            Address::where('customer_id', $request->user()->id)->update(['selected' => false]);
            $address->update(['selected' => true]);
        }

        $orderNumber = 'ORD-' . strtoupper(uniqid());

        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_id'  => $request->user()->id,
            'address_id'   => $data['address_id'],
            'status'       => 'pending',
            'total'        => $data['total'],
        ]);

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
            'order'   => $order->load(['items.product', 'address'])
        ], 201);
    }

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
            'message' => 'Order updated successfully',
            'order'   => $order
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $order = Order::where('customer_id', $request->user()->id)->findOrFail($id);

        $order->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Order deleted successfully'
        ]);
    }
}
