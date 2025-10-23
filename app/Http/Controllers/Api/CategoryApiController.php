<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

/**
 * 🎯 مسؤول عن جلب التصنيفات (Categories)
 */
class CategoryApiController extends Controller
{
    // ✅ عرض جميع التصنيفات مع الأب إن وجد
    public function index()
    {
        return response()->json(Category::with('parent')->orderBy('name')->get());
    }

    // ✅ عرض تصنيف محدد مع المنتجات التابعة له
    public function show($id)
    {
        $category = Category::with(['parent', 'products'])->find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found ❌'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Category retrieved successfully ✅',
            'data' => $category
        ]);
    }
}
