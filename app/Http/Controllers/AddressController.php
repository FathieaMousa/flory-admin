<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::with('customer')->latest()->paginate(10);
        return view('admin.addresses.index', compact('addresses'));
    }

    public function show($id)
    {
        $address = Address::with('customer')->findOrFail($id);
        return view('admin.addresses.show', compact('address'));
    }

    public function destroy($id)
    {
        Address::findOrFail($id)->delete();
        return back()->with('success', 'Address deleted successfully ✅');
    }

    public function setDefault($id)
    {
        $address = Address::findOrFail($id);

        Address::where('customer_id', $address->customer_id)->update(['selected' => false]);

        $address->update(['selected' => true]);

        return back()->with('success', 'Default address updated successfully ✅');
    }

}
