<?php

namespace App\Http\Requests\Api;

class OrderRequest extends BaseApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'address_id' => 'required|integer|exists:addresses,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1|max:100',
            'items.*.price' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,card,paypal',
            'coupon_code' => 'nullable|string|exists:coupons,code',
            'notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'address_id' => 'delivery address',
            'items' => 'order items',
            'items.*.product_id' => 'product ID',
            'items.*.quantity' => 'quantity',
            'items.*.price' => 'price',
            'payment_method' => 'payment method',
            'coupon_code' => 'coupon code',
            'notes' => 'order notes',
        ];
    }
}
