<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SiteSetting;
use App\Services\SteadfastService;
use Illuminate\Http\Request;

class SteadfastController extends Controller
{
    public function __construct(private SteadfastService $steadfast) {}

    /**
     * One-click AJAX send to Steadfast.
     */
    public function send(Request $request, Order $order)
    {
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$this->steadfast->isConfigured()) {
            $msg = 'Steadfast API credentials are not configured. Go to Site Settings → Steadfast.';
            return $isAjax
                ? response()->json(['ok' => false, 'message' => $msg], 422)
                : back()->with('error', $msg);
        }

        if ($order->isSentToSteadfast()) {
            $msg = 'This order was already sent to Steadfast. Tracking: ' . $order->steadfast_tracking_code;
            return $isAjax
                ? response()->json(['ok' => false, 'message' => $msg], 422)
                : back()->with('error', $msg);
        }

        $order->load('items');

        $shippingAddress = trim(implode(', ', array_filter([
            $order->shipping_address,
            $order->shipping_area,
            $order->shipping_city,
        ])));

        $payload = [
            'invoice'           => $order->order_no,
            'recipient_name'    => $order->shipping_name,
            'recipient_phone'   => $order->shipping_phone,
            'recipient_address' => $shippingAddress,
            'cod_amount'        => (float) $order->total,
            'note'              => $order->notes ?? '',
            'item_description'  => $order->items->pluck('product_name')->implode(', '),
        ];

        $result = $this->steadfast->placeOrder($payload);

        if (!($result['_ok'] ?? false)) {
            $httpCode = $result['_http_status'] ?? 0;
            $msg = $result['message'] ?? "Steadfast error (HTTP {$httpCode})";

            if ($httpCode === 401) {
                $msg = 'Steadfast account is not activated for API access. Please activate your merchant account at steadfast.com.bd.';
            }

            return $isAjax
                ? response()->json(['ok' => false, 'message' => $msg], 422)
                : back()->with('error', $msg);
        }

        $consignment = $result['consignment'] ?? [];

        $order->update([
            'steadfast_consignment_id' => (string) ($consignment['consignment_id'] ?? ''),
            'steadfast_tracking_code'  => $consignment['tracking_code'] ?? null,
            'steadfast_status'         => $consignment['status'] ?? 'in_review',
            'steadfast_sent_at'        => now(),
            'status'                   => in_array($order->status, ['shipped', 'delivered']) ? $order->status : 'shipped',
        ]);

        $trackingCode = $consignment['tracking_code'] ?? 'N/A';
        $consignmentId = $consignment['consignment_id'] ?? '';

        return $isAjax
            ? response()->json([
                'ok'             => true,
                'message'        => 'Order sent to Steadfast!',
                'tracking_code'  => $trackingCode,
                'consignment_id' => $consignmentId,
                'status'         => $consignment['status'] ?? 'in_review',
                'sent_at'        => now()->diffForHumans(),
            ])
            : back()->with('success', "Order sent to Steadfast! Tracking: {$trackingCode}");
    }

    /**
     * Refresh Steadfast delivery status.
     */
    public function checkStatus(Request $request, Order $order)
    {
        $isAjax = $request->ajax() || $request->wantsJson();

        if (!$this->steadfast->isConfigured()) {
            $msg = 'Steadfast API credentials are not configured.';
            return $isAjax ? response()->json(['ok' => false, 'message' => $msg], 422) : back()->with('error', $msg);
        }

        if (!$order->isSentToSteadfast()) {
            $msg = 'This order has not been sent to Steadfast yet.';
            return $isAjax ? response()->json(['ok' => false, 'message' => $msg], 422) : back()->with('error', $msg);
        }

        $result = $this->steadfast->statusByConsignmentId($order->steadfast_consignment_id);

        if (!($result['_ok'] ?? false)) {
            $msg = $result['message'] ?? 'Could not fetch status.';
            return $isAjax ? response()->json(['ok' => false, 'message' => $msg], 422) : back()->with('error', $msg);
        }

        $deliveryStatus = strtolower((string) ($result['delivery_status'] ?? $result['consignment']['status'] ?? ''));

        if ($deliveryStatus !== '') {
            $updates = ['steadfast_status' => $deliveryStatus];

            if (in_array($deliveryStatus, ['delivered', 'delivered_approval_pending', 'partial_delivered', 'partial_delivered_approval_pending']) && $order->status !== 'delivered') {
                $updates['status'] = 'delivered';
                if ($order->payment_method === 'cod') $updates['payment_status'] = 'paid';
            }

            if (in_array($deliveryStatus, ['cancelled', 'cancelled_approval_pending']) && !in_array($order->status, ['cancelled', 'returned'])) {
                $updates['status'] = 'cancelled';
            }

            $order->update($updates);
        } else {
            $deliveryStatus = null;
        }

        $msg = 'Status: ' . str_replace('_', ' ', $deliveryStatus ?? 'unknown');
        return $isAjax
            ? response()->json(['ok' => true, 'message' => $msg, 'status' => $deliveryStatus])
            : back()->with('success', 'Steadfast status updated: ' . ($deliveryStatus ?? 'unknown'));
    }

    /**
     * Return Steadfast account balance as JSON.
     */
    public function balance()
    {
        if (!$this->steadfast->isConfigured()) {
            return response()->json(['error' => 'Not configured'], 422);
        }

        $result = $this->steadfast->getBalance();

        if (!($result['_ok'] ?? false)) {
            return response()->json(['error' => $result['message'] ?? 'Failed'], 422);
        }

        return response()->json([
            'current_balance'   => $result['current_balance'] ?? $result['balance'] ?? 0,
            'withdrawal_amount' => $result['withdrawal_amount'] ?? null,
        ]);
    }

    /**
     * Webhook endpoint — Steadfast posts delivery updates here.
     */
    public function webhook(Request $request)
    {
        // Verify Bearer token if configured
        $configuredToken = SiteSetting::where('key', 'steadfast_webhook_token')->value('value');
        if ($configuredToken) {
            $bearer = $request->bearerToken();
            if ($bearer !== $configuredToken) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }

        $invoice       = $request->input('invoice');
        $consignmentId = $request->input('consignment_id');
        $status        = strtolower((string) $request->input('status', ''));

        if (!$invoice && !$consignmentId) {
            return response()->json(['status' => 'success', 'message' => 'Webhook received successfully.']);
        }

        // Find the order
        $order = $invoice
            ? Order::where('order_no', $invoice)->first()
            : Order::where('steadfast_consignment_id', (string) $consignmentId)->first();

        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Invalid consignment ID.'], 404);
        }

        // Update Steadfast status (delivery_status notifications only — tracking_update has no status field)
        if ($status !== '') {
            $updates = ['steadfast_status' => $status];

            if (in_array($status, ['delivered', 'delivered_approval_pending', 'partial_delivered', 'partial_delivered_approval_pending']) && $order->status !== 'delivered') {
                $updates['status'] = 'delivered';
                if ($order->payment_method === 'cod') $updates['payment_status'] = 'paid';
            }

            if (in_array($status, ['cancelled', 'cancelled_approval_pending']) && !in_array($order->status, ['cancelled', 'returned'])) {
                $updates['status'] = 'cancelled';
            }

            $order->update($updates);

            if ($order->customer) {
                $order->customer->recalculateStats();
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Webhook received successfully.']);
    }
}
