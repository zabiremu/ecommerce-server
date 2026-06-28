<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Warehouse;

class StockReportController extends Controller
{
    public function index()
    {
        $products = Product::with('warehouses', 'category')
            ->where('type', 'physical')
            ->orderBy('name')
            ->get();
        $warehouses = Warehouse::where('status', true)->orderBy('name')->get();
        return view('Admin.stock_report.index', compact('products', 'warehouses'));
    }
}
