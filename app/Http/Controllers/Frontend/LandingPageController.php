<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PhoneBlacklist;
use App\Models\ProductLandingPage;
use App\Models\SiteSetting;
use App\Services\BdCourierFraudService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show(string $slug)
    {
        $landing = ProductLandingPage::with('product.category', 'product.brand')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $product = $landing->product;

        abort_if(!$product || $product->publish_status !== 'published', 404);

        $hasSale  = $product->sale_price && $product->sale_price < $product->selling_price;
        $current  = $hasSale ? (float) $product->sale_price : (float) $product->selling_price;
        $old      = $hasSale ? (float) $product->selling_price : null;
        $discount = $hasSale && $product->selling_price > 0
            ? (int) round((($product->selling_price - $product->sale_price) / $product->selling_price) * 100)
            : 0;
        $save     = $old ? ($old - $current) : 0;
        $stock    = (int) ($product->stock ?? 0);
        $oos      = $product->type !== 'digital' && $stock <= 0;

        $images   = collect([$product->thumbnail])
            ->merge(collect($product->gallery ?? [])->pluck('path'))
            ->filter()->unique()->values();

        $siteName  = SiteSetting::get('company_name', 'Shop');
        $pageTitle = ($landing->meta_title ?: $landing->hero_heading ?: $product->name) . ' — ' . $siteName;

        return view('Frontend.landing-page', compact(
            'landing', 'product', 'current', 'old', 'discount', 'save', 'stock', 'oos', 'images', 'pageTitle', 'siteName'
        ));
    }

    /**
     * Place an order from the landing-page funnel form.
     * Uses the landing's zone-based shipping and the shared OrderService.
     */
    public function order(Request $request, string $slug)
    {
        $landing = ProductLandingPage::with('product')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $product = $landing->product;
        abort_if(!$product || $product->publish_status !== 'published', 404);

        $paymentRule = $landing->enable_online_payment ? 'in:cod,uddoktapay' : 'in:cod';

        $data = $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:30',
            'shipping_address' => 'required|string|max:1000',
            'zone'             => 'required|in:inside,outside',
            'quantity'         => 'required|integer|min:1',
            'payment_method'   => 'required|string|' . $paymentRule,
        ]);

        // ── Phone blacklist ───────────────────────────────────────────
        if (PhoneBlacklist::isBlocked($data['shipping_phone'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to place order. Please contact support.',
            ], 422);
        }

        // ── BD Courier fraud check ────────────────────────────────────
        $bdcourierResult = null;
        if (BdCourierFraudService::isEnabled()) {
            $raw = (new BdCourierFraudService())->check($data['shipping_phone']);
            if ($raw !== null) {
                $bdcourierResult = $raw;
                $minRatio = BdCourierFraudService::minSuccessRatio();
                if ($minRatio > 0 && $raw['total_parcels'] > 0 && $raw['success_ratio'] < $minRatio) {
                    return response()->json([
                        'success' => false,
                        'message' => 'এই ফোন নম্বরে অতিরিক্ত ক্যান্সেলড ডেলিভারি রেকর্ড রয়েছে। অর্ডার গ্রহণ করা সম্ভব হচ্ছে না।',
                    ], 422);
                }
            } else {
                $bdcourierResult = ['success_ratio' => null, 'total_parcels' => 0, 'fraud_reports' => 0];
            }
        }

        // ── Pricing ───────────────────────────────────────────────────
        $hasSale   = $product->sale_price && $product->sale_price < $product->selling_price;
        $unitPrice = (float) ($hasSale ? $product->sale_price : $product->selling_price);
        $qty       = (int) $data['quantity'];
        $subtotal  = $unitPrice * $qty;

        // Stock check (physical only)
        if ($product->type === 'physical' && (float) $product->stock < $qty) {
            $available = max(0, (int) $product->stock);
            return response()->json([
                'success' => false,
                'message' => $available > 0
                    ? "Only {$available} left in stock (you requested {$qty})."
                    : 'This product is out of stock.',
            ], 422);
        }

        $shipping  = $data['zone'] === 'inside'
            ? (float) $landing->shipping_inside_dhaka
            : (float) $landing->shipping_outside_dhaka;

        $lineItems = [[
            'product'    => $product,
            'quantity'   => $qty,
            'unit_price' => $unitPrice,
            'total'      => $subtotal,
        ]];

        $orderData = [
            'shipping_name'    => $data['shipping_name'],
            'shipping_phone'   => $data['shipping_phone'],
            'shipping_email'   => null,
            'shipping_address' => $data['shipping_address'],
            'shipping_city'    => $data['zone'] === 'inside' ? 'Inside Dhaka' : 'Outside Dhaka',
            'shipping_area'    => $data['zone'] === 'inside' ? 'inside' : 'outside',
            'payment_method'   => $data['payment_method'],
            'notes'            => 'Landing page order: ' . $landing->slug,
        ];

        return (new OrderService())->place(
            $orderData,
            $lineItems,
            $subtotal,
            $shipping,
            0,
            null,
            $bdcourierResult,
            null,
            $request
        );
    }
}
