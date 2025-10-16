<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Notification;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // 📋 عرض جميع العملاء
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('admin.customers.index', compact('customers'));
    }

    // 👤 عرض تفاصيل عميل محدد
    public function show($id)
    {
        $customer = Customer::with(['orders.items.product'])->findOrFail($id);

        // 🧾 إحصائيات العميل
        $totalOrders = $customer->orders->count();
        $totalSpent  = $customer->orders->sum('total');
        $lastOrders  = $customer->orders()->latest()->take(5)->get();

        // 🔔 إشعارات العميل
        $notifications = Notification::where('customer_id', $customer->id)
            ->latest()->take(10)->get();

        return view('admin.customers.show', [
            'customer'       => $customer,
            'totalOrders'    => $totalOrders,
            'totalSpent'     => $totalSpent,
            'lastOrders'     => $lastOrders,
            'notifications'  => $notifications,
        ]);
    }

    // 💬 حفظ إشعار داخلي للعميل
    public function sendNotification(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body'  => 'required|string|max:1000',
        ]);

        $customer = Customer::findOrFail($id);

        Notification::create([
            'customer_id' => $customer->id,
            'title'       => $request->title,
            'body'        => $request->body,
            'is_read'     => false,
            'sent_at'     => now(),
        ]);

        return back()->with('success', 'Notification saved successfully ✅');
    }

    // ❌ حذف عميل
    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return back()->with('success', 'Customer removed.');
    }
}
