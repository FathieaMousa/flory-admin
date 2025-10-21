<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressApiController extends Controller
{
    // ✅ عرض عناوين المستخدم
    public function index(Request $request)
    {
        return response()->json([
            'status' => true,
            'addresses' => $request->user()->addresses
        ]);
    }

    // ✅ إضافة عنوان جديد
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
        ]);

        $data['customer_id'] = $request->user()->id;

        // إذا هذا العنوان هو الافتراضي
        if ($request->has('selected') && $request->selected == true) {
            Address::where('customer_id', $data['customer_id'])->update(['selected' => false]);
            $data['selected'] = true;
        }

        $address = Address::create($data);

        return response()->json([
            'status' => true,
            'message' => 'تم إضافة العنوان ✅',
            'address' => $address
        ], 201);
    }

    // ✅ تحديث عنوان
    public function update(Request $request, $id)
    {
        $address = Address::where('customer_id', $request->user()->id)->findOrFail($id);

        $data = $request->validate([
            'name' => 'string|max:255',
            'phone' => 'string|max:50',
            'street' => 'string|max:255',
            'city' => 'string|max:255',
            'state' => 'string|max:255',
            'postal_code' => 'string|max:50',
            'country' => 'string|max:50',
        ]);

        if ($request->has('selected') && $request->selected == true) {
            Address::where('customer_id', $request->user()->id)->update(['selected' => false]);
            $data['selected'] = true;
        }

        $address->update($data);

        return response()->json(['status' => true, 'message' => 'تم تحديث العنوان ✅', 'address' => $address]);
    }

    // ✅ حذف عنوان
    public function destroy(Request $request, $id)
    {
        Address::where('customer_id', $request->user()->id)->findOrFail($id)->delete();

        return response()->json(['status' => true, 'message' => 'تم حذف العنوان 🗑️']);
    }
}
