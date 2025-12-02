<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Address::where('user_id', Auth::user()->id)
            ->orderBy('isdefault', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.account-address', compact('addresses'));
    }

    public function create()
    {
        return view('user.account-address-edit');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric|digits:12',
            'zip' => 'required|numeric|digits:5',
            'state' => 'required|max:100',
            'city' => 'required|max:100',
            'address' => 'required|max:255',
            'locality' => 'required|max:255',
            'landmark' => 'nullable|max:255',
            'type' => 'nullable|in:home,work,other',
        ]);

        // If this is set as default, unset other defaults
        if ($request->has('isdefault') && $request->isdefault == '1') {
            Address::where('user_id', Auth::user()->id)
                ->update(['isdefault' => false]);
        }

        $address = new Address;
        $address->user_id = Auth::user()->id;
        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark ?? '';
        $address->country = 'Indonesia';
        $address->type = $request->type ?? 'home';
        $address->isdefault = $request->has('isdefault') && $request->isdefault == '1' ? true : false;
        $address->save();

        return redirect()->route('user.addresses')->with('status', 'Address added successfully!');
    }

    public function edit($id)
    {
        $address = Address::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();

        return view('user.account-address-edit', compact('address'));
    }

    public function update(Request $request, $id)
    {
        $address = Address::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();

        $request->validate([
            'name' => 'required|max:100',
            'phone' => 'required|numeric|digits:12',
            'zip' => 'required|numeric|digits:6',
            'state' => 'required|max:100',
            'city' => 'required|max:100',
            'address' => 'required|max:255',
            'locality' => 'required|max:255',
            'landmark' => 'nullable|max:255',
            'type' => 'nullable|in:home,work,other',
        ]);

        // If this is set as default, unset other defaults
        if ($request->has('isdefault') && $request->isdefault == '1') {
            Address::where('user_id', Auth::user()->id)
                ->where('id', '!=', $id)
                ->update(['isdefault' => false]);
        }

        $address->name = $request->name;
        $address->phone = $request->phone;
        $address->zip = $request->zip;
        $address->state = $request->state;
        $address->city = $request->city;
        $address->address = $request->address;
        $address->locality = $request->locality;
        $address->landmark = $request->landmark ?? '';
        $address->type = $request->type ?? 'home';
        $address->isdefault = $request->has('isdefault') && $request->isdefault == '1' ? true : false;
        $address->save();

        return redirect()->route('user.addresses')->with('status', 'Address updated successfully!');
    }

    public function destroy($id)
    {
        $address = Address::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();
        $address->delete();

        return redirect()->route('user.addresses')->with('status', 'Address deleted successfully!');
    }

    public function setDefault($id)
    {
        $address = Address::where('user_id', Auth::user()->id)->where('id', $id)->firstOrFail();

        // Unset all other defaults
        Address::where('user_id', Auth::user()->id)
            ->update(['isdefault' => false]);

        // Set this as default
        $address->isdefault = true;
        $address->save();

        return redirect()->route('user.addresses')->with('status', 'Default address updated successfully!');
    }
}
