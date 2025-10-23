<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressApiController extends Controller
{
    // ✅ Display user's addresses
    public function index(Request $request)
    {
        return response()->json([
            'status' => true,
            'addresses' => $request->user()->addresses
        ]);
    }

    // ✅ Add a new address
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
        'selected' => 'nullable|boolean', // ✅ أضف هذا
    ]);

    $data['customer_id'] = $request->user()->id;

    // 🟢 إذا المستخدم ما عنده أي عنوان سابق → أول عنوان يكون افتراضي
    if (!Address::where('customer_id', $data['customer_id'])->exists()) {
        $data['selected'] = true;
    }

    // 🟢 لو المستخدم اختار العنوان كافتراضي
    if (!empty($data['selected']) && $data['selected'] == true) {
        Address::where('customer_id', $data['customer_id'])->update(['selected' => false]);
        $data['selected'] = true;
    }

    // ✅ الآن نحفظ العنوان فعلاً
    $address = Address::create($data);

    return response()->json([
        'status' => true,
        'message' => 'Address added successfully ✅',
        'address' => $address
    ], 201);
}



    // ✅ Update an existing address
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

        return response()->json([
            'status' => true,
            'message' => 'Address updated successfully ✏️',
            'address' => $address
        ]);
    }

    // ✅ Delete an address
    public function destroy(Request $request, $id)
    {
        Address::where('customer_id', $request->user()->id)->findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Address deleted successfully 🗑️'
        ]);
    }
}
