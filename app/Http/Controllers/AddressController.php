<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    // ✅ عرض كل العناوين مع اسم العميل
    public function index()
    {
        $addresses = Address::with('customer')->latest()->paginate(10);
        return view('admin.addresses.index', compact('addresses'));
    }

    // ✅ عرض تفاصيل عنوان معين
    public function show($id)
    {
        $address = Address::with('customer')->findOrFail($id);
        return view('admin.addresses.show', compact('address'));
    }

    // ✅ حذف عنوان
    public function destroy($id)
    {
        Address::findOrFail($id)->delete();
        return back()->with('success', 'Address deleted successfully ✅');
    }
}
