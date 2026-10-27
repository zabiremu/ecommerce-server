<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GRNReturnItem;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Services\ProfitReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Supplier dues — how much was bought from each supplier and how much is
 * still unpaid. Due = purchased (non-cancelled) − returned (GRN returns) − paid.
 */
class SupplierDueController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('s', ''));
        $filter = $request->query('filter') === 'due' ? 'due' : 'all';

        $query = self::withTotals(Supplier::query())
            ->where(fn ($q) => $q->where('pu.purchased', '>', 0)->orWhere('pa.paid', '>', 0));

        if ($search !== '') {
            $query->where(fn ($q) => $q->where('suppliers.name', 'like', "%{$search}%")
                ->orWhere('suppliers.phone', 'like', "%{$search}%")
                ->orWhere('suppliers.company', 'like', "%{$search}%"));
        }

        $summaryRows = (clone $query)->get();
        $summary = [
            'purchased' => (float) $summaryRows->sum('purchased'),
            'returned'  => (float) $summaryRows->sum('returned'),
            'paid'      => (float) $summaryRows->sum('paid'),
            'due'       => (float) $summaryRows->sum(fn ($s) => max(0, (float) $s->due)),
            'suppliers' => $summaryRows->filter(fn ($s) => (float) $s->due > 0.009)->count(),
        ];

        if ($filter === 'due') {
            $query->whereRaw(self::DUE_SQL . ' > 0.009');
        }

        $suppliers = $query->orderByRaw(self::DUE_SQL . ' desc')->paginate(25)->withQueryString();

        return view('Admin.supplier_dues.index', compact('suppliers', 'summary', 'search', 'filter'));
    }

    public function show(Supplier $supplier)
    {
        $totals = self::withTotals(Supplier::query())->where('suppliers.id', $supplier->id)->first();

        $purchases = $supplier->purchases()
            ->withSum('payments as paid_total', 'amount')
            ->orderByDesc('purchase_date')->orderByDesc('id')
            ->get();
        $returns = $supplier->grnReturns()->withSum('items as return_total', 'total')
            ->orderByDesc('return_date')->get();
        $payments = $supplier->payments()->with('purchase:id,invoice_no', 'paidBy:id,name')->get();
        $methods = SupplierPayment::METHODS;
        $today = ProfitReportService::today();

        return view('Admin.supplier_dues.show', compact('supplier', 'totals', 'purchases', 'returns', 'payments', 'methods', 'today'));
    }

    public function pay(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'amount'         => 'required|numeric|min:0.01|max:9999999999',
            'payment_method' => 'required|in:' . implode(',', SupplierPayment::METHODS),
            'paid_on'        => 'required|date_format:Y-m-d',
            'purchase_id'    => 'nullable|integer',
            'note'           => 'nullable|string|max:500',
        ]);

        if (!empty($data['purchase_id']) && !$supplier->purchases()->whereKey($data['purchase_id'])->exists()) {
            return back()->withInput()->withErrors(['purchase_id' => 'That purchase is not from this supplier.']);
        }

        SupplierPayment::create($data + [
            'supplier_id' => $supplier->id,
            'paid_by'     => Auth::guard('admin')->id(),
        ]);

        return redirect()->route('admin.supplier-dues.show', $supplier)
            ->with('success', 'Paid ' . \App\Support\Money::format($data['amount']) . ' to ' . $supplier->name . '.');
    }

    public function destroyPayment(Supplier $supplier, SupplierPayment $payment)
    {
        abort_unless($payment->supplier_id === $supplier->id, 404);
        $payment->delete();

        return redirect()->route('admin.supplier-dues.show', $supplier)->with('success', 'Payment removed.');
    }

    private const DUE_SQL = '(coalesce(pu.purchased, 0) - coalesce(re.returned, 0) - coalesce(pa.paid, 0))';

    /** Adds purchased / returned / paid / due columns to a suppliers query. */
    public static function withTotals($query)
    {
        $purchased = Purchase::query()->where('status', '!=', 'cancelled')
            ->groupBy('supplier_id')->selectRaw('supplier_id, sum(total_amount) as purchased, count(*) as purchase_count, max(purchase_date) as last_purchase');
        $returned = GRNReturnItem::query()->join('grn_returns', 'grn_returns.id', '=', 'grn_return_items.grn_return_id')
            ->groupBy('grn_returns.supplier_id')->selectRaw('grn_returns.supplier_id, sum(grn_return_items.total) as returned');
        $paid = SupplierPayment::query()
            ->groupBy('supplier_id')->selectRaw('supplier_id, sum(amount) as paid, max(paid_on) as last_paid');

        return $query
            ->leftJoinSub($purchased, 'pu', 'pu.supplier_id', '=', 'suppliers.id')
            ->leftJoinSub($returned, 're', 're.supplier_id', '=', 'suppliers.id')
            ->leftJoinSub($paid, 'pa', 'pa.supplier_id', '=', 'suppliers.id')
            ->select('suppliers.*')
            ->selectRaw('coalesce(pu.purchased, 0) as purchased, coalesce(pu.purchase_count, 0) as purchase_count, pu.last_purchase,
                coalesce(re.returned, 0) as returned, coalesce(pa.paid, 0) as paid, pa.last_paid, ' . self::DUE_SQL . ' as due');
    }
}
