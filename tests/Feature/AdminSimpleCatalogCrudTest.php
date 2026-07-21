<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Supplier;
use App\Models\Unit;
use App\Models\Warehouse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\TestCase;

/**
 * Suppliers, brands, units, and warehouses all share the same simple
 * create/update/delete/toggle-status shape — covered together here.
 */
class AdminSimpleCatalogCrudTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    // ── Suppliers ──────────────────────────────────────────────────────

    public function test_admin_can_create_update_toggle_and_delete_a_supplier(): void
    {
        $this->postJson('/admin/suppliers', ['name' => 'Acme Supplies'])
            ->assertOk()->assertJson(['success' => true]);
        $supplier = Supplier::where('name', 'Acme Supplies')->firstOrFail();

        $this->putJson('/admin/suppliers/' . $supplier->id, ['name' => 'Acme Supplies Ltd'])
            ->assertOk()->assertJson(['success' => true]);
        $this->assertSame('Acme Supplies Ltd', $supplier->fresh()->name);

        $this->patchJson('/admin/suppliers/' . $supplier->id . '/toggle-status')->assertOk();
        $this->assertFalse((bool) $supplier->fresh()->status);

        $this->deleteJson('/admin/suppliers/' . $supplier->id)->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('suppliers', ['id' => $supplier->id]);
    }

    // ── Brands ─────────────────────────────────────────────────────────

    public function test_admin_can_create_update_toggle_and_delete_a_brand(): void
    {
        $this->postJson('/admin/brands', ['name' => 'Samsung'])
            ->assertOk()->assertJson(['success' => true]);
        $brand = Brand::where('name', 'Samsung')->firstOrFail();

        $this->putJson('/admin/brands/' . $brand->id, ['name' => 'Samsung Electronics'])
            ->assertOk()->assertJson(['success' => true]);
        $this->assertSame('Samsung Electronics', $brand->fresh()->name);

        $this->patchJson('/admin/brands/' . $brand->id . '/toggle-status')->assertOk();
        $this->assertFalse((bool) $brand->fresh()->status);

        $this->deleteJson('/admin/brands/' . $brand->id)->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('brands', ['id' => $brand->id]);
    }

    public function test_brand_slug_must_be_unique(): void
    {
        Brand::create(['name' => 'Existing', 'slug' => 'existing']);

        $this->postJson('/admin/brands', ['name' => 'New Brand', 'slug' => 'existing'])
            ->assertStatus(422)->assertJsonValidationErrors('slug');
    }

    // ── Units ──────────────────────────────────────────────────────────

    public function test_admin_can_create_update_toggle_and_delete_a_unit(): void
    {
        $this->postJson('/admin/units', ['name' => 'Kilogram'])
            ->assertOk()->assertJson(['success' => true]);
        $unit = Unit::where('name', 'Kilogram')->firstOrFail();

        $this->putJson('/admin/units/' . $unit->id, ['name' => 'Kg'])
            ->assertOk()->assertJson(['success' => true]);
        $this->assertSame('Kg', $unit->fresh()->name);

        $this->patchJson('/admin/units/' . $unit->id . '/toggle-status')->assertOk();
        $this->assertFalse((bool) $unit->fresh()->status);

        $this->deleteJson('/admin/units/' . $unit->id)->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('units', ['id' => $unit->id]);
    }

    // ── Warehouses ─────────────────────────────────────────────────────

    public function test_admin_can_create_update_toggle_and_delete_a_warehouse(): void
    {
        $this->postJson('/admin/warehouses', ['name' => 'Main Warehouse'])
            ->assertOk()->assertJson(['success' => true]);
        $warehouse = Warehouse::where('name', 'Main Warehouse')->firstOrFail();

        $this->putJson('/admin/warehouses/' . $warehouse->id, ['name' => 'Central Warehouse'])
            ->assertOk()->assertJson(['success' => true]);
        $this->assertSame('Central Warehouse', $warehouse->fresh()->name);

        $this->patchJson('/admin/warehouses/' . $warehouse->id . '/toggle-status')->assertOk();
        $this->assertFalse((bool) $warehouse->fresh()->status);

        $this->deleteJson('/admin/warehouses/' . $warehouse->id)->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('warehouses', ['id' => $warehouse->id]);
    }
}
