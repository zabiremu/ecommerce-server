<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesOrders;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class AdminCustomerTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesOrders;
    use CreatesProducts;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    public function test_admin_can_update_customer_details(): void
    {
        $customer = $this->makeCustomer(['name' => 'Old Name', 'phone' => '01711111111']);

        $response = $this->put('/admin/customers/' . $customer->id, [
            'name'  => 'New Name',
            'phone' => '01711111111',
            'email' => 'new@example.com',
        ]);

        $response->assertRedirect();
        $customer->refresh();
        $this->assertSame('New Name', $customer->name);
        $this->assertSame('new@example.com', $customer->email);
    }

    public function test_customer_phone_must_stay_unique_on_update(): void
    {
        $this->makeCustomer(['phone' => '01711111111']);
        $customer = $this->makeCustomer(['phone' => '01722222222']);

        $response = $this->from('/admin/customers/' . $customer->id)->put('/admin/customers/' . $customer->id, [
            'name'  => $customer->name,
            'phone' => '01711111111', // already taken
        ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_admin_can_toggle_customer_status(): void
    {
        $customer = $this->makeCustomer(['status' => true]);

        $this->patch('/admin/customers/' . $customer->id . '/toggle-status')->assertRedirect();

        $this->assertFalse((bool) $customer->fresh()->status);
    }

    public function test_customer_with_orders_cannot_be_deleted(): void
    {
        $product = $this->makeProduct();
        $customer = $this->makeCustomer();
        $this->makeOrderFor($product, ['customer' => $customer, 'customer_id' => $customer->id]);

        $response = $this->from('/admin/customers')->delete('/admin/customers/' . $customer->id);

        $response->assertRedirect('/admin/customers');
        $this->assertDatabaseHas('customers', ['id' => $customer->id]);
    }

    public function test_customer_without_orders_can_be_deleted(): void
    {
        $customer = $this->makeCustomer();

        $this->delete('/admin/customers/' . $customer->id)->assertRedirect(route('admin.customers.index'));

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
