<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\ContactMessage;
use App\Models\PhoneBlacklist;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\Feature\Concerns\CreatesProducts;
use Tests\TestCase;

class AdminMiscToolsTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;
    use CreatesProducts;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    // ── Abandoned carts ──────────────────────────────────────────────────

    public function test_abandoned_carts_list_excludes_converted_and_empty_carts(): void
    {
        $product = $this->makeProduct();

        $abandoned = Cart::create(['session_id' => 'sess-abandoned', 'last_activity' => now()]);
        CartItem::create([
            'cart_id' => $abandoned->id, 'product_id' => $product->id, 'product_name' => $product->name,
            'quantity' => 1, 'unit_price' => 100, 'total' => 100,
        ]);

        $converted = Cart::create(['session_id' => 'sess-converted', 'last_activity' => now(), 'converted_at' => now()]);
        CartItem::create([
            'cart_id' => $converted->id, 'product_id' => $product->id, 'product_name' => $product->name,
            'quantity' => 1, 'unit_price' => 100, 'total' => 100,
        ]);

        $empty = Cart::create(['session_id' => 'sess-empty', 'last_activity' => now()]);

        $response = $this->get('/admin/abandoned-carts');

        $response->assertOk();
        $response->assertViewHas('carts', function ($carts) use ($abandoned, $converted, $empty) {
            $ids = $carts->pluck('id');
            return $ids->contains($abandoned->id) && !$ids->contains($converted->id) && !$ids->contains($empty->id);
        });
    }

    public function test_admin_can_delete_an_abandoned_cart_record(): void
    {
        $cart = Cart::create(['session_id' => 'sess-1', 'last_activity' => now()]);

        $this->delete('/admin/abandoned-carts/' . $cart->id)->assertRedirect(route('admin.abandoned-carts.index'));

        $this->assertDatabaseMissing('carts', ['id' => $cart->id]);
    }

    // ── Phone blacklist ──────────────────────────────────────────────────

    public function test_admin_can_blacklist_a_phone_number(): void
    {
        $this->post('/admin/phone-blacklist', ['phone' => '01700000000', 'reason' => 'Fraud'])
            ->assertRedirect();

        $this->assertDatabaseHas('phone_blacklists', ['phone' => '01700000000', 'reason' => 'Fraud']);
    }

    public function test_phone_number_can_only_be_blacklisted_once(): void
    {
        PhoneBlacklist::create(['phone' => '01700000000']);

        $response = $this->from('/admin/phone-blacklist')->post('/admin/phone-blacklist', ['phone' => '01700000000']);

        $response->assertSessionHasErrors('phone');
    }

    public function test_admin_can_remove_a_phone_from_the_blacklist(): void
    {
        $entry = PhoneBlacklist::create(['phone' => '01700000000']);

        $this->delete('/admin/phone-blacklist/' . $entry->id)->assertRedirect();

        $this->assertDatabaseMissing('phone_blacklists', ['id' => $entry->id]);
    }

    public function test_block_from_order_is_idempotent(): void
    {
        $this->post('/admin/phone-blacklist/block-from-order', ['phone' => '01700000000'])->assertRedirect();
        $this->post('/admin/phone-blacklist/block-from-order', ['phone' => '01700000000'])->assertRedirect();

        $this->assertSame(1, PhoneBlacklist::where('phone', '01700000000')->count());
    }

    // ── Contact messages ─────────────────────────────────────────────────

    public function test_opening_a_new_message_marks_it_read(): void
    {
        $msg = ContactMessage::create([
            'name' => 'John', 'email' => 'john@example.com', 'message' => 'Hi', 'status' => 'new',
        ]);

        $this->get('/admin/contact-messages/' . $msg->id)->assertOk();

        $this->assertSame('read', $msg->fresh()->status);
        $this->assertNotNull($msg->fresh()->read_at);
    }

    public function test_admin_can_update_message_status(): void
    {
        $msg = ContactMessage::create([
            'name' => 'John', 'email' => 'john@example.com', 'message' => 'Hi', 'status' => 'new',
        ]);

        $this->patch('/admin/contact-messages/' . $msg->id . '/status', ['status' => 'replied'])->assertRedirect();

        $this->assertSame('replied', $msg->fresh()->status);
    }

    public function test_admin_can_bulk_delete_contact_messages(): void
    {
        $a = ContactMessage::create(['name' => 'A', 'email' => 'a@example.com', 'message' => 'Hi', 'status' => 'new']);
        $b = ContactMessage::create(['name' => 'B', 'email' => 'b@example.com', 'message' => 'Hi', 'status' => 'new']);

        $this->post('/admin/contact-messages/bulk-action', ['action' => 'delete', 'ids' => [$a->id, $b->id]])
            ->assertRedirect();

        $this->assertDatabaseMissing('contact_messages', ['id' => $a->id]);
        $this->assertDatabaseMissing('contact_messages', ['id' => $b->id]);
    }

    public function test_admin_can_delete_a_single_contact_message(): void
    {
        $msg = ContactMessage::create(['name' => 'John', 'email' => 'john@example.com', 'message' => 'Hi', 'status' => 'new']);

        $this->delete('/admin/contact-messages/' . $msg->id)->assertRedirect(route('admin.contact-messages.index'));

        $this->assertDatabaseMissing('contact_messages', ['id' => $msg->id]);
    }
}
