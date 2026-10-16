<?php

namespace Tests\Feature;

use App\Models\AdminNotification;
use App\Models\Customer;
use App\Models\DuePayment;
use App\Models\Order;
use App\Models\ProductWarehouse;
use App\Models\Warehouse;
use App\Services\DueReminderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class PosDueSalesTest extends TestCase
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

    private function sell(array $payload, float $price = 1000, int $qty = 1)
    {
        $product = $this->makeProduct(['selling_price' => $price, 'stock' => 20]);
        ProductWarehouse::create(['product_id' => $product->id, 'warehouse_id' => $this->warehouse->id, 'stock' => 20]);

        return $this->postJson('/admin/pos/checkout', array_merge([
            'warehouse_id'   => $this->warehouse->id,
            'customer_name'  => 'Rahim',
            'customer_phone' => '01711000000',
            'payment_method' => 'cash',
            'items'          => [['product_id' => $product->id, 'quantity' => $qty]],
        ], $payload));
    }

    public function test_due_sale_records_due_amount_and_partial_status(): void
    {
        $this->sell(['is_due' => true, 'paid_amount' => 300, 'due_date' => '2030-01-31'])
            ->assertOk()->assertJson(['success' => true]);

        $order = Order::latest('id')->first();
        $this->assertEquals(700, (float) $order->due_amount);
        $this->assertEquals(300, (float) $order->paid_amount);
        $this->assertSame('partial', $order->payment_status);
        $this->assertSame('2030-01-31', $order->due_date->toDateString());
        $this->assertEquals(0, (float) $order->change_due);
    }

    public function test_due_sale_with_nothing_paid_is_unpaid_and_defaults_to_month_end(): void
    {
        $this->sell(['is_due' => true, 'paid_amount' => 0])->assertOk();

        $order = Order::latest('id')->first();
        $this->assertSame('unpaid', $order->payment_status);
        $this->assertEquals(1000, (float) $order->due_amount);
        $this->assertSame(now('Asia/Dhaka')->endOfMonth()->toDateString(), $order->due_date->toDateString());
    }

    public function test_due_sale_requires_a_real_customer(): void
    {
        $this->sell(['is_due' => true, 'walk_in' => true, 'paid_amount' => 0])
            ->assertStatus(422);
        $this->assertSame(0, Order::count());
    }

    public function test_underpaid_normal_sale_is_rejected(): void
    {
        $this->sell(['paid_amount' => 500])->assertStatus(422);
        $this->assertSame(0, Order::count());
    }

    public function test_normal_sale_has_no_due(): void
    {
        $this->sell(['paid_amount' => 1200])->assertOk();
        $order = Order::latest('id')->first();
        $this->assertSame('paid', $order->payment_status);
        $this->assertEquals(0, (float) $order->due_amount);
        $this->assertEquals(200, (float) $order->change_due);
    }

    public function test_due_list_shows_who_owes(): void
    {
        $this->sell(['is_due' => true, 'paid_amount' => 0]);

        $this->get('/admin/dues')->assertOk()->assertSee('Rahim')->assertSee('01711000000');
        $customer = Customer::where('phone', '01711000000')->first();
        $this->get('/admin/dues/' . $customer->id)->assertOk()->assertSee('Collect Payment');
    }

    public function test_collecting_applies_oldest_sale_first(): void
    {
        $this->sell(['is_due' => true, 'paid_amount' => 0], 1000);   // due 1000
        $this->sell(['is_due' => true, 'paid_amount' => 0], 500);    // due 500
        $customer = Customer::where('phone', '01711000000')->first();
        [$first, $second] = Order::orderBy('id')->get();

        $this->post("/admin/dues/{$customer->id}/collect", ['amount' => 1200, 'payment_method' => 'bkash'])
            ->assertRedirect(route('admin.dues.show', $customer));

        $this->assertEquals(0, (float) $first->fresh()->due_amount);
        $this->assertSame('paid', $first->fresh()->payment_status);
        $this->assertEquals(300, (float) $second->fresh()->due_amount);
        $this->assertSame('partial', $second->fresh()->payment_status);
        $this->assertEquals(300, $customer->outstandingDue());
        $this->assertEquals(1200, (float) DuePayment::sum('amount'));
    }

    public function test_cannot_collect_more_than_owed(): void
    {
        $this->sell(['is_due' => true, 'paid_amount' => 0]);
        $customer = Customer::where('phone', '01711000000')->first();

        $this->post("/admin/dues/{$customer->id}/collect", ['amount' => 5000, 'payment_method' => 'cash'])
            ->assertSessionHasErrors('amount');
        $this->assertEquals(1000, $customer->outstandingDue());
    }

    public function test_cancelled_sale_due_is_not_counted(): void
    {
        $this->sell(['is_due' => true, 'paid_amount' => 0]);
        Order::query()->update(['status' => 'cancelled']);
        $customer = Customer::where('phone', '01711000000')->first();
        $this->assertEquals(0, $customer->outstandingDue());
    }

    public function test_month_end_reminder_is_sent_once_on_last_day(): void
    {
        $this->sell(['is_due' => true, 'paid_amount' => 0]);

        // Mid-month: nothing
        $this->assertFalse(DueReminderService::sendIfDue(Carbon::parse('2030-01-15 12:00', 'Asia/Dhaka')));

        // Last day of month: sent once
        $this->assertTrue(DueReminderService::sendIfDue(Carbon::parse('2030-01-31 10:00', 'Asia/Dhaka')));
        $this->assertFalse(DueReminderService::sendIfDue(Carbon::parse('2030-01-31 18:00', 'Asia/Dhaka')));

        $n = AdminNotification::where('type', 'due_reminder')->sole();
        $this->assertStringContainsString('1 customer owes', $n->message);
        $this->assertSame('/admin/dues', $n->link);
    }

    public function test_month_end_reminder_catches_up_early_next_month(): void
    {
        $this->sell(['is_due' => true, 'paid_amount' => 0]);
        $this->assertTrue(DueReminderService::sendIfDue(Carbon::parse('2030-02-02 09:00', 'Asia/Dhaka')));
        $this->assertStringContainsString('January', AdminNotification::where('type', 'due_reminder')->sole()->title);
    }
}
