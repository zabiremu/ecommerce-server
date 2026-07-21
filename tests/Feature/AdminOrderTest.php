<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesOrders;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class AdminOrderTest extends TestCase
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

    public function test_moving_order_to_confirmed_deducts_stock_once(): void
    {
        $product = $this->makeProduct(['stock' => 10]);
        $order = $this->makeOrderFor($product, [], qty: 3);

        $this->patch('/admin/orders/' . $order->id . '/status', ['status' => 'confirmed'])->assertRedirect();

        $this->assertSame(7.0, (float) $product->fresh()->stock);
        $this->assertTrue((bool) $order->fresh()->stock_deducted);
    }

    public function test_moving_a_stock_deducted_order_to_cancelled_restores_stock(): void
    {
        $product = $this->makeProduct(['stock' => 10]);
        $order = $this->makeOrderFor($product, ['status' => 'confirmed', 'stock_deducted' => true], qty: 3);
        $product->update(['stock' => 7]); // simulate the prior deduction

        $this->patch('/admin/orders/' . $order->id . '/status', ['status' => 'cancelled'])->assertRedirect();

        $this->assertSame(10.0, (float) $product->fresh()->stock);
        $this->assertFalse((bool) $order->fresh()->stock_deducted);
    }

    public function test_delivering_a_cod_order_marks_it_paid(): void
    {
        $product = $this->makeProduct(['stock' => 10]);
        $order = $this->makeOrderFor($product, ['payment_method' => 'cod', 'payment_status' => 'unpaid']);

        $this->patch('/admin/orders/' . $order->id . '/status', ['status' => 'delivered'])->assertRedirect();

        $order->refresh();
        $this->assertSame('delivered', $order->status);
        $this->assertSame('paid', $order->payment_status);
    }

    public function test_admin_can_update_payment_status(): void
    {
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product, ['payment_status' => 'unpaid']);

        $this->patch('/admin/orders/' . $order->id . '/payment-status', ['payment_status' => 'paid'])->assertRedirect();

        $this->assertSame('paid', $order->fresh()->payment_status);
    }

    public function test_admin_can_save_order_notes(): void
    {
        $product = $this->makeProduct();
        $order = $this->makeOrderFor($product);

        $this->patch('/admin/orders/' . $order->id . '/notes', ['admin_notes' => 'Called customer to confirm.'])
            ->assertRedirect();

        $this->assertSame('Called customer to confirm.', $order->fresh()->admin_notes);
    }

    public function test_deleting_a_stock_deducted_order_restores_stock(): void
    {
        $product = $this->makeProduct(['stock' => 7]);
        $order = $this->makeOrderFor($product, ['stock_deducted' => true], qty: 3);

        $this->delete('/admin/orders/' . $order->id)->assertRedirect(route('admin.orders.index'));

        $this->assertDatabaseMissing('orders', ['id' => $order->id]);
        $this->assertSame(10.0, (float) $product->fresh()->stock);
    }

    public function test_admin_can_bulk_update_order_status(): void
    {
        $product = $this->makeProduct(['stock' => 20]);
        $a = $this->makeOrderFor($product);
        $b = $this->makeOrderFor($product);

        $this->post('/admin/orders/bulk-action', [
            'action' => 'confirmed',
            'ids'    => [$a->id, $b->id],
        ])->assertRedirect();

        $this->assertSame('confirmed', $a->fresh()->status);
        $this->assertSame('confirmed', $b->fresh()->status);
    }

    public function test_admin_can_bulk_delete_orders(): void
    {
        $product = $this->makeProduct();
        $a = $this->makeOrderFor($product);
        $b = $this->makeOrderFor($product);

        $this->post('/admin/orders/bulk-action', [
            'action' => 'delete',
            'ids'    => [$a->id, $b->id],
        ])->assertRedirect();

        $this->assertDatabaseMissing('orders', ['id' => $a->id]);
        $this->assertDatabaseMissing('orders', ['id' => $b->id]);
    }
}
