<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

/**
 * 🎯 مسؤول عن جلب التصنيفات (Categories)
 */
class CategoryApiController extends Controller
{
    // Cache duration in minutes
    private const CACHE_DURATION = 15;

    // ✅ عرض جميع التصنيفات مع الأب إن وجد مع Redis Cache
    public function index()
    {
        $cacheKey = 'categories:all';
        
        $categories = Cache::remember($cacheKey, self::CACHE_DURATION, function () {
            return Category::with('parent')
                ->orderBy('name')
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'description' => $category->description,
                        'image' => $category->image,
                        'parent' => $category->parent ? [
                            'id' => $category->parent->id,
                            'name' => $category->parent->name,
                        ] : null,
                        'created_at' => $category->created_at,
                        'updated_at' => $category->updated_at,
                    ];
                });
        });

        return response()->json([
            'status' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $categories,
            'cached' => Cache::has($cacheKey)
        ]);
    }

    // ✅ عرض تصنيف محدد مع المنتجات التابعة له مع Redis Cache
    public function show($id)
    {
        $cacheKey = "categories:single:{$id}";
        
        $category = Cache::remember($cacheKey, self::CACHE_DURATION, function () use ($id) {
            return Category::with(['parent', 'products' => function ($query) {
                $query->where('is_available', true);
            }])->find($id);
        });

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $categoryData = [
            'id' => $category->id,
            'name' => $category->name,
            'description' => $category->description,
            'image' => $category->image,
            'parent' => $category->parent ? [
                'id' => $category->parent->id,
                'name' => $category->parent->name,
            ] : null,
            'products' => $category->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $product->price,
                    'new_price' => $product->new_price,
                    'discount_percent' => $product->discount_percent,
                    'is_available' => $product->is_available,
                    'is_new' => $product->is_new,
                    'image' => $product->image,
                ];
            }),
            'created_at' => $category->created_at,
            'updated_at' => $category->updated_at,
        ];

        return response()->json([
            'status' => true,
            'message' => 'Category retrieved successfully',
            'data' => $categoryData,
            'cached' => Cache::has($cacheKey)
        ]);
    }

    // ✅ Clear categories cache (call this when categories are updated)
    public function clearCache()
    {
        Cache::forget('categories:all');
        Cache::forget("categories:single:*"); // Clear all single category cache
        
        return response()->json([
            'status' => true,
            'message' => 'Categories cache cleared successfully'
        ]);
    }
}
