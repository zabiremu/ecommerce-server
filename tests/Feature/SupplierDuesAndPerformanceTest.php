<?php

namespace Tests\Feature;

use App\Models\GoodsReceivedNote;
use App\Models\GRNReturn;
use App\Models\GRNReturnItem;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\Warehouse;
use App\Services\ProfitReportService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesOrders;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class SupplierDuesAndPerformanceTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesOrders;
    use CreatesProducts;

    private Supplier $supplier;
    private Warehouse $warehouse;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
        $this->supplier = Supplier::create(['name' => 'Dhaka Textiles', 'status' => true]);
        $this->warehouse = Warehouse::create(['name' => 'Main', 'slug' => 'main-' . uniqid(), 'status' => true]);
    }

    private function purchase(float $total, string $status = 'completed'): Purchase
    {
        return Purchase::create([
            'supplier_id' => $this->supplier->id, 'warehouse_id' => $this->warehouse->id,
            'invoice_no' => 'PUR-' . uniqid(), 'purchase_date' => '2026-03-05',
            'total_amount' => $total, 'status' => $status,
        ]);
    }

    private function returnToSupplier(Purchase $purchase, float $amount): void
    {
        $item = $purchase->items()->create(['product_name' => 'Shirt', 'quantity' => 10, 'unit_cost' => 100, 'total' => 1000]);
        $grn = GoodsReceivedNote::create([
            'grn_no' => 'GRN-' . uniqid(), 'purchase_id' => $purchase->id, 'supplier_id' => $this->supplier->id,
            'warehouse_id' => $this->warehouse->id, 'received_date' => '2026-03-06',
        ]);
        $grnItem = $grn->items()->create([
            'purchase_item_id' => $item->id, 'product_name' => 'Shirt', 'ordered_qty' => 10, 'received_qty' => 10, 'unit_cost' => 100, 'total' => 1000,
        ]);
        $return = GRNReturn::create([
            'return_no' => 'RET-' . uniqid(), 'goods_received_note_id' => $grn->id, 'supplier_id' => $this->supplier->id,
            'warehouse_id' => $this->warehouse->id, 'return_date' => '2026-03-07',
        ]);
        GRNReturnItem::create([
            'grn_return_id' => $return->id, 'grn_item_id' => $grnItem->id, 'product_name' => 'Shirt',
            'received_qty' => 10, 'return_qty' => 1, 'unit_cost' => $amount, 'total' => $amount,
        ]);
    }

    public function test_supplier_due_is_purchased_minus_returned_minus_paid(): void
    {
        $p = $this->purchase(10000);
        $this->purchase(5000, 'cancelled');   // not counted
        $this->returnToSupplier($p, 1000);
        SupplierPayment::create(['supplier_id' => $this->supplier->id, 'amount' => 4000, 'payment_method' => 'cash', 'paid_on' => '2026-03-08']);

        $this->get('/admin/supplier-dues')->assertOk()->assertSee('Dhaka Textiles')->assertSee('৳5,000.00');
        $this->get("/admin/supplier-dues/{$this->supplier->id}")->assertOk()->assertSee('৳5,000.00');
    }

    public function test_paying_a_supplier_records_payment_and_can_be_removed(): void
    {
        $p = $this->purchase(3000);

        $this->post("/admin/supplier-dues/{$this->supplier->id}/pay", [
            'amount' => 1200, 'payment_method' => 'bkash', 'paid_on' => '2026-03-09', 'purchase_id' => $p->id,
        ])->assertRedirect("/admin/supplier-dues/{$this->supplier->id}");

        $payment = SupplierPayment::firstOrFail();
        $this->assertEquals(1200, (float) $payment->amount);
        $this->assertSame($p->id, $payment->purchase_id);

        $other = Supplier::create(['name' => 'Other', 'status' => true]);
        $otherPurchase = Purchase::create(['supplier_id' => $other->id, 'warehouse_id' => $this->warehouse->id, 'invoice_no' => 'X-1', 'purchase_date' => '2026-03-01', 'total_amount' => 1, 'status' => 'completed']);
        $this->post("/admin/supplier-dues/{$this->supplier->id}/pay", [
            'amount' => 10, 'payment_method' => 'cash', 'paid_on' => '2026-03-09', 'purchase_id' => $otherPurchase->id,
        ])->assertSessionHasErrors('purchase_id');

        $this->delete("/admin/supplier-dues/{$this->supplier->id}/payments/{$payment->id}")->assertRedirect();
        $this->assertSame(0, SupplierPayment::count());
    }

    public function test_purchase_with_paid_now_creates_a_payment(): void
    {
        $product = $this->makeProduct();

        $this->post('/admin/purchases', [
            'supplier_id' => $this->supplier->id, 'warehouse_id' => $this->warehouse->id, 'purchase_date' => '2026-03-10',
            'paid_amount' => 700, 'payment_method' => 'cash',
            'items' => [['product_id' => $product->id, 'quantity' => 4, 'unit_cost' => 500]],
        ])->assertRedirect();

        $payment = SupplierPayment::firstOrFail();
        $this->assertEquals(700, (float) $payment->amount);
        $this->assertSame('2026-03-10', $payment->paid_on->toDateString());
        $this->get('/admin/purchases/' . $payment->purchase_id)->assertOk()->assertSee('৳1,300.00'); // unpaid
    }

    public function test_returns_and_discounts_report(): void
    {
        $today = ProfitReportService::today();
        $this->makeOrderFor($this->makeProduct(), ['status' => 'delivered', 'discount' => 100, 'total' => 960]);
        $this->makeOrderFor($this->makeProduct(), ['status' => 'returned', 'payment_status' => 'refunded']);
        $this->makeOrderFor($this->makeProduct(), ['status' => 'cancelled']);

        $r = app(ProfitReportService::class)->returnsAndDiscounts($today, $today);

        $this->assertEquals(100, $r['discount']);
        $this->assertSame(1, $r['discount_orders']);
        $this->assertEquals(1060, $r['gross']);
        $this->assertEquals(['orders' => 1, 'amount' => 1060.0], $r['returned']);
        $this->assertEquals(['orders' => 1, 'amount' => 1060.0], $r['cancelled']);
        $this->assertEquals(1060, $r['refunded']);
        $this->assertCount(1, $r['products']->where('returned_qty', '>', 0));

        $this->get('/admin/accounts/returns')->assertOk()->assertSee('Returns &amp; Discounts', false);
    }

    public function test_performance_ranks_products_and_lists_slow_movers(): void
    {
        $shirts = $this->makeCategory(['name' => 'Shirt']);
        $pants  = $this->makeCategory(['name' => 'Pant']);
        $good = $this->makeProduct(['name' => 'Oxford Shirt', 'category_id' => $shirts->id, 'purchase_price' => 300, 'selling_price' => 1000]);
        $weak = $this->makeProduct(['name' => 'Chino Pant', 'category_id' => $pants->id, 'purchase_price' => 900, 'selling_price' => 1000]);
        $this->makeOrderFor($good, ['status' => 'delivered']);
        $this->makeOrderFor($weak, ['status' => 'delivered']);

        $stale = $this->makeProduct(['name' => 'Old Jacket', 'stock' => 7, 'purchase_price' => 200]);
        Product::whereKey($stale->id)->update(['created_at' => now()->subDays(120)]);
        $this->makeOrderFor($stale, ['status' => 'delivered', 'placed_at' => now()->subDays(100)]);

        $response = $this->get('/admin/accounts/performance');
        $response->assertOk();
        $best = $response->viewData('best');
        $this->assertSame('Oxford Shirt', $best->first()->name);
        $this->assertSame('Shirt', $best->first()->category);
        $this->assertSame('Chino Pant', $response->viewData('low')->first()->name);
        $this->assertSame(['Old Jacket'], $response->viewData('slow')->pluck('name')->all());
        $this->assertEquals(1400, $response->viewData('slowSummary')['value']);

        $filtered = $this->get('/admin/accounts/performance?category=' . $pants->id);
        $this->assertSame(['Chino Pant'], $filtered->viewData('best')->pluck('name')->all());
    }

    public function test_staff_without_permission_cannot_open_supplier_dues(): void
    {
        $role = Role::create(['name' => 'Cashier', 'permissions' => ['pos.view']]);
        $this->actingAsAdmin(['role_id' => $role->id]);

        $this->get('/admin/supplier-dues')->assertForbidden();
        $this->post("/admin/supplier-dues/{$this->supplier->id}/pay", [])->assertForbidden();
        $this->get('/admin/accounts/performance')->assertForbidden();
    }
}
