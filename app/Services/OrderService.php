<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmationMail;
use App\Mail\WelcomeMail;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Shared order placement used by the normal checkout (Frontend\OrderController)
 * and the landing-page funnel (Frontend\LandingPageController).
 *
 * Callers are responsible for their own validation, guards (blacklist, BD
 * courier, stock) and pricing (subtotal / shipping / discount). This service
 * owns the transaction (customer + order + items + notifications), the
 * post-transaction emails, and the final JSON response (UddoktaPay charge or
 * order-complete redirect).
 */
class OrderService
{
    /**
     * @param  array  $data         Validated shipping_* + payment_method + notes (+ optional shipping_area)
     * @param  array  $lineItems    [['product'=>Product,'quantity'=>int,'unit_price'=>float,'total'=>float], ...]
     */
    public function place(
        array $data,
        array $lineItems,
        float $subtotal,
        float $shippingCharge,
        float $discount,
        ?Coupon $couponModel,
        ?array $bdcourierResult,
        ?float $recaptchaScore,
        Request $request
    ): JsonResponse {
        $total = max(0, $subtotal + $shippingCharge - $discount);

        // ── Risk score calculation ────────────────────────────────────
        $risk = (new OrderRiskService())->calculate($data['shipping_phone'], $total, $request, $recaptchaScore);

        $order = DB::transaction(function () use ($data, $lineItems, $subtotal, $shippingCharge, $discount, $total, $couponModel, $risk, $bdcourierResult, $request) {
            $customer = Customer::firstOrNew(['phone' => $data['shipping_phone']]);
            $isNewCustomer = !$customer->exists;
            $customer->fill([
                'name'    => $data['shipping_name'],
                'email'   => $data['shipping_email'] ?? $customer->email,
                'address' => $data['shipping_address'],
                'city'    => $data['shipping_city'] ?? $customer->city,
            ]);
            if ($isNewCustomer) {
                $customer->status = true;
            }
            $customer->save();

            $orderNo = $this->nextOrderNumber();
            $order = Order::create([
                'order_no'         => $orderNo,
                'customer_id'      => $customer->id,
                'shipping_name'    => $data['shipping_name'],
                'shipping_phone'   => $data['shipping_phone'],
                'shipping_email'   => $data['shipping_email'] ?? null,
                'shipping_address' => $data['shipping_address'],
                'shipping_city'    => $data['shipping_city'],
                'shipping_area'    => $data['shipping_area'] ?? null,
                'subtotal'         => $subtotal,
                'shipping_charge'  => $shippingCharge,
                'discount'         => $discount,
                'total'            => $total,
                'payment_method'   => $data['payment_method'],
                'payment_status'   => 'unpaid',
                'status'           => 'pending',
                'notes'            => $data['notes'] ?? null,
                'placed_at'        => now(),
                'ip_address'                => $request->ip(),
                'risk_score'                => $risk['score'],
                'risk_flags'                => $risk['flags'] ?: null,
                'bdcourier_success_ratio'   => $bdcourierResult['success_ratio'] ?? null,
                'bdcourier_total_parcels'   => $bdcourierResult['total_parcels'] ?? null,
                'bdcourier_fraud_reports'   => $bdcourierResult['fraud_reports'] ?? null,
            ]);

            foreach ($lineItems as $li) {
                $p = $li['product'];
                $variant = $li['variant'] ?? null;
                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $p->id,
                    'variant_id'    => $variant?->id,
                    'product_name'  => $p->name,
                    'variant_label' => $variant ? trim(implode(' / ', array_filter([$variant->color, $variant->size])) ?: $variant->name) : null,
                    'product_sku'   => $p->sku,
                    'variant_sku'   => $variant?->sku,
                    'thumbnail'     => $p->thumbnail,
                    'quantity'      => $li['quantity'],
                    'unit_price'    => $li['unit_price'],
                    'total'         => $li['total'],
                ]);
            }

            if ($couponModel && $discount > 0) {
                $couponModel->increment('used_count');
            }

            $customer->recalculateStats();

            $cartRecord = Cart::where('session_id', session()->getId())->first();
            if ($cartRecord && !$cartRecord->converted_at) {
                $cartRecord->update(['converted_at' => now(), 'order_id' => $order->id]);
            }

            // Admin notifications
            AdminNotificationService::newOrder($order->order_no, $data['shipping_name'], $total);
            if ($isNewCustomer) {
                AdminNotificationService::newCustomer($data['shipping_name'], $data['shipping_phone']);
            }

            return $order;
        });

        // ── Send customer emails (outside transaction) ──────────────────
        $customerEmail = $order->shipping_email
            ?: optional($order->customer)->email;

        if ($customerEmail) {
            try {
                MailConfigService::apply();
                $order->loadMissing('items');

                // Order confirmation — every order
                Mail::to($customerEmail)->send(new OrderConfirmationMail($order));

                // Welcome — only first-time customers
                if (optional($order->customer)->total_orders <= 1) {
                    Mail::to($customerEmail)->send(
                        new WelcomeMail($order->shipping_name, $customerEmail, $order->order_no)
                    );
                }
            } catch (\Throwable $e) {
                Log::warning('Order email failed for #' . $order->order_no . ': ' . $e->getMessage());
            }
        }

        if ($order->payment_method === 'uddoktapay') {
            try {
                $result = (new UddoktaPayService())->createCharge($order);
                $paymentUrl = $result['payment_url'] ?? null;
                if ($paymentUrl) {
                    return response()->json([
                        'success'    => true,
                        'order_no'   => $order->order_no,
                        'redirect'   => $paymentUrl,
                        'uddoktapay' => true,
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('UddoktaPay charge failed', ['order' => $order->order_no, 'error' => $e->getMessage()]);
            }
        }

        return response()->json([
            'success'  => true,
            'order_no' => $order->order_no,
            'redirect' => route('order-complete') . '?id=' . $order->order_no,
        ]);
    }

    public function nextOrderNumber(): string
    {
        $prefix = 'NF-' . Carbon::now()->format('Ymd') . '-';
        do {
            $candidate = $prefix . str_pad((string) random_int(100, 999), 3, '0', STR_PAD_LEFT);
        } while (Order::where('order_no', $candidate)->exists());
        return $candidate;
    }
}
