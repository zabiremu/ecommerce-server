<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class CartSyncController extends Controller
{
    public function sync(Request $request)
    {
        $request->validate([
            'items'             => 'present|array',
            'items.*.id'        => 'required|integer',
            'items.*.qty'       => 'required|integer|min:1',
            'items.*.variant_id' => 'nullable|integer|exists:product_variants,id',
            'user_name'   => 'nullable|string|max:255',
            'user_email'  => 'nullable|email|max:255',
            'user_phone'  => 'nullable|string|max:30',
        ]);

        $sessionId = session()->getId();
        $items = $request->input('items', []);

        $cart = Cart::firstOrCreate(
            ['session_id' => $sessionId],
            [
                'ip_address'    => $request->ip(),
                'user_agent'    => substr($request->userAgent() ?? '', 0, 500),
                'last_activity' => now(),
            ]
        );

        // Build update payload — prefer logged-in user data over previously stored data
        $updateData = ['last_activity' => now()];

        if ($request->filled('user_name')) {
            $updateData['contact_name'] = $request->user_name;
        }
        if ($request->filled('user_email')) {
            $updateData['contact_email'] = $request->user_email;
        }
        if ($request->filled('user_phone')) {
            $updateData['contact_phone'] = $request->user_phone;
        }

        // If email provided, try to pull phone from existing Customer record
        if ($request->filled('user_email') && empty($updateData['contact_phone'])) {
            $customer = Customer::where('email', $request->user_email)->first();
            if ($customer) {
                $updateData['contact_phone'] = $customer->phone;
                if (empty($updateData['contact_name'])) {
                    $updateData['contact_name'] = $customer->name;
                }
            }
        }

        $cart->update($updateData);

        // If cart is empty, delete items and return
        if (empty($items)) {
            $cart->items()->delete();
            return response()->json(['ok' => true]);
        }

        $productIds = collect($items)->pluck('id')->unique();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Rebuild cart items from the current localStorage snapshot
        $cart->items()->delete();

        foreach ($items as $item) {
            $product = $products->get($item['id']);
            if (!$product) continue;

            $hasSale = $product->sale_price && $product->sale_price < $product->selling_price;
            $unitPrice = (float) ($hasSale ? $product->sale_price : $product->selling_price);
            $qty = (int) $item['qty'];

            $variant = null;
            if (!empty($item['variant_id'])) {
                $variant = ProductVariant::where('id', $item['variant_id'])
                    ->where('product_id', $product->id)
                    ->first();
                if ($variant && $variant->price > 0) {
                    $unitPrice = (float) $variant->price;
                }
            }

            CartItem::create([
                'cart_id'       => $cart->id,
                'product_id'    => $product->id,
                'variant_id'    => $variant?->id,
                'product_name'  => $product->name,
                'variant_label' => $variant ? trim(implode(' / ', array_filter([$variant->color, $variant->size])) ?: $variant->name) : null,
                'variant_sku'   => $variant?->sku,
                'thumbnail'     => $product->thumbnail,
                'quantity'      => $qty,
                'unit_price'    => $unitPrice,
                'total'         => $unitPrice * $qty,
            ]);
        }

        return response()->json(['ok' => true]);
    }

    public function contact(Request $request)
    {
        $request->validate([
            'name'  => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);

        $sessionId = session()->getId();
        $cart = Cart::where('session_id', $sessionId)->first();

        if ($cart) {
            $cart->update([
                'contact_name'  => $request->input('name') ?: $cart->contact_name,
                'contact_phone' => $request->input('phone') ?: $cart->contact_phone,
            ]);
        }

        return response()->json(['ok' => true]);
    }
}
