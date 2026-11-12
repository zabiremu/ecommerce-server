<?php

namespace Tests\Feature;

use App\Http\Middleware\CheckAdminPermission;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\TestCase;

class AdminPermissionsTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    private function staffWith(array $permissions, array $roleAttrs = []): Admin
    {
        $role = Role::create(array_merge([
            'name'        => 'Role ' . uniqid(),
            'permissions' => $permissions,
        ], $roleAttrs));

        return $this->actingAsAdmin(['role_id' => $role->id])->load('role');
    }

    // ── Route coverage ───────────────────────────────────────────────────

    public function test_every_admin_route_needs_a_grantable_permission(): void
    {
        $grantable = Role::permissionKeys();
        $problems = [];

        foreach (Route::getRoutes() as $route) {
            if (!in_array('admin.permission', $route->gatherMiddleware(), true)) continue;
            $name = $route->getName();
            if ($name === null) { $problems[] = $route->uri() . ' (unnamed)'; continue; }
            if (CheckAdminPermission::isExempt($name)) continue;

            $perm = CheckAdminPermission::permissionFor($name);
            if ($perm === null) {
                $problems[] = "{$name}: no permission mapped";
            } elseif (!in_array($perm, $grantable, true)) {
                $problems[] = "{$name}: needs '{$perm}', which no role can be given";
            }
        }

        $this->assertSame([], $problems, "Admin routes without a usable permission:\n" . implode("\n", $problems));
    }

    // ── Enforcement ─────────────────────────────────────────────────────

    public function test_toggle_status_routes_are_checked(): void
    {
        $brand = Brand::create(['name' => 'Acme', 'slug' => 'acme', 'status' => true]);

        $this->staffWith(['brands.view']);
        $this->patchJson("/admin/brands/{$brand->id}/toggle-status")->assertForbidden();

        $this->staffWith(['brands.view', 'brands.edit']);
        $this->patchJson("/admin/brands/{$brand->id}/toggle-status")->assertSuccessful();
    }

    public function test_report_export_needs_report_permission(): void
    {
        $this->staffWith(['orders.view']);
        $this->get('/admin/sales-report/export')->assertForbidden();
    }

    public function test_bulk_delete_needs_delete_permission(): void
    {
        $this->staffWith(['products.view', 'products.edit']);
        $this->postJson('/admin/products/bulk-action', ['action' => 'delete', 'ids' => [1]])->assertForbidden();
    }

    public function test_dashboard_needs_permission_and_redirects_to_an_allowed_page(): void
    {
        $this->staffWith(['orders.view']);
        $this->get('/admin/dashboard')->assertRedirect(route('admin.orders.index'));
        $this->getJson('/admin/visitor-stats')->assertForbidden();

        $this->staffWith(['dashboard.view']);
        $this->get('/admin/dashboard')->assertOk();
    }

    public function test_dashboard_without_any_page_shows_403(): void
    {
        $this->staffWith([]);
        $this->get('/admin/dashboard')->assertForbidden();
    }

    public function test_global_search_only_returns_what_the_role_can_see(): void
    {
        \App\Models\Customer::create(['name' => 'Searchable Person', 'phone' => '01700000000', 'status' => true]);

        $this->staffWith(['products.view']);
        $groups = collect($this->getJson('/admin/search?q=Searchable')->assertOk()->json('results'))->pluck('group');
        $this->assertNotContains('Customers', $groups);

        $this->staffWith(['customers.view']);
        $groups = collect($this->getJson('/admin/search?q=Searchable')->assertOk()->json('results'))->pluck('group');
        $this->assertContains('Customers', $groups);
    }

    // ── No privilege escalation ─────────────────────────────────────────

    public function test_role_editor_cannot_create_super_admin_role_or_grant_missing_permissions(): void
    {
        $this->staffWith(['roles.view', 'roles.create', 'products.view']);
        $this->get('/admin/roles/create')->assertOk()->assertDontSee('Grant all permissions (Super Admin)');

        $this->post('/admin/roles', ['name' => 'Sneaky', 'is_super_admin' => 1, 'permissions' => []])
            ->assertSessionHasErrors('is_super_admin');
        $this->post('/admin/roles', ['name' => 'Sneaky 2', 'permissions' => ['products.view', 'orders.delete']])
            ->assertSessionHasErrors('permissions');
        $this->post('/admin/roles', ['name' => 'Fine', 'permissions' => ['products.view']])
            ->assertSessionHasNoErrors();

        $this->assertFalse(Role::where('name', 'Sneaky')->exists());
        $this->assertTrue(Role::where('name', 'Fine')->exists());
    }

    public function test_role_editor_cannot_edit_own_role_or_super_admin_role(): void
    {
        $me = $this->staffWith(['roles.view', 'roles.edit']);
        $super = Role::create(['name' => 'Owners', 'is_super_admin' => true, 'permissions' => []]);

        $this->put("/admin/roles/{$me->role_id}", ['name' => 'Mine', 'permissions' => ['roles.view', 'roles.edit']])
            ->assertForbidden();
        $this->put("/admin/roles/{$super->id}", ['name' => 'Owners', 'permissions' => []])
            ->assertForbidden();
    }

    public function test_unknown_permission_names_are_rejected(): void
    {
        $this->actingAsAdmin(); // super admin
        $this->post('/admin/roles', ['name' => 'Bad', 'permissions' => ['everything.ever']])
            ->assertSessionHasErrors('permissions.0');
    }

    public function test_admin_manager_cannot_make_super_admins(): void
    {
        $this->staffWith(['admins.view', 'admins.create', 'admins.edit', 'products.view']);
        $superRole = Role::create(['name' => 'Owners', 'is_super_admin' => true, 'permissions' => []]);
        $bigRole = Role::create(['name' => 'Big', 'permissions' => ['orders.delete']]);
        $smallRole = Role::create(['name' => 'Small', 'permissions' => ['products.view']]);

        $this->get('/admin/admins/create')->assertOk()
            ->assertDontSee('Super Admin (no role)')->assertSee('Small')->assertDontSee('>Big', false);

        $base = ['name' => 'New', 'password' => 'password123', 'password_confirmation' => 'password123'];

        $this->post('/admin/admins', $base + ['email' => 'a@x.com', 'role_id' => ''])->assertSessionHasErrors('role_id');
        $this->post('/admin/admins', $base + ['email' => 'b@x.com', 'role_id' => $superRole->id])->assertSessionHasErrors('role_id');
        $this->post('/admin/admins', $base + ['email' => 'c@x.com', 'role_id' => $bigRole->id])->assertSessionHasErrors('role_id');
        $this->post('/admin/admins', $base + ['email' => 'd@x.com', 'role_id' => $smallRole->id])->assertSessionHasNoErrors();

        $this->assertSame(['d@x.com'], Admin::whereIn('email', ['a@x.com', 'b@x.com', 'c@x.com', 'd@x.com'])->pluck('email')->all());
    }

    public function test_admin_manager_cannot_clear_own_role_or_edit_super_admins(): void
    {
        $me = $this->staffWith(['admins.view', 'admins.edit']);
        $owner = Admin::create(['name' => 'Owner', 'email' => 'owner@x.com', 'password' => 'secret123']);

        // Clearing your own role would make you a Super Admin — the role is kept.
        $this->put("/admin/admins/{$me->id}", ['name' => 'Me', 'email' => $me->email, 'role_id' => '']);
        $this->assertSame($me->role_id, $me->fresh()->role_id);
        $this->assertFalse($me->fresh()->isSuperAdmin());

        $this->put("/admin/admins/{$owner->id}", ['name' => 'Hacked', 'email' => 'owner@x.com', 'role_id' => ''])
            ->assertForbidden();
    }

    public function test_create_edit_delete_imply_view_when_saving_a_role(): void
    {
        $this->actingAsAdmin(); // super admin
        $this->post('/admin/roles', ['name' => 'Stock Clerk', 'permissions' => ['products.create', 'orders.delete']])
            ->assertSessionHasNoErrors();

        $perms = Role::where('name', 'Stock Clerk')->first()->permissions;
        sort($perms);
        $this->assertSame(['orders.delete', 'orders.view', 'products.create', 'products.view'], $perms);
    }
}
