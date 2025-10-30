<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;


class ProductApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Product::with('category')->latest()->get()
        );
    }

    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) return response()->json(['message' => 'Not found'], 404);
        return response()->json($product);
    }
}
