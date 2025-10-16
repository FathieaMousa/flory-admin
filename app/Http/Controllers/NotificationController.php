<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('customer')
            ->latest()
            ->paginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }

    public function destroy(Notification $notification)
    {
        $notification->delete();
        return back()->with('success', 'Notification deleted successfully.');
    }

    public function markAsRead(Notification $notification)
    {
        $notification->update(['is_read' => true]);
        return back()->with('success', 'Notification marked as read.');
    }

    /**
     * إرسال إشعار جديد (بالمستقبل عبر FCM)
     */
    public function send(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:500',
            'customer_id' => 'required|exists:customers,id'
        ]);

        $customer = Customer::find($data['customer_id']);

        // حفظ الإشعار في قاعدة البيانات
        $notification = Notification::create([
            'customer_id' => $customer->id,
            'title' => $data['title'],
            'body' => $data['body'],
            'sent_at' => now(),
        ]);

        // ✨ (لاحقاً): إرسال عبر FCM لما نربط Firebase Cloud Messaging
        // if ($customer->fcm_token) {
        //     Http::withHeaders([
        //         'Authorization' => 'key=' . config('services.fcm.server_key'),
        //         'Content-Type' => 'application/json',
        //     ])->post('https://fcm.googleapis.com/fcm/send', [
        //         'to' => $customer->fcm_token,
        //         'notification' => [
        //             'title' => $data['title'],
        //             'body' => $data['body'],
        //         ],
        //     ]);
        // }

        return back()->with('success', 'Notification created successfully!');
    }
}
