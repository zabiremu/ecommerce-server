<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminSearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if (strlen($q) < 2) {
            return response()->json(['results' => []]);
        }

        $like = "%{$q}%";

        // Orders
        $orders = Order::where('order_no', 'like', $like)
            ->orWhere('shipping_name', 'like', $like)
            ->orWhere('shipping_phone', 'like', $like)
            ->latest('id')->limit(5)->get()
            ->map(fn ($o) => [
                'type'     => 'order',
                'icon'     => 'fa-receipt',
                'label'    => '#' . $o->order_no . ' — ' . $o->shipping_name,
                'meta'     => 'TK ' . number_format($o->total) . ' · ' . $o->status,
                'link'     => route('admin.orders.show', $o),
            ]);

        // Products
        $products = Product::where('name', 'like', $like)
            ->orWhere('sku', 'like', $like)
            ->latest('id')->limit(5)->get()
            ->map(fn ($p) => [
                'type'  => 'product',
                'icon'  => 'fa-box',
                'label' => $p->name,
                'meta'  => ($p->sku ? 'SKU: ' . $p->sku . ' · ' : '') . 'Stock: ' . (int) $p->stock,
                'link'  => route('admin.products.edit', $p),
            ]);

        // Customers
        $customers = Customer::where('name', 'like', $like)
            ->orWhere('phone', 'like', $like)
            ->orWhere('email', 'like', $like)
            ->latest('id')->limit(5)->get()
            ->map(fn ($c) => [
                'type'  => 'customer',
                'icon'  => 'fa-user',
                'label' => $c->name,
                'meta'  => $c->phone . ($c->email ? ' · ' . $c->email : ''),
                'link'  => route('admin.customers.show', $c),
            ]);

        $results = collect([
            ['group' => 'Orders',    'color' => 'text-emerald-600', 'items' => $orders],
            ['group' => 'Products',  'color' => 'text-blue-600',    'items' => $products],
            ['group' => 'Customers', 'color' => 'text-violet-600',  'items' => $customers],
        ])->filter(fn ($g) => $g['items']->isNotEmpty())->values();

        return response()->json(['results' => $results]);
    }
}
