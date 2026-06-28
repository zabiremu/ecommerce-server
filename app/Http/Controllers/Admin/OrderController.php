<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Services\AdminNotificationService;
use App\Services\BdCourierFraudService;
use App\Services\PhoneAnalysisService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status   = $request->query('status', 'all');
        $search   = trim((string) $request->query('s', ''));
        $payment  = $request->query('payment_status');

        $query = Order::with('customer', 'items')->latest('id');

        if (in_array($status, Order::STATUSES, true)) {
            $query->where('status', $status);
        }

        if (in_array($payment, Order::PAYMENT_STATUSES, true)) {
            $query->where('payment_status', $payment);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('order_no', 'like', "%{$search}%")
                  ->orWhere('shipping_name', 'like', "%{$search}%")
                  ->orWhere('shipping_phone', 'like', "%{$search}%")
                  ->orWhere('shipping_email', 'like', "%{$search}%");
            });
        }

        $perPage = in_array((int) $request->query('per_page'), [25, 50, 100], true)
            ? (int) $request->query('per_page')
            : 25;

        $orders = $query->paginate($perPage)->withQueryString();

        $counts = [
            'all'        => Order::count(),
            'pending'    => Order::where('status', 'pending')->count(),
            'confirmed'  => Order::where('status', 'confirmed')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped'    => Order::where('status', 'shipped')->count(),
            'delivered'  => Order::where('status', 'delivered')->count(),
            'cancelled'  => Order::where('status', 'cancelled')->count(),
            'returned'   => Order::where('status', 'returned')->count(),
        ];

        $totals = [
            'revenue' => (float) Order::whereIn('status', ['delivered'])->sum('total'),
            'pending_revenue' => (float) Order::whereNotIn('status', ['delivered', 'cancelled', 'returned'])->sum('total'),
        ];

        return view('Admin.order.index', compact('orders', 'counts', 'totals', 'status', 'search', 'payment', 'perPage'));
    }

    public function show(Order $order)
    {
        $order->load('customer', 'items.product');
        $availableStatuses = Order::STATUSES;
        $paymentStatuses   = Order::PAYMENT_STATUSES;
        $phoneAnalysis     = (new PhoneAnalysisService())->analyze($order->shipping_phone);
        return view('Admin.order.show', compact('order', 'availableStatuses', 'paymentStatuses', 'phoneAnalysis'));
    }

    public function bdcourierCheck(Order $order)
    {
        if (!BdCourierFraudService::isEnabled()) {
            return response()->json(['ok' => false, 'message' => 'BD Courier API key not configured.'], 422);
        }

        $result = (new BdCourierFraudService())->check($order->shipping_phone);

        if ($result === null) {
            $order->update([
                'bdcourier_success_ratio' => null,
                'bdcourier_total_parcels' => 0,
                'bdcourier_fraud_reports' => 0,
                'bdcourier_data'          => null,
            ]);
            return response()->json(['ok' => true, 'found' => false]);
        }

        $order->update([
            'bdcourier_success_ratio' => $result['success_ratio'],
            'bdcourier_total_parcels' => $result['total_parcels'],
            'bdcourier_fraud_reports' => $result['fraud_reports'],
            'bdcourier_data'          => $result,
        ]);

        return response()->json(['ok' => true, 'found' => true, 'data' => $result]);
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', Order::STATUSES),
        ]);

        $newStatus = $request->status;
        $oldStatus = $order->status;

        if ($newStatus === $oldStatus) {
            return back()->with('success', 'Status unchanged.');
        }

        DB::transaction(function () use ($order, $newStatus, $oldStatus) {
            // Stock management:
            // - Moving INTO an active state (confirmed/processing/shipped/delivered) AND stock not yet deducted → deduct
            // - Moving INTO cancelled/returned AND stock was deducted → restore
            $activeStates = ['confirmed', 'processing', 'shipped', 'delivered'];
            $reverseStates = ['cancelled', 'returned'];

            if (in_array($newStatus, $activeStates, true) && !$order->stock_deducted) {
                $this->deductStock($order);
                $order->stock_deducted = true;
            }

            if (in_array($newStatus, $reverseStates, true) && $order->stock_deducted) {
                $this->restoreStock($order);
                $order->stock_deducted = false;
            }

            $order->status = $newStatus;
            // Auto-mark COD orders as paid when delivered
            if ($newStatus === 'delivered' && $order->payment_method === 'cod' && $order->payment_status === 'unpaid') {
                $order->payment_status = 'paid';
            }
            $order->save();

            if ($order->customer) {
                $order->customer->recalculateStats();
            }
        });

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'status' => $newStatus]);
        }

        return back()->with('success', "Order status changed from {$oldStatus} to {$newStatus}.");
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:' . implode(',', Order::PAYMENT_STATUSES),
        ]);

        $order->update(['payment_status' => $request->payment_status]);
        return back()->with('success', 'Payment status updated.');
    }

    public function updateNotes(Request $request, Order $order)
    {
        $request->validate(['admin_notes' => 'nullable|string|max:1000']);
        $order->update(['admin_notes' => $request->admin_notes]);
        return back()->with('success', 'Notes saved.');
    }

    public function destroy(Order $order)
    {
        DB::transaction(function () use ($order) {
            if ($order->stock_deducted) {
                $this->restoreStock($order);
            }
            $customer = $order->customer;
            $order->delete();
            if ($customer) {
                $customer->recalculateStats();
            }
        });

        return redirect()->route('admin.orders.index')->with('success', 'Order deleted.');
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:' . implode(',', array_merge(Order::STATUSES, ['delete'])),
            'ids'    => 'required|array|min:1',
            'ids.*'  => 'integer|exists:orders,id',
        ]);

        $ids = $request->ids;

        if ($request->action === 'delete') {
            $orders = Order::whereIn('id', $ids)->get();
            foreach ($orders as $o) {
                $this->destroyInternal($o);
            }
            return back()->with('success', count($ids) . ' order(s) deleted.');
        }

        $orders = Order::whereIn('id', $ids)->get();
        foreach ($orders as $o) {
            $this->changeStatusInternal($o, $request->action);
        }

        return back()->with('success', count($ids) . ' order(s) updated to ' . $request->action . '.');
    }

    // ---- Helpers ----

    protected function deductStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if (!$item->product_id) continue;
            $product = Product::find($item->product_id);
            if (!$product) continue;
            $qty      = (float) $item->quantity;
            $newStock = max(0, ((float) $product->stock) - $qty);
            $product->update(['stock' => $newStock]);

            $alert = (int) ($product->alert_quantity ?? 5);
            if ($newStock <= $alert && $newStock >= 0) {
                AdminNotificationService::lowStock($product->name, (int) $newStock, $product->id);
            }
        }
    }

    protected function restoreStock(Order $order): void
    {
        foreach ($order->items as $item) {
            if (!$item->product_id) continue;
            $product = Product::find($item->product_id);
            if (!$product) continue;
            $product->increment('stock', (float) $item->quantity);
        }
    }

    protected function changeStatusInternal(Order $order, string $newStatus): void
    {
        if ($order->status === $newStatus) return;

        DB::transaction(function () use ($order, $newStatus) {
            $activeStates = ['confirmed', 'processing', 'shipped', 'delivered'];
            $reverseStates = ['cancelled', 'returned'];

            if (in_array($newStatus, $activeStates, true) && !$order->stock_deducted) {
                $this->deductStock($order);
                $order->stock_deducted = true;
            }
            if (in_array($newStatus, $reverseStates, true) && $order->stock_deducted) {
                $this->restoreStock($order);
                $order->stock_deducted = false;
            }

            $order->status = $newStatus;
            if ($newStatus === 'delivered' && $order->payment_method === 'cod' && $order->payment_status === 'unpaid') {
                $order->payment_status = 'paid';
            }
            $order->save();

            if ($order->customer) {
                $order->customer->recalculateStats();
            }
        });
    }

    protected function destroyInternal(Order $order): void
    {
        DB::transaction(function () use ($order) {
            if ($order->stock_deducted) {
                $this->restoreStock($order);
            }
            $customer = $order->customer;
            $order->delete();
            if ($customer) {
                $customer->recalculateStats();
            }
        });
    }
}
