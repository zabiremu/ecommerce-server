<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ShopApiController extends Controller
{
    /**
     * Minimal product payloads for client-side rendering (cart / wishlist pages).
     * GET /api/products?ids=1,2,3
     */
    public function products(Request $request)
    {
        $ids = collect(explode(',', (string) $request->query('ids')))
            ->map(fn ($id) => (int) trim($id))
            ->filter()
            ->unique()
            ->values();

        if ($ids->isEmpty()) {
            return response()->json([]);
        }

        $products = Product::published()->whereIn('id', $ids)->get();

        $resolveImage = function (?string $path) {
            if (!$path) return null;
            return Storage::disk('public')->exists($path) ? Storage::url($path) : asset($path);
        };

        return response()->json($products->map(function (Product $p) use ($resolveImage) {
            $hasSale = $p->sale_price && $p->sale_price < $p->selling_price;

            return [
                'id'       => $p->id,
                'slug'     => $p->slug,
                'name'     => $p->name,
                'sku'      => $p->sku,
                'image'    => $resolveImage($p->thumbnail),
                'price'    => (float) ($hasSale ? $p->sale_price : $p->selling_price),
                'old_price' => $hasSale ? (float) $p->selling_price : null,
                'stock'    => (float) $p->stock,
                'type'     => $p->type,
                'url'      => route('product-details') . '?slug=' . $p->slug,
            ];
        })->values());
    }

    /**
     * Live subtotal / discount / shipping / total for the cart or checkout
     * page — mirrors the pricing rules used when the order is actually placed.
     * POST /api/cart/quote
     */
    public function quote(Request $request)
    {
        $data = $request->validate([
            'items'              => 'present|array',
            'items.*.id'         => 'required|integer',
            'items.*.qty'        => 'required|integer|min:1',
            'items.*.variant_id' => 'nullable|integer',
            'coupon_code'        => 'nullable|string|max:50',
        ]);

        $productIds = collect($data['items'])->pluck('id')->unique();
        $products = Product::published()->whereIn('id', $productIds)->get()->keyBy('id');

        $lines = [];
        $subtotal = 0;

        foreach ($data['items'] as $item) {
            $product = $products->get($item['id']);
            if (!$product) continue;

            $hasSale = $product->sale_price && $product->sale_price < $product->selling_price;
            $unitPrice = (float) ($hasSale ? $product->sale_price : $product->selling_price);

            $variant = null;
            if (!empty($item['variant_id'])) {
                $variant = ProductVariant::where('id', $item['variant_id'])
                    ->where('product_id', $product->id)
                    ->first();
                if ($variant && $variant->price > 0) {
                    $unitPrice = (float) $variant->price;
                }
            }

            $lineTotal = $unitPrice * $item['qty'];
            $subtotal += $lineTotal;

            $lines[] = [
                'id'         => $product->id,
                'variant_id' => $variant?->id,
                'name'       => $product->name,
                'variant_label' => $variant ? trim(implode(' / ', array_filter([$variant->color, $variant->size])) ?: $variant->name) : null,
                'qty'        => (int) $item['qty'],
                'unit_price' => $unitPrice,
                'total'      => $lineTotal,
            ];
        }

        $discount = 0;
        $freeShipping = false;
        $couponMessage = null;

        if (!empty($data['coupon_code'])) {
            $coupon = Coupon::where('code', strtoupper(trim($data['coupon_code'])))->first();
            if (!$coupon || !$coupon->isUsable()) {
                $couponMessage = 'This coupon code is not valid.';
            } elseif ($coupon->minimum_spend && $subtotal < (float) $coupon->minimum_spend) {
                $couponMessage = 'This coupon requires a minimum spend of ' . number_format((float) $coupon->minimum_spend, 2) . '.';
            } else {
                $discount = $coupon->discountFor($subtotal);
                $freeShipping = (bool) $coupon->free_shipping;
                $couponMessage = 'Coupon applied.';
            }
        }

        $shipping = ($freeShipping || $subtotal >= 500) ? 0 : 60;
        $total = max(0, $subtotal - $discount + $shipping);

        return response()->json([
            'items'          => $lines,
            'subtotal'       => round($subtotal, 2),
            'discount'       => round($discount, 2),
            'shipping'       => round($shipping, 2),
            'total'          => round($total, 2),
            'coupon_message' => $couponMessage,
            'coupon_valid'   => $discount > 0 || $freeShipping,
        ]);
    }
}
