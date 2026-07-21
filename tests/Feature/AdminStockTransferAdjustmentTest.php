<?php

namespace Tests\Feature;

use App\Models\ProductWarehouse;
use App\Models\StockAdjustment;
use App\Models\StockTransfer;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class AdminStockTransferAdjustmentTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesProducts;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    // ── Stock transfers ─────────────────────────────────────────────────

    public function test_completing_a_transfer_moves_stock_between_warehouses(): void
    {
        $product = $this->makeProduct();
        $from = Warehouse::create(['name' => 'Warehouse A']);
        $to = Warehouse::create(['name' => 'Warehouse B']);
        ProductWarehouse::create(['product_id' => $product->id, 'warehouse_id' => $from->id, 'stock' => 20]);

        $this->post('/admin/stock-transfers', [
            'from_warehouse_id' => $from->id,
            'to_warehouse_id'   => $to->id,
            'transfer_date'     => now()->toDateString(),
            'items'             => [['product_id' => $product->id, 'quantity' => 5]],
        ])->assertRedirect();

        $transfer = StockTransfer::first();
        $this->assertSame('pending', $transfer->status);

        $this->patch('/admin/stock-transfers/' . $transfer->id . '/status', ['status' => 'completed'])
            ->assertRedirect(route('admin.stock-transfers.show', $transfer));

        $fromStock = ProductWarehouse::where('product_id', $product->id)->where('warehouse_id', $from->id)->first();
        $toStock = ProductWarehouse::where('product_id', $product->id)->where('warehouse_id', $to->id)->first();

        $this->assertSame(15.0, (float) $fromStock->stock);
        $this->assertSame(5.0, (float) $toStock->stock);
        $this->assertSame('completed', $transfer->fresh()->status);
    }

    public function test_transfer_fails_when_source_warehouse_lacks_stock(): void
    {
        $product = $this->makeProduct();
        $from = Warehouse::create(['name' => 'Warehouse A']);
        $to = Warehouse::create(['name' => 'Warehouse B']);
        ProductWarehouse::create(['product_id' => $product->id, 'warehouse_id' => $from->id, 'stock' => 2]);

        $this->post('/admin/stock-transfers', [
            'from_warehouse_id' => $from->id,
            'to_warehouse_id'   => $to->id,
            'transfer_date'     => now()->toDateString(),
            'items'             => [['product_id' => $product->id, 'quantity' => 5]],
        ])->assertRedirect();

        $transfer = StockTransfer::first();

        $this->patch('/admin/stock-transfers/' . $transfer->id . '/status', ['status' => 'completed'])
            ->assertRedirect();

        // Transfer should remain pending — insufficient stock aborted the completion.
        $this->assertSame('pending', $transfer->fresh()->status);
        $this->assertSame(2.0, (float) ProductWarehouse::where('product_id', $product->id)->where('warehouse_id', $from->id)->first()->stock);
    }

    public function test_a_completed_transfer_cannot_be_deleted(): void
    {
        $product = $this->makeProduct();
        $from = Warehouse::create(['name' => 'Warehouse A']);
        $to = Warehouse::create(['name' => 'Warehouse B']);
        $transfer = StockTransfer::create([
            'from_warehouse_id' => $from->id, 'to_warehouse_id' => $to->id,
            'transfer_date' => now(), 'reference_no' => 'ST-1', 'status' => 'completed',
        ]);

        $this->from('/admin/stock-transfers')->delete('/admin/stock-transfers/' . $transfer->id)
            ->assertRedirect('/admin/stock-transfers');

        $this->assertDatabaseHas('stock_transfers', ['id' => $transfer->id]);
    }

    // ── Stock adjustments ────────────────────────────────────────────────

    public function test_write_off_adjustment_reduces_stock(): void
    {
        $product = $this->makeProduct(['stock' => 20]);
        $warehouse = Warehouse::create(['name' => 'Main Warehouse']);
        ProductWarehouse::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'stock' => 20]);

        $this->post('/admin/stock-adjustments', [
            'warehouse_id'    => $warehouse->id,
            'adjustment_date' => now()->toDateString(),
            'type'            => 'write_off',
            'items'           => [['product_id' => $product->id, 'quantity' => 5, 'reason' => 'Expired']],
        ])->assertRedirect();

        $this->assertSame(15.0, (float) $product->fresh()->stock);
        $pw = ProductWarehouse::where('product_id', $product->id)->where('warehouse_id', $warehouse->id)->first();
        $this->assertSame(15.0, (float) $pw->stock);
    }

    public function test_correction_adjustment_can_increase_stock(): void
    {
        $product = $this->makeProduct(['stock' => 10]);
        $warehouse = Warehouse::create(['name' => 'Main Warehouse']);
        ProductWarehouse::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'stock' => 10]);

        $this->post('/admin/stock-adjustments', [
            'warehouse_id'    => $warehouse->id,
            'adjustment_date' => now()->toDateString(),
            'type'            => 'correction',
            'items'           => [['product_id' => $product->id, 'quantity' => 8]],
        ])->assertRedirect();

        $this->assertSame(18.0, (float) $product->fresh()->stock);
    }

    public function test_deleting_an_adjustment_reverts_the_stock_change(): void
    {
        $product = $this->makeProduct(['stock' => 20]);
        $warehouse = Warehouse::create(['name' => 'Main Warehouse']);
        ProductWarehouse::create(['product_id' => $product->id, 'warehouse_id' => $warehouse->id, 'stock' => 20]);

        $this->post('/admin/stock-adjustments', [
            'warehouse_id'    => $warehouse->id,
            'adjustment_date' => now()->toDateString(),
            'type'            => 'damage',
            'items'           => [['product_id' => $product->id, 'quantity' => 5]],
        ])->assertRedirect();

        $this->assertSame(15.0, (float) $product->fresh()->stock);

        $adjustment = StockAdjustment::first();
        $this->delete('/admin/stock-adjustments/' . $adjustment->id)->assertRedirect(route('admin.stock-adjustments.index'));

        $this->assertSame(20.0, (float) $product->fresh()->stock);
        $this->assertDatabaseMissing('stock_adjustments', ['id' => $adjustment->id]);
    }
}
