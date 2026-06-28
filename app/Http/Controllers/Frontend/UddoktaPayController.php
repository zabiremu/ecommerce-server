<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\SiteSetting;
use App\Services\UddoktaPayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UddoktaPayController extends Controller
{
    public function __construct(private UddoktaPayService $service) {}

    /**
     * Customer lands here after paying on UddoktaPay.
     * UddoktaPay adds ?invoice_id=xxx via GET.
     */
    public function callback(Request $request)
    {
        $invoiceId = $request->query('invoice_id');

        if (!$invoiceId) {
            return redirect()->route('home')
                ->with('error', 'Payment reference missing. Contact support if you were charged.');
        }

        try {
            $data = $this->service->verifyPayment($invoiceId);
        } catch (\Exception $e) {
            Log::error('UddoktaPay callback verify error', ['error' => $e->getMessage()]);
            return redirect()->route('home')
                ->with('error', 'Could not verify your payment. Please contact support.');
        }

        $orderNo = $data['metadata']['order_no'] ?? null;
        $order   = $orderNo ? Order::where('order_no', $orderNo)->first() : null;

        if ($order && ($data['status'] ?? '') === 'COMPLETED') {
            if ($order->payment_status === 'unpaid') {
                $order->update([
                    'payment_status'         => 'paid',
                    'uddoktapay_invoice_id'  => $invoiceId,
                ]);
            }
            return redirect(route('order-complete') . '?id=' . $order->order_no);
        }

        // Payment not completed yet – still redirect to order page (unpaid)
        if ($order) {
            $order->update(['uddoktapay_invoice_id' => $invoiceId]);
            return redirect(route('order-complete') . '?id=' . $order->order_no);
        }

        return redirect()->route('home')
            ->with('error', 'Payment processed but order not found. Contact support with invoice: ' . $invoiceId);
    }

    /**
     * Customer landed here after cancelling on UddoktaPay.
     */
    public function cancel(Request $request)
    {
        $orderNo = $request->query('order');
        $order   = $orderNo ? Order::where('order_no', $orderNo)->first() : null;

        if ($order) {
            return redirect(route('order-complete') . '?id=' . $order->order_no)
                ->with('warning', 'Payment was cancelled. Your order is saved — you can pay later.');
        }

        return redirect()->route('checkout')
            ->with('warning', 'Payment was cancelled.');
    }

    /**
     * UddoktaPay webhook — fires asynchronously when payment status changes.
     */
    public function webhook(Request $request)
    {
        $apiKey         = $request->header('RT-UDDOKTAPAY-API-KEY');
        $configuredKey  = SiteSetting::get('uddoktapay_api_key', config('uddoktapay.api_key', ''));

        if ($configuredKey && $apiKey !== $configuredKey) {
            Log::warning('UddoktaPay webhook: invalid API key');
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $data = $request->json()->all();

        if (empty($data)) {
            return response()->json(['message' => 'No data'], 400);
        }

        Log::info('UddoktaPay webhook received', ['invoice_id' => $data['invoice_id'] ?? null]);

        if (($data['status'] ?? '') !== 'COMPLETED') {
            return response()->json(['message' => 'Ignored: ' . ($data['status'] ?? 'unknown')]);
        }

        $orderNo = $data['metadata']['order_no'] ?? null;
        $order   = $orderNo ? Order::where('order_no', $orderNo)->first() : null;

        if (!$order) {
            Log::warning('UddoktaPay webhook: order not found', ['order_no' => $orderNo]);
            return response()->json(['message' => 'Order not found'], 404);
        }

        if ($order->payment_status === 'unpaid') {
            $order->update([
                'payment_status'        => 'paid',
                'uddoktapay_invoice_id' => $data['invoice_id'] ?? null,
            ]);
            Log::info('UddoktaPay webhook: order paid', ['order_no' => $orderNo]);
        }

        return response()->json(['message' => 'OK']);
    }
}
