<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    //
    public function index()
    {
        $items = Cart::instance('cart')->content();

        return view('cart', compact('items'));
    }

    public function add_to_cart(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate('App\Models\Product');

        return redirect()->back();
    }

    public function increase_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);

        return redirect()->back();
    }

    public function decrease_cart_quantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);

        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);

        return redirect()->back();
    }

    public function empty_cart()
    {
        Cart::instance('cart')->destroy();

        return redirect()->back();
    }

    public function apply_coupon_code(Request $request)
    {
        $coupon_code = $request->coupon_code;

        if (! $coupon_code) {
            return redirect()->back()->with('error', 'Please enter a coupon code.');
        }

        // Ambil subtotal dalam format numerik (hilangkan koma & simbol lain)
        $subtotal = floatval(preg_replace('/[^\d.]/', '', Cart::instance('cart')->subtotal()));

        // Cek kupon berdasarkan kode, tanggal kadaluarsa, dan nilai minimum cart
        $coupon = Coupon::where('code', $coupon_code)
            ->whereDate('expiry_date', '>=', Carbon::today())
            ->where('cart_value', '<=', $subtotal)
            ->first();

        if (! $coupon) {
            return redirect()->back()->with('error', 'Invalid or expired coupon code!');
        }

        // Simpan ke session
        Session::put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'cart_value' => $coupon->cart_value,
        ]);

        // Hitung ulang total harga setelah diskon
        $this->calculate_discount();

        return redirect()->back()->with('success', 'Coupon applied successfully!');
    }

    public function calculate_discount()
    {
        $discount = 0;

        if (Session::has('coupon')) {
            // Pastikan subtotal dan value benar-benar numeric
            $subtotal = floatval(str_replace(',', '', Cart::instance('cart')->subtotal()));
            $value = floatval(Session::get('coupon')['value']);

            if (Session::get('coupon')['type'] == 'fixed') {
                $discount = $value;
            } else {
                $discount = $subtotal * ($value / 100);
            }

            $subtotal_after_discount = $subtotal - $discount;
            $tax_after_discount = ($subtotal_after_discount * config('cart.tax')) / 100;
            $total_after_discount = $subtotal_after_discount + $tax_after_discount;

            Session::put('discounts', [
                'discount' => number_format($discount, 2, '.', ''),
                'subtotal' => number_format($subtotal_after_discount, 2, '.', ''),
                'tax' => number_format($tax_after_discount, 2, '.', ''),
                'total' => number_format($total_after_discount, 2, '.', ''),
            ]);
        }
    }

    public function remove_coupon_code()
    {
        Session::forget('coupon');
        Session::forget('discounts');

        return redirect()->back()->with('success', 'Coupon removed successfully!');
    }

    public function checkout()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $address = Address::where('user_id', Auth::user()->id)->where('isdefault', 1)->first();

        return view('checkout', compact('address'));
    }
}
