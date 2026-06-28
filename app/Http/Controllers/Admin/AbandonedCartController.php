<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use Illuminate\Http\Request;

class AbandonedCartController extends Controller
{
    public function index(Request $request)
    {
        $query = Cart::with(['items'])
            ->whereNull('converted_at')
            ->whereHas('items')
            ->orderBy('last_activity', 'desc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('contact_name', 'like', "%$s%")
                  ->orWhere('contact_phone', 'like', "%$s%")
                  ->orWhere('ip_address', 'like', "%$s%");
            });
        }

        $carts = $query->get();

        return view('Admin.abandoned_carts.index', compact('carts'));
    }

    public function show(Cart $cart)
    {
        $cart->load('items.product', 'order');

        // Try to find a matching Customer record by email or phone
        $customer = null;
        if ($cart->contact_email) {
            $customer = Customer::where('email', $cart->contact_email)->first();
        }
        if (!$customer && $cart->contact_phone) {
            $customer = Customer::where('phone', $cart->contact_phone)->first();
        }

        return view('Admin.abandoned_carts.show', compact('cart', 'customer'));
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();
        return redirect()->route('admin.abandoned-carts.index')
            ->with('success', 'Cart record deleted.');
    }
}
