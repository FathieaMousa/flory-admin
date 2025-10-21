<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

/**
 * 🎯 مسؤول عن الإشعارات الخاصة بالعملاء
 */
class NotificationApiController extends Controller
{
    // ✅ عرض الإشعارات الخاصة بالعميل الحالي
    public function index(Request $request)
    {
        return response()->json(
            Notification::where('customer_id', $request->user()->id)->latest()->get()
        );
    }

    // ✅ إرسال إشعار جديد (إضافة داخلية)
    public function send(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string|max:500',
        ]);

        $notification = Notification::create([
            'customer_id' => $request->user()->id,
            'title' => $data['title'],
            'body'  => $data['body'],
            'sent_at' => now(),
        ]);

        return response()->json(['message' => 'Notification created', 'notification' => $notification]);
    }
}
