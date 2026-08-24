<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductWarehouse;
use App\Models\Warehouse;
use App\Services\AdminNotificationService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $warehouses = Warehouse::where('status', true)->orderBy('name')->get();
        $categories = Category::where('status', true)->orderBy('name')->get(['id', 'name']);

        return view('Admin.pos.index', compact('warehouses', 'categories'));
    }

    public function products(Request $request)
    {
        $request->validate([
            'warehouse_id' => 'required|exists:warehouses,id',
            's'            => 'nullable|string|max:100',
            'category_id'  => 'nullable|exists:categories,id',
        ]);

        $warehouseId = (int) $request->warehouse_id;
        $search = trim((string) $request->query('s', ''));

        $query = Product::published()
            ->where('type', 'physical')
            ->with(['variants' => fn ($q) => $q->orderBy('sort_order')])
            ->when($request->filled('category_id'), fn ($q) => $q->where('category_id', $request->category_id))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($qq) use ($search) {
                    $qq->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('barcode', $search);
                });
            })
            ->orderBy('name');

        $products = $query->paginate(24)->withQueryString();

        $warehouseStocks = ProductWarehouse::where('warehouse_id', $warehouseId)
            ->whereIn('product_id', $products->pluck('id'))
            ->pluck('stock', 'product_id');

        $items = $products->getCollection()->map(function (Product $p) use ($warehouseStocks) {
            $hasSale = $p->sale_price && $p->sale_price < $p->selling_price;
            return [
                'id'         => $p->id,
                'name'       => $p->name,
                'sku'        => $p->sku,
                'barcode'    => $p->barcode,
                'thumbnail'  => $p->thumbnail ? asset('storage/' . $p->thumbnail) : null,
                'price'      => (float) ($hasSale ? $p->sale_price : $p->selling_price),
                'old_price'  => $hasSale ? (float) $p->selling_price : null,
                'stock'      => (float) ($warehouseStocks[$p->id] ?? 0),
                'type'       => $p->type,
                'variants'   => $p->variants->map(fn (ProductVariant $v) => [
                    'id'    => $v->id,
                    'label' => trim(implode(' / ', array_filter([$v->color, $v->size])) ?: $v->name),
                    'price' => (float) ($v->price > 0 ? $v->price : ($hasSale ? $p->sale_price : $p->selling_price)),
                    'stock' => (float) $v->stock,
                    'sku'   => $v->sku,
                ])->values(),
            ];
        })->values();

        return response()->json([
            'data'         => $items,
            'current_page' => $products->currentPage(),
            'last_page'    => $products->lastPage(),
        ]);
    }

    public function customers(Request $request)
    {
        $search = trim((string) $request->query('s', ''));
        if ($search === '') {
            return response()->json(['data' => []]);
        }

        $customers = Customer::query()
            ->where(function ($q) use ($search) {
                $q->where('phone', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%");
            })
            ->orderByDesc('total_orders')
            ->limit(10)
            ->get(['id', 'name', 'phone', 'email', 'address', 'city', 'area']);

        return response()->json(['data' => $customers]);
    }

    public function checkout(Request $request)
    {
        $data = $request->validate([
            'warehouse_id'        => 'required|exists:warehouses,id',
            'customer_name'       => 'required|string|max:255',
            'customer_phone'      => 'required|string|max:30',
            'customer_email'      => 'nullable|email|max:255',
            'customer_address'    => 'nullable|string|max:1000',
            'payment_method'      => 'required|in:' . implode(',', Order::PAYMENT_METHODS),
            'discount'            => 'nullable|numeric|min:0',
            'paid_amount'         => 'nullable|numeric|min:0',
            'notes'               => 'nullable|string|max:1000',
            'items'               => 'required|array|min:1',
            'items.*.product_id'  => 'required|integer|exists:products,id',
            'items.*.variant_id'  => 'nullable|integer|exists:product_variants,id',
            'items.*.quantity'    => 'required|numeric|min:0.01',
        ]);

        $warehouseId = (int) $data['warehouse_id'];
        $productIds = collect($data['items'])->pluck('product_id')->unique();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        $lineItems = [];
        $subtotal = 0;
        $stockErrors = [];

        foreach ($data['items'] as $item) {
            $product = $products->get($item['product_id']);
            if (!$product) continue;

            $variant = null;
            if (!empty($item['variant_id'])) {
                $variant = ProductVariant::where('id', $item['variant_id'])
                    ->where('product_id', $product->id)
                    ->first();
            }

            $hasSale = $product->sale_price && $product->sale_price < $product->selling_price;
            $unitPrice = (float) ($hasSale ? $product->sale_price : $product->selling_price);
            if ($variant && $variant->price > 0) {
                $unitPrice = (float) $variant->price;
            }

            $qty = (float) $item['quantity'];
            $lineTotal = $unitPrice * $qty;
            $subtotal += $lineTotal;

            if ($product->type === 'physical') {
                $pw = ProductWarehouse::where('product_id', $product->id)
                    ->where('warehouse_id', $warehouseId)
                    ->first();
                $available = $pw ? (float) $pw->stock : 0;
                if ($available < $qty) {
                    $stockErrors[] = "\"{$product->name}\" — only {$available} left in this warehouse (requested {$qty})";
                }
            }

            $lineItems[] = [
                'product'    => $product,
                'variant'    => $variant,
                'quantity'   => $qty,
                'unit_price' => $unitPrice,
                'total'      => $lineTotal,
            ];
        }

        if (empty($lineItems)) {
            return response()->json(['success' => false, 'message' => 'No valid items in the sale.'], 422);
        }

        if (!empty($stockErrors)) {
            return response()->json(['success' => false, 'message' => implode('; ', $stockErrors)], 422);
        }

        $discount = min((float) ($data['discount'] ?? 0), $subtotal);
        $total = max(0, $subtotal - $discount);
        $paidAmount = $data['paid_amount'] ?? $total;
        $changeDue = max(0, $paidAmount - $total);

        $order = DB::transaction(function () use ($data, $lineItems, $subtotal, $discount, $total, $paidAmount, $changeDue, $warehouseId) {
            $customer = Customer::firstOrNew(['phone' => $data['customer_phone']]);
            $isNewCustomer = !$customer->exists;
            $customer->fill([
                'name'    => $data['customer_name'],
                'email'   => $data['customer_email'] ?? $customer->email,
                'address' => $data['customer_address'] ?? $customer->address,
            ]);
            if ($isNewCustomer) {
                $customer->status = true;
            }
            $customer->save();

            $order = Order::create([
                'order_no'         => $this->nextPosOrderNumber(),
                'source'           => 'pos',
                'customer_id'      => $customer->id,
                'warehouse_id'     => $warehouseId,
                'served_by'        => Auth::guard('admin')->id(),
                'shipping_name'    => $data['customer_name'],
                'shipping_phone'   => $data['customer_phone'],
                'shipping_email'   => $data['customer_email'] ?? null,
                'shipping_address' => $data['customer_address'] ?? 'Walk-in / POS sale',
                'subtotal'         => $subtotal,
                'shipping_charge'  => 0,
                'discount'         => $discount,
                'total'            => $total,
                'paid_amount'      => $paidAmount,
                'change_due'       => $changeDue,
                'payment_method'   => $data['payment_method'],
                'payment_status'   => 'paid',
                'status'           => 'delivered',
                'notes'            => $data['notes'] ?? null,
                'stock_deducted'   => true,
                'placed_at'        => now(),
            ]);

            foreach ($lineItems as $li) {
                $product = $li['product'];
                $variant = $li['variant'];

                OrderItem::create([
                    'order_id'      => $order->id,
                    'product_id'    => $product->id,
                    'variant_id'    => $variant?->id,
                    'product_name'  => $product->name,
                    'variant_label' => $variant ? trim(implode(' / ', array_filter([$variant->color, $variant->size])) ?: $variant->name) : null,
                    'product_sku'   => $product->sku,
                    'variant_sku'   => $variant?->sku,
                    'thumbnail'     => $product->thumbnail,
                    'quantity'      => $li['quantity'],
                    'unit_price'    => $li['unit_price'],
                    'total'         => $li['total'],
                ]);

                if ($product->type === 'physical') {
                    $newStock = max(0, (float) $product->stock - $li['quantity']);
                    $product->update(['stock' => $newStock]);

                    $pw = ProductWarehouse::where('product_id', $product->id)
                        ->where('warehouse_id', $warehouseId)
                        ->first();
                    if ($pw) {
                        $pw->update(['stock' => max(0, (float) $pw->stock - $li['quantity'])]);
                    }

                    $alert = (int) ($product->alert_quantity ?? 5);
                    if ($newStock <= $alert) {
                        AdminNotificationService::lowStock($product->name, (int) $newStock, $product->id);
                    }
                }
            }

            $customer->recalculateStats();

            AdminNotificationService::newOrder($order->order_no, $data['customer_name'], $total);
            if ($isNewCustomer) {
                AdminNotificationService::newCustomer($data['customer_name'], $data['customer_phone']);
            }

            return $order;
        });

        return response()->json([
            'success'  => true,
            'order_no' => $order->order_no,
            'redirect' => route('admin.pos.receipt', $order),
        ]);
    }

    public function receipt(Order $order)
    {
        $order->load('items', 'customer', 'warehouse', 'servedBy');
        return view('Admin.pos.receipt', compact('order'));
    }

    protected function nextPosOrderNumber(): string
    {
        $prefix = 'POS-' . Carbon::now()->format('Ymd') . '-';
        do {
            $candidate = $prefix . str_pad((string) random_int(1000, 9999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('order_no', $candidate)->exists());
        return $candidate;
    }
}
