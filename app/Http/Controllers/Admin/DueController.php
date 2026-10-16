<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\DealsBanner;
use App\Models\DuePayment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Customer dues — who took goods on credit from the POS, how much they still
 * owe, and collecting it. Collections are applied oldest sale first.
 */
class DueController extends Controller
{
    public const COLLECT_METHODS = ['cash', 'bkash', 'nagad', 'rocket', 'card', 'bank'];

    public function index(Request $request)
    {
        $search = trim((string) $request->query('s', ''));
        $filter = $request->query('filter') === 'overdue' ? 'overdue' : 'all';
        $today  = now(DealsBanner::LOCAL_TZ)->toDateString();

        // One row per customer with an open due.
        $dueRows = Order::query()->withOpenDue()->whereNotNull('customer_id')
            ->groupBy('customer_id')
            ->selectRaw('customer_id,
                sum(due_amount) as due_total,
                count(*) as due_sales,
                min(due_date) as oldest_due_date,
                max(placed_at) as last_sale_at,
                sum(case when due_date < ? then due_amount else 0 end) as overdue_total', [$today]);

        $query = Customer::query()
            ->joinSub($dueRows, 'd', 'd.customer_id', '=', 'customers.id')
            ->select('customers.*', 'd.due_total', 'd.due_sales', 'd.oldest_due_date', 'd.last_sale_at', 'd.overdue_total');

        if ($search !== '') {
            $query->where(fn ($q) => $q->where('customers.name', 'like', "%{$search}%")
                ->orWhere('customers.phone', 'like', "%{$search}%"));
        }
        if ($filter === 'overdue') {
            $query->where('d.overdue_total', '>', 0);
        }

        $customers = $query->orderByDesc('d.due_total')->paginate(25)->withQueryString();

        $openDue = Order::query()->withOpenDue();
        $summary = [
            'total'       => (float) (clone $openDue)->sum('due_amount'),
            'customers'   => (int) (clone $openDue)->whereNotNull('customer_id')->distinct('customer_id')->count('customer_id'),
            'overdue'     => (float) (clone $openDue)->where('due_date', '<', $today)->sum('due_amount'),
            'collected'   => (float) DuePayment::where('paid_at', '>=', now(DealsBanner::LOCAL_TZ)->startOfMonth()->utc())->sum('amount'),
        ];

        return view('Admin.dues.index', compact('customers', 'summary', 'search', 'filter'));
    }

    public function show(Customer $customer)
    {
        $dueOrders = Order::query()->where('customer_id', $customer->id)->withOpenDue()
            ->orderBy('placed_at')->get();
        $payments = $customer->duePayments()->with('order:id,order_no', 'receivedBy:id,name')->limit(50)->get();
        $outstanding = (float) $dueOrders->sum('due_amount');
        $methods = self::COLLECT_METHODS;

        return view('Admin.dues.show', compact('customer', 'dueOrders', 'payments', 'outstanding', 'methods'));
    }

    public function collect(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'amount'         => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:' . implode(',', self::COLLECT_METHODS),
            'note'           => 'nullable|string|max:500',
        ]);

        $amount = round((float) $data['amount'], 2);

        $applied = DB::transaction(function () use ($customer, $data, $amount) {
            $orders = Order::query()->where('customer_id', $customer->id)->withOpenDue()
                ->orderBy('placed_at')->orderBy('id')->lockForUpdate()->get();

            $outstanding = round((float) $orders->sum('due_amount'), 2);
            if ($amount > $outstanding + 0.001) {
                return null;
            }

            // Oldest sale first.
            $left = $amount;
            foreach ($orders as $order) {
                if ($left <= 0) break;
                $pay = min($left, (float) $order->due_amount);
                $newDue = round((float) $order->due_amount - $pay, 2);

                $order->update([
                    'due_amount'     => $newDue,
                    'paid_amount'    => round((float) $order->paid_amount + $pay, 2),
                    'payment_status' => $newDue > 0 ? 'partial' : 'paid',
                ]);

                DuePayment::create([
                    'customer_id'    => $customer->id,
                    'order_id'       => $order->id,
                    'amount'         => $pay,
                    'payment_method' => $data['payment_method'],
                    'note'           => $data['note'] ?? null,
                    'received_by'    => Auth::guard('admin')->id(),
                    'paid_at'        => now(),
                ]);

                $left = round($left - $pay, 2);
            }

            return $amount;
        });

        if ($applied === null) {
            return back()->withInput()->withErrors(['amount' => 'Amount is more than the customer owes.']);
        }

        return redirect()->route('admin.dues.show', $customer)
            ->with('success', 'Collected ' . \App\Support\Money::format($applied) . ' from ' . $customer->name . '.');
    }
}
