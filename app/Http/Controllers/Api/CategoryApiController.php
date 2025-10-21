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
}
