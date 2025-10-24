<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use App\Helpers\ApiResponse;

/**
 * 🎯 مسؤول عن جلب المنتجات للتطبيق
 * 
 * @group Products
 * 
 * APIs for managing and retrieving product information
 */
class ProductApiController extends Controller
{
    // Cache duration in minutes
    private const CACHE_DURATION = 15;

    /**
     * Get All Products
     * 
     * Retrieve a list of all available products with their categories.
     * Results are cached for 15 minutes to improve performance.
     * 
     * @response 200 {
     *   "status": true,
     *   "message": "Products retrieved successfully",
     *   "data": [
     *     {
     *       "id": 1,
     *       "title": "Beautiful Rose Bouquet",
     *       "price": "25.99",
     *       "new_price": "19.99",
     *       "discount_percent": 23,
     *       "is_available": true,
     *       "is_new": true,
     *       "sell_number": "RS001",
     *       "description": "A beautiful bouquet of red roses",
     *       "image": "https://example.com/images/rose-bouquet.jpg",
     *       "category": {
     *         "id": 1,
     *         "name": "Bouquets"
     *       },
     *       "created_at": "2025-01-16T10:00:00.000000Z",
     *       "updated_at": "2025-01-16T10:00:00.000000Z"
     *     }
     *   ],
     *   "cached": true
     * }
     * 
     * @response 500 {
     *   "status": false,
     *   "message": "Internal server error"
     * }
     */
    public function index()
    {
        $cacheKey = 'products:all';
        
        $products = Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return Product::with('category')
                ->where('is_available', true)
                ->latest()
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'title' => $product->title,
                        'price' => $product->price,
                        'new_price' => $product->new_price,
                        'discount_percent' => $product->discount_percent,
                        'is_available' => $product->is_available,
                        'is_new' => $product->is_new,
                        'sell_number' => $product->sell_number,
                        'description' => $product->description,
                        'image' => $product->image,
                        'category' => $product->category ? [
                            'id' => $product->category->id,
                            'name' => $product->category->name,
                        ] : null,
                        'created_at' => $product->created_at,
                        'updated_at' => $product->updated_at,
                    ];
                });
        });

        return ApiResponse::success('Products retrieved successfully', [
            'products' => $products,
            'cached' => Cache::has($cacheKey)
        ]);
    }

    /**
     * Get Single Product
     * 
     * Retrieve detailed information about a specific product by its ID.
     * Results are cached for 15 minutes to improve performance.
     * 
     * @urlParam id integer required The ID of the product to retrieve.
     * 
     * @response 200 {
     *   "status": true,
     *   "message": "Product retrieved successfully",
     *   "data": {
     *     "id": 1,
     *     "title": "Beautiful Rose Bouquet",
     *     "price": "25.99",
     *     "new_price": "19.99",
     *     "discount_percent": 23,
     *     "is_available": true,
     *     "is_new": true,
     *     "sell_number": "RS001",
     *     "description": "A beautiful bouquet of red roses",
     *     "image": "https://example.com/images/rose-bouquet.jpg",
     *     "category": {
     *       "id": 1,
     *       "name": "Bouquets"
     *     },
     *     "created_at": "2025-01-16T10:00:00.000000Z",
     *     "updated_at": "2025-01-16T10:00:00.000000Z"
     *   },
     *   "cached": true
     * }
     * 
     * @response 404 {
     *   "status": false,
     *   "message": "Product not found"
     * }
     */
    public function show($id)
    {
        $cacheKey = "products:single:{$id}";
        
        $product = Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($id) {
            return Product::with('category')->find($id);
        });

        if (!$product) {
            return ApiResponse::notFound('Product not found');
        }

        $productData = [
            'id' => $product->id,
            'title' => $product->title,
            'price' => $product->price,
            'new_price' => $product->new_price,
            'discount_percent' => $product->discount_percent,
            'is_available' => $product->is_available,
            'is_new' => $product->is_new,
            'sell_number' => $product->sell_number,
            'description' => $product->description,
            'image' => $product->image,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
            ] : null,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at,
        ];

        return ApiResponse::success('Product retrieved successfully', [
            'product' => $productData,
            'cached' => Cache::has($cacheKey)
        ]);
    }

    // ✅ Clear products cache (call this when products are updated)
    public function clearCache()
    {
        Cache::forget('products:all');
        Cache::flush(); // Clear all cache for products
        
        return ApiResponse::success('Products cache cleared successfully');
    }
}
