<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;

class BannerApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => true,
            'banners' => Banner::where('is_active', true)->get()
        ]);
    }
}
