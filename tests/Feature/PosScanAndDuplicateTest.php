<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\ProductWarehouse;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class PosScanAndDuplicateTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesProducts;

    private Warehouse $warehouse;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
        $this->warehouse = Warehouse::create(['name' => 'Main', 'slug' => 'main-' . uniqid(), 'status' => true]);
    }

    private function stocked(array $attrs = [])
    {
        $product = $this->makeProduct($attrs);
        ProductWarehouse::create(['product_id' => $product->id, 'warehouse_id' => $this->warehouse->id, 'stock' => 20]);

        return $product;
    }

    public function test_same_sale_token_sent_twice_creates_one_sale(): void
    {
        $product = $this->stocked();
        $payload = [
            'warehouse_id' => $this->warehouse->id, 'walk_in' => true, 'payment_method' => 'cash',
            'items' => [['product_id' => $product->id, 'quantity' => 1]],
            'client_token' => 'sale-token-123',
        ];

        $first = $this->postJson('/admin/pos/checkout', $payload)->assertOk()->json();
        $second = $this->postJson('/admin/pos/checkout', $payload)->assertOk()->json();

        $this->assertSame(1, Order::count());
        $this->assertSame($first['order_no'], $second['order_no']);
        $this->assertEquals(19, (float) $product->fresh()->stock);   // stock taken once

        $this->postJson('/admin/pos/checkout', ['client_token' => 'another'] + $payload)->assertOk();
        $this->assertSame(2, Order::count());
    }

    public function test_scanning_a_variant_sku_picks_that_variant(): void
    {
        $product = $this->stocked(['name' => 'Polo', 'sku' => 'POLO-1']);
        $this->makeVariant($product, ['sku' => 'POLO-1-RED-M']);
        $blue = $this->makeVariant($product, ['color' => 'Blue', 'sku' => 'POLO-1-BLUE-M']);

        $json = $this->getJson("/admin/pos/products?warehouse_id={$this->warehouse->id}&s=POLO-1-BLUE-M&scan=1")->assertOk()->json();

        $this->assertCount(1, $json['data']);
        $this->assertSame($blue->id, $json['matched_variant_id']);
    }

    public function test_scanning_exact_barcode_beats_partial_name_matches(): void
    {
        $this->stocked(['name' => 'Shirt 123', 'barcode' => '999']);
        $target = $this->stocked(['name' => 'Jeans', 'barcode' => '123']);

        $json = $this->getJson("/admin/pos/products?warehouse_id={$this->warehouse->id}&s=123&scan=1")->json();

        $this->assertSame([$target->id], array_column($json['data'], 'id'));
    }

    public function test_online_order_submitted_twice_creates_one_order(): void
    {
        \Illuminate\Support\Facades\Mail::fake();
        $product = $this->makeProduct(['selling_price' => 500, 'stock' => 10]);
        $payload = [
            'shipping_name' => 'Jane Doe', 'shipping_phone' => '01700000000', 'shipping_address' => '123 Main Street',
            'shipping_city' => 'Dhaka', 'shipping_zone' => 'inside', 'payment_method' => 'cod',
            'items' => [['id' => $product->id, 'qty' => 2]],
        ];

        $first = $this->postJson('/orders', $payload)->assertOk()->json();
        $second = $this->postJson('/orders', $payload)->assertOk()->json();
        $this->assertSame(1, Order::count());
        $this->assertSame($first['order_no'], $second['order_no']);

        // A different cart from the same phone is a real new order.
        $payload['items'] = [['id' => $product->id, 'qty' => 1]];
        $this->postJson('/orders', $payload)->assertOk();
        $this->assertSame(2, Order::count());
    }

    public function test_receipt_is_sized_for_thermal_paper(): void
    {
        $product = $this->stocked();
        $this->postJson('/admin/pos/checkout', [
            'warehouse_id' => $this->warehouse->id, 'walk_in' => true, 'payment_method' => 'cash',
            'items' => [['product_id' => $product->id, 'quantity' => 1]],
        ])->assertOk();
        $order = Order::firstOrFail();

        $this->get("/admin/pos/orders/{$order->id}/receipt")->assertOk()->assertSee('size: 80mm auto', false);
        $this->get("/admin/pos/orders/{$order->id}/receipt?paper=58")->assertOk()->assertSee('size: 58mm auto', false);
    }
}
