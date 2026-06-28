<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\PhoneBlacklist;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Services\BdCourierFraudService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'shipping_name'    => 'required|string|max:255',
            'shipping_phone'   => 'required|string|max:30',
            'shipping_email'   => 'nullable|email|max:255',
            'shipping_address' => 'required|string|max:1000',
            'shipping_city'    => 'required|string|max:100',
            'payment_method'   => 'required|in:cod,bkash,nagad,rocket,bank,uddoktapay',
            'notes'            => 'nullable|string|max:1000',
            'coupon_code'      => 'nullable|string|max:50',
            'items'            => 'required|array|min:1',
            'items.*.id'       => 'required|integer|exists:products,id',
            'items.*.qty'      => 'required|integer|min:1',
            'items.*.variant_id' => 'nullable|integer|exists:product_variants,id',
            'recaptcha_token'  => 'nullable|string',
        ]);

        // ── reCAPTCHA v3 — score only, never block ────────────────────
        $recaptchaScore = null;
        $recaptchaSecret = config('services.recaptcha.secret');
        if ($recaptchaSecret && !empty($data['recaptcha_token'])) {
            $resp = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret'   => $recaptchaSecret,
                'response' => $data['recaptcha_token'],
                'remoteip' => $request->ip(),
            ])->json();

            if ($resp['success'] ?? false) {
                $recaptchaScore = (float) ($resp['score'] ?? 1.0);
            }
        }

        // ── Phone blacklist check ─────────────────────────────────────
        if (PhoneBlacklist::isBlocked($data['shipping_phone'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to place order. Please contact support.',
            ], 422);
        }

        // ── BD Courier Fraud Check ────────────────────────────────────
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
                // Enabled but phone not found — store zeros so admin can see it was checked
                $bdcourierResult = ['success_ratio' => null, 'total_parcels' => 0, 'fraud_reports' => 0];
            }
        }

        $productIds = collect($data['items'])->pluck('id')->unique();
        $products = Product::published()->whereIn('id', $productIds)->get()->keyBy('id');

        if ($products->count() === 0) {
            return response()->json(['success' => false, 'message' => 'No valid products in your order.'], 422);
        }

        $lineItems = [];
        $subtotal = 0;
        foreach ($data['items'] as $item) {
            $p = $products->get($item['id']);
            if (!$p) continue;
            $hasSale = $p->sale_price && $p->sale_price < $p->selling_price;
            $unitPrice = (float) ($hasSale ? $p->sale_price : $p->selling_price);

            $variant = null;
            if (!empty($item['variant_id'])) {
                $variant = ProductVariant::where('id', $item['variant_id'])
                    ->where('product_id', $p->id)
                    ->first();
                if ($variant && $variant->price > 0) {
                    $unitPrice = (float) $variant->price;
                }
            }

            $lineTotal = $unitPrice * $item['qty'];
            $subtotal += $lineTotal;
            $lineItems[] = [
                'product'    => $p,
                'variant'    => $variant,
                'quantity'   => $item['qty'],
                'unit_price' => $unitPrice,
                'total'      => $lineTotal,
            ];
        }

        if (empty($lineItems)) {
            return response()->json(['success' => false, 'message' => 'No valid products in your order.'], 422);
        }

        // Stock availability check
        $stockErrors = [];
        foreach ($lineItems as $li) {
            $p   = $li['product'];
            $qty = $li['quantity'];
            $availableStock = $li['variant'] ? (float) $li['variant']->stock : (float) $p->stock;
            if ($p->type === 'physical' && $availableStock < $qty) {
                $available = max(0, (int) $availableStock);
                $stockErrors[] = $available > 0
                    ? "\"{$p->name}\" — only {$available} left in stock (you requested {$qty})"
                    : "\"{$p->name}\" is out of stock";
            }
        }

        if (!empty($stockErrors)) {
            return response()->json([
                'success' => false,
                'message' => 'Some items are unavailable: ' . implode('; ', $stockErrors),
            ], 422);
        }

        $discount = 0;
        $freeShipping = false;
        $couponModel = null;
        if (!empty($data['coupon_code'])) {
            $couponModel = Coupon::where('code', strtoupper(trim($data['coupon_code'])))->first();
            if ($couponModel && $couponModel->isUsable()) {
                $discount = $couponModel->discountFor($subtotal);
                $freeShipping = (bool) $couponModel->free_shipping;
            }
        }

        $shippingCharge = ($freeShipping || $subtotal >= 500) ? 0 : 60;

        return (new OrderService())->place(
            $data,
            $lineItems,
            $subtotal,
            $shippingCharge,
            $discount,
            $couponModel,
            $bdcourierResult,
            $recaptchaScore,
            $request
        );
    }
}
