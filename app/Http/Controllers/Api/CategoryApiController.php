<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function index()
    {
        return response()->json(Category::with('parent')->orderBy('name')->get());
    }

    public function show($id)
    {
        $category = Category::with(['parent', 'products'])->find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Category retrieved successfully',
            'data' => $category
        ]);
    }
}
