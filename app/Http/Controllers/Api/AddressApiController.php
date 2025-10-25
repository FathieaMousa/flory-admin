<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressApiController extends Controller
{
    /**
     * 🏠 عرض كل العناوين الخاصة بالمستخدم الحالي
     */
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->orderByDesc('id')->get();

        return response()->json([
            'status' => true,
            'message' => 'Addresses retrieved successfully ✅',
            'addresses' => $addresses
        ]);
    }

    /**
     * ➕ إضافة عنوان جديد للمستخدم
     */
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
            'selected' => 'nullable|boolean',
        ]);

        $data['customer_id'] = $request->user()->id;

        // 🟢 إذا المستخدم ما عنده أي عنوان سابق → أول عنوان يكون افتراضي
        if (!Address::where('customer_id', $data['customer_id'])->exists()) {
            $data['selected'] = true;
        }

        // 🟢 لو المستخدم اختار العنوان كافتراضي → ألغِ الافتراضية عن غيره
        if (!empty($data['selected']) && $data['selected'] == true) {
            Address::where('customer_id', $data['customer_id'])->update(['selected' => false]);
            $data['selected'] = true;
        }

        // ✅ حفظ العنوان فعلاً
        $address = Address::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Address added successfully ✅',
            'address' => $address
        ], 201);
    }

    /**
     * ✏️ تعديل عنوان موجود
     */
    public function update(Request $request, $id)
    {
        $address = Address::where('customer_id', $request->user()->id)->findOrFail($id);

        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:50',
            'country' => 'nullable|string|max:50',
            'selected' => 'nullable|boolean',
        ]);

        // ✨ لو طلب المستخدم جعله افتراضي
        if (!empty($data['selected']) && $data['selected'] == true) {
            Address::where('customer_id', $request->user()->id)->update(['selected' => false]);
            $data['selected'] = true;
        }

        $address->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Address updated successfully ✏️',
            'address' => $address
        ]);
    }

    /**
     * 🗑️ حذف عنوان
     */
    public function destroy(Request $request, $id)
    {
        $address = Address::where('customer_id', $request->user()->id)->findOrFail($id);
        $address->delete();

        return response()->json([
            'status' => true,
            'message' => 'Address deleted successfully 🗑️'
        ]);
    }

    /**
     * ⭐ تعيين عنوان كافتراضي
     */
    public function setDefault(Request $request, $id)
    {
        $address = Address::where('customer_id', $request->user()->id)->findOrFail($id);

        Address::where('customer_id', $request->user()->id)->update(['selected' => false]);
        $address->update(['selected' => true]);

        return response()->json([
            'status' => true,
            'message' => 'Default address updated successfully ⭐',
            'address' => $address
        ]);
    }
}
