<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

/**
 * 🎯 مسؤول عن جلب المنتجات للتطبيق
 */
class ProductApiController extends Controller
{
    // ✅ عرض جميع المنتجات
    public function index()
    {
        return response()->json(
            Product::with('category')->latest()->get()
        );
    }

    // ✅ عرض تفاصيل منتج محدد
    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) return response()->json(['message' => 'Not found'], 404);
        return response()->json($product);
    }
}
