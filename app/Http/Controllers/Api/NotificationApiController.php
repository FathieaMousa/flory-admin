<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;


class NotificationApiController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            Notification::where('customer_id', $request->user()->id)->latest()->get()
        );
    }

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
