<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Carbon\Carbon;


class CouponApiController extends Controller
{
    public function index()
    {
        return response()->json(Coupon::latest()->get());
    }

    public function validateCoupon($code)
    {
        $coupon = Coupon::where('code', $code)->first();

        if (! $coupon) return response()->json(['valid' => false, 'message' => 'Invalid coupon']);

        if ($coupon->end_date && Carbon::parse($coupon->end_date)->isPast()) {
            return response()->json(['valid' => false, 'message' => 'Expired']);
        }

        return response()->json(['valid' => true, 'coupon' => $coupon]);
    }
}
