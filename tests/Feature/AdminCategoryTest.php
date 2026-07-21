<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    public function test_admin_can_create_a_category(): void
    {
        $response = $this->postJson('/admin/categories', ['name' => 'Electronics']);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseHas('categories', ['name' => 'Electronics', 'slug' => 'electronics']);
    }

    public function test_admin_can_update_a_category(): void
    {
        $category = Category::create(['name' => 'Old Name', 'slug' => 'old-name']);

        $response = $this->putJson('/admin/categories/' . $category->id, ['name' => 'New Name']);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertSame('New Name', $category->fresh()->name);
    }

    public function test_admin_cannot_delete_a_category_with_subcategories(): void
    {
        $parent = Category::create(['name' => 'Parent', 'slug' => 'parent']);
        Category::create(['name' => 'Child', 'slug' => 'child', 'parent_id' => $parent->id]);

        $response = $this->deleteJson('/admin/categories/' . $parent->id);

        $response->assertStatus(422)->assertJson(['success' => false]);
        $this->assertDatabaseHas('categories', ['id' => $parent->id]);
    }

    public function test_admin_can_delete_a_category_without_subcategories(): void
    {
        $category = Category::create(['name' => 'Standalone', 'slug' => 'standalone']);

        $response = $this->deleteJson('/admin/categories/' . $category->id);

        $response->assertOk()->assertJson(['success' => true]);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_can_toggle_category_status(): void
    {
        $category = Category::create(['name' => 'Toggle Me', 'slug' => 'toggle-me', 'status' => true]);

        $this->patchJson('/admin/categories/' . $category->id . '/toggle-status')->assertOk();

        $this->assertFalse((bool) $category->fresh()->status);
    }
}
