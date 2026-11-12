<?php

namespace Tests\Feature;

use App\Models\GoodsReceivedNote;
use App\Models\GRNItem;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

/** Purchases, GRNs and the purchase report show (and filter by) product names. */
class PurchaseProductNamesTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesProducts;

    private Purchase $purchase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();

        $supplier  = Supplier::create(['name' => 'PUSHAN', 'status' => true]);
        $warehouse = Warehouse::create(['name' => 'ROVENTEX', 'slug' => 'roventex', 'status' => true]);
        $jeans = $this->makeProduct(['name' => 'Bootcut Jeans']);
        $polo  = $this->makeProduct(['name' => 'Classic Polo']);
        $this->otherProduct = $this->makeProduct(['name' => 'Cargo Shorts']);

        $this->purchase = Purchase::create([
            'invoice_no' => 'PUR-20261104-0031', 'supplier_id' => $supplier->id, 'warehouse_id' => $warehouse->id,
            'purchase_date' => now()->toDateString(), 'total_amount' => 4500, 'status' => 'completed',
        ]);
        $items = [];
        foreach ([[$jeans, 10], [$polo, 5]] as [$p, $q]) {
            $items[] = PurchaseItem::create(['purchase_id' => $this->purchase->id, 'product_id' => $p->id, 'product_name' => $p->name,
                'quantity' => $q, 'unit_cost' => 300, 'total' => 300 * $q]);
        }

        $grn = GoodsReceivedNote::create([
            'grn_no' => 'GRN-20261104-0001', 'purchase_id' => $this->purchase->id, 'supplier_id' => $supplier->id,
            'warehouse_id' => $warehouse->id, 'received_date' => now()->toDateString(),
        ]);
        GRNItem::create(['goods_received_note_id' => $grn->id, 'purchase_item_id' => $items[0]->id, 'product_id' => $jeans->id, 'product_name' => 'Bootcut Jeans',
            'ordered_qty' => 10, 'received_qty' => 8, 'unit_cost' => 300, 'total' => 2400]);
    }

    private $otherProduct;

    public function test_purchase_list_shows_product_names(): void
    {
        $this->get('/admin/purchases')->assertOk()
            ->assertSee('Bootcut Jeans')->assertSee('Classic Polo')->assertSee('Search by product');
    }

    public function test_grn_list_shows_received_products(): void
    {
        $this->get('/admin/grn')->assertOk()->assertSee('Bootcut Jeans')->assertSee('× 8', false);
    }

    public function test_purchase_report_shows_and_filters_by_product(): void
    {
        $this->get('/admin/purchase-report')->assertOk()->assertSee('Bootcut Jeans')->assertSee('PUR-20261104-0031');

        $this->get('/admin/purchase-report?product_id=' . $this->otherProduct->id)
            ->assertOk()->assertDontSee('PUR-20261104-0031');
    }

    public function test_purchase_report_csv_includes_products(): void
    {
        $csv = $this->get('/admin/purchase-report/export')->assertOk()->streamedContent();
        $this->assertStringContainsString('Products', $csv);
        $this->assertStringContainsString('Bootcut Jeans x 10', $csv);
    }

    public function test_purchase_report_counts_completed_purchases(): void
    {
        // Purchases are pending / completed / cancelled — the report used to look for "received".
        $this->get('/admin/purchase-report')->assertOk()
            ->assertSee('Completed Amount')->assertSee('Completed: 1')
            ->assertViewHas('receivedAmount', 4500);
        $this->get('/admin/purchase-report?status=completed')->assertOk()->assertSee('PUR-20261104-0031');
    }
}
