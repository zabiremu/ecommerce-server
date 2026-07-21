<?php

namespace Tests\Feature;

use App\Models\ProductWarehouse;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesOrders;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class AdminReportsTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesProducts;
    use CreatesOrders;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    public function test_sales_report_revenue_excludes_cancelled_and_returned_orders(): void
    {
        $product = $this->makeProduct(['selling_price' => 1000]);
        $this->makeOrderFor($product, ['status' => 'delivered', 'total' => 1000, 'placed_at' => now()]);
        $this->makeOrderFor($product, ['status' => 'cancelled', 'total' => 1000, 'placed_at' => now()]);
        $this->makeOrderFor($product, ['status' => 'pending', 'total' => 500, 'placed_at' => now()]);

        $response = $this->get('/admin/sales-report');

        $response->assertOk();
        $response->assertViewHas('totalOrders', 3);
        $response->assertViewHas('totalRevenue', 1500.0);
        $response->assertViewHas('deliveredRev', 1000.0);
    }

    public function test_sales_report_respects_date_range_filter(): void
    {
        $product = $this->makeProduct(['selling_price' => 1000]);
        $this->makeOrderFor($product, ['status' => 'delivered', 'total' => 1000, 'placed_at' => now()->subMonth()]);
        $this->makeOrderFor($product, ['status' => 'delivered', 'total' => 2000, 'placed_at' => now()]);

        $response = $this->get('/admin/sales-report?from=' . now()->startOfDay()->toDateString() . '&to=' . now()->toDateString());

        $response->assertOk();
        $response->assertViewHas('totalOrders', 1);
        $response->assertViewHas('totalRevenue', 2000.0);
    }

    public function test_stock_report_shows_per_warehouse_stock(): void
    {
        $product = $this->makeProduct(['type' => 'physical']);
        $warehouse = Warehouse::create(['name' => 'Main Warehouse']);
        ProductWarehouse::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'stock' => 15]);

        $response = $this->get('/admin/stock-report');

        $response->assertOk();
        $response->assertViewHas('products', function ($products) use ($product) {
            $found = $products->firstWhere('id', $product->id);
            return $found && $found->warehouses->first()->pivot->stock == 15;
        });
    }

    public function test_purchase_report_filters_by_supplier(): void
    {
        $supplierA = Supplier::create(['name' => 'Supplier A']);
        $supplierB = Supplier::create(['name' => 'Supplier B']);
        $warehouse = Warehouse::create(['name' => 'Main Warehouse']);

        Purchase::create([
            'supplier_id' => $supplierA->id, 'warehouse_id' => $warehouse->id,
            'invoice_no' => 'PUR-A', 'purchase_date' => now(), 'total_amount' => 1000, 'status' => 'pending',
        ]);
        Purchase::create([
            'supplier_id' => $supplierB->id, 'warehouse_id' => $warehouse->id,
            'invoice_no' => 'PUR-B', 'purchase_date' => now(), 'total_amount' => 500, 'status' => 'pending',
        ]);

        $response = $this->get('/admin/purchase-report?supplier_id=' . $supplierA->id);

        $response->assertOk();
        $response->assertViewHas('totalPurchases', 1);
        $response->assertViewHas('totalAmount', 1000.0);
    }

    public function test_customer_report_computes_period_spend_excluding_cancelled(): void
    {
        $product = $this->makeProduct(['selling_price' => 1000]);
        $customer = $this->makeCustomer();
        $this->makeOrderFor($product, ['customer' => $customer, 'customer_id' => $customer->id, 'status' => 'delivered', 'total' => 1000, 'placed_at' => now()]);
        $this->makeOrderFor($product, ['customer' => $customer, 'customer_id' => $customer->id, 'status' => 'cancelled', 'total' => 1000, 'placed_at' => now()]);

        $response = $this->get('/admin/customer-report');

        $response->assertOk();
        $response->assertViewHas('customers', function ($customers) use ($customer) {
            $found = $customers->firstWhere('id', $customer->id);
            return $found && (float) $found->period_spent === 1000.0 && (int) $found->period_orders === 1;
        });
    }
}
