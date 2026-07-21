<?php

namespace Tests\Feature;

use App\Models\GoodsReceivedNote;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class AdminPurchaseGrnTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesProducts;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    public function test_admin_can_create_a_purchase_with_items(): void
    {
        $product = $this->makeProduct(['purchase_price' => 500]);
        $supplier = Supplier::create(['name' => 'Acme Supplies']);
        $warehouse = Warehouse::create(['name' => 'Main Warehouse']);

        $response = $this->post('/admin/purchases', [
            'supplier_id'   => $supplier->id,
            'warehouse_id'  => $warehouse->id,
            'purchase_date' => now()->toDateString(),
            'items'         => [
                ['product_id' => $product->id, 'quantity' => 10, 'unit_cost' => 400],
            ],
        ]);

        $purchase = Purchase::first();
        $response->assertRedirect(route('admin.purchases.show', $purchase));
        $this->assertSame(4000.0, (float) $purchase->total_amount);
        $this->assertSame('pending', $purchase->status);
        $this->assertSame(1, $purchase->items()->count());
    }

    public function test_receiving_a_grn_increases_product_and_warehouse_stock(): void
    {
        $product = $this->makeProduct(['stock' => 0]);
        $supplier = Supplier::create(['name' => 'Acme Supplies']);
        $warehouse = Warehouse::create(['name' => 'Main Warehouse']);

        $purchase = Purchase::create([
            'supplier_id' => $supplier->id, 'warehouse_id' => $warehouse->id,
            'invoice_no' => 'PUR-TEST-1', 'purchase_date' => now(), 'total_amount' => 4000, 'status' => 'completed',
        ]);
        $purchaseItem = $purchase->items()->create([
            'product_id' => $product->id, 'product_name' => $product->name,
            'quantity' => 10, 'unit_cost' => 400, 'total' => 4000,
        ]);

        $response = $this->post('/admin/grn', [
            'purchase_id'   => $purchase->id,
            'received_date' => now()->toDateString(),
            'items'         => [[
                'purchase_item_id' => $purchaseItem->id,
                'product_name'     => $product->name,
                'ordered_qty'      => 10,
                'received_qty'     => 10,
                'unit_cost'        => 400,
            ]],
        ]);

        $grn = GoodsReceivedNote::first();
        $response->assertRedirect(route('admin.grn.show', $grn));

        $product->refresh();
        $this->assertSame(10.0, (float) $product->stock);

        $whPivot = $product->warehouses()->where('warehouse_id', $warehouse->id)->first();
        $this->assertSame(10.0, (float) $whPivot->pivot->stock);
    }

    public function test_deleting_a_grn_reverses_the_stock_increase(): void
    {
        $product = $this->makeProduct(['stock' => 0]);
        $supplier = Supplier::create(['name' => 'Acme Supplies']);
        $warehouse = Warehouse::create(['name' => 'Main Warehouse']);

        $purchase = Purchase::create([
            'supplier_id' => $supplier->id, 'warehouse_id' => $warehouse->id,
            'invoice_no' => 'PUR-TEST-1', 'purchase_date' => now(), 'total_amount' => 4000, 'status' => 'completed',
        ]);
        $purchaseItem = $purchase->items()->create([
            'product_id' => $product->id, 'product_name' => $product->name,
            'quantity' => 10, 'unit_cost' => 400, 'total' => 4000,
        ]);

        $this->post('/admin/grn', [
            'purchase_id'   => $purchase->id,
            'received_date' => now()->toDateString(),
            'items'         => [[
                'purchase_item_id' => $purchaseItem->id,
                'product_name'     => $product->name,
                'ordered_qty'      => 10,
                'received_qty'     => 10,
                'unit_cost'        => 400,
            ]],
        ]);

        $this->assertSame(10.0, (float) $product->fresh()->stock);

        $grn = GoodsReceivedNote::first();
        $this->delete('/admin/grn/' . $grn->id)->assertRedirect(route('admin.grn.index'));

        $this->assertSame(0.0, (float) $product->fresh()->stock);
        $this->assertDatabaseMissing('goods_received_notes', ['id' => $grn->id]);
    }

    public function test_admin_can_delete_a_purchase(): void
    {
        $supplier = Supplier::create(['name' => 'Acme Supplies']);
        $warehouse = Warehouse::create(['name' => 'Main Warehouse']);
        $purchase = Purchase::create([
            'supplier_id' => $supplier->id, 'warehouse_id' => $warehouse->id,
            'invoice_no' => 'PUR-TEST-2', 'purchase_date' => now(), 'total_amount' => 0, 'status' => 'pending',
        ]);

        $this->delete('/admin/purchases/' . $purchase->id)->assertRedirect(route('admin.purchases.index'));

        $this->assertDatabaseMissing('purchases', ['id' => $purchase->id]);
    }
}
