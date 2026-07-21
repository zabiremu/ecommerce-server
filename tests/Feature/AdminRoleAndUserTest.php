<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\TestCase;

class AdminRoleAndUserTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    // ── Roles ──────────────────────────────────────────────────────────

    public function test_admin_can_create_a_role_with_permissions(): void
    {
        $response = $this->post('/admin/roles', [
            'name'        => 'Support Staff',
            'permissions' => ['orders.view', 'orders.edit'],
        ]);

        $response->assertRedirect(route('admin.roles.index'));
        $this->assertDatabaseHas('roles', ['name' => 'Support Staff', 'slug' => 'support-staff']);

        $role = Role::where('name', 'Support Staff')->first();
        $this->assertTrue($role->hasPermission('orders.view'));
        $this->assertFalse($role->hasPermission('products.delete'));
    }

    public function test_role_name_must_be_unique(): void
    {
        Role::create(['name' => 'Support Staff', 'permissions' => []]);

        $response = $this->from('/admin/roles/create')->post('/admin/roles', ['name' => 'Support Staff']);

        $response->assertSessionHasErrors('name');
    }

    public function test_role_with_assigned_admins_cannot_be_deleted(): void
    {
        $role = Role::create(['name' => 'Support Staff', 'permissions' => []]);
        Admin::create(['name' => 'Staffer', 'email' => 'staffer@example.com', 'password' => 'secret123', 'role_id' => $role->id]);

        $response = $this->from('/admin/roles')->delete('/admin/roles/' . $role->id);

        $response->assertRedirect('/admin/roles');
        $this->assertDatabaseHas('roles', ['id' => $role->id]);
    }

    public function test_unassigned_role_can_be_deleted(): void
    {
        $role = Role::create(['name' => 'Unused Role', 'permissions' => []]);

        $this->delete('/admin/roles/' . $role->id)->assertRedirect(route('admin.roles.index'));

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    // ── Admin users ────────────────────────────────────────────────────

    public function test_admin_can_create_a_new_admin_user(): void
    {
        $role = Role::create(['name' => 'Support Staff', 'permissions' => []]);

        $response = $this->post('/admin/admins', [
            'name'                  => 'New Staffer',
            'email'                 => 'newstaffer@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'role_id'               => $role->id,
        ]);

        $response->assertRedirect(route('admin.admins.index'));
        $this->assertDatabaseHas('admins', ['email' => 'newstaffer@example.com', 'role_id' => $role->id]);
    }

    public function test_admin_email_must_be_unique(): void
    {
        Admin::create(['name' => 'Existing', 'email' => 'dup@example.com', 'password' => 'secret123']);

        $response = $this->from('/admin/admins/create')->post('/admin/admins', [
            'name'                  => 'New Staffer',
            'email'                 => 'dup@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_admin_cannot_delete_their_own_account(): void
    {
        $self = $this->actingAsAdmin();

        $response = $this->from('/admin/admins')->delete('/admin/admins/' . $self->id);

        $response->assertRedirect('/admin/admins');
        $this->assertDatabaseHas('admins', ['id' => $self->id]);
    }

    public function test_super_admin_account_cannot_be_deleted(): void
    {
        $this->actingAsAdmin(); // acting admin, distinct from the target below
        $superAdmin = Admin::create(['name' => 'Super', 'email' => 'super@example.com', 'password' => 'secret123']);

        $response = $this->from('/admin/admins')->delete('/admin/admins/' . $superAdmin->id);

        $response->assertRedirect('/admin/admins');
        $this->assertDatabaseHas('admins', ['id' => $superAdmin->id]);
    }

    public function test_non_super_admin_can_be_deleted_by_another_admin(): void
    {
        $this->actingAsAdmin();
        $role = Role::create(['name' => 'Support Staff', 'permissions' => []]);
        $target = Admin::create(['name' => 'Staffer', 'email' => 'staffer@example.com', 'password' => 'secret123', 'role_id' => $role->id]);

        $this->delete('/admin/admins/' . $target->id)->assertRedirect(route('admin.admins.index'));

        $this->assertDatabaseMissing('admins', ['id' => $target->id]);
    }
}
