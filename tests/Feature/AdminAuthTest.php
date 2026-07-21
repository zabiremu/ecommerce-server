<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Concerns\ActsAsAdmin;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;
    use ActsAsAdmin;

    public function test_admin_can_log_in_with_valid_credentials(): void
    {
        $admin = Admin::create(['name' => 'Boss', 'email' => 'boss@example.com', 'password' => 'secret123']);

        $response = $this->post('/admin/login', [
            'email'    => 'boss@example.com',
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_admin_login_fails_with_wrong_password(): void
    {
        Admin::create(['name' => 'Boss', 'email' => 'boss@example.com', 'password' => 'secret123']);

        $response = $this->from('/admin/login')->post('/admin/login', [
            'email'    => 'boss@example.com',
            'password' => 'wrong',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest('admin');
    }

    public function test_guest_is_redirected_away_from_admin_dashboard(): void
    {
        // bootstrap/app.php sends ALL unauthenticated guards to the customer
        // login route (redirectGuestsTo), not a guard-specific one.
        $this->get('/admin/dashboard')->assertRedirect(route('login'));
    }

    public function test_super_admin_bypasses_permission_checks(): void
    {
        $this->actingAsAdmin(); // no role_id => super admin

        $this->get('/admin/categories')->assertOk();
    }

    public function test_restricted_role_is_denied_access_to_unpermitted_module(): void
    {
        $role = Role::create([
            'name'           => 'Limited Staff',
            'permissions'    => ['categories.view'], // no products.* permission
            'is_super_admin' => false,
        ]);
        $this->actingAsAdmin(['role_id' => $role->id]);

        $this->get('/admin/products')->assertForbidden();
        $this->get('/admin/categories')->assertOk();
    }

    public function test_admin_can_log_out(): void
    {
        $this->actingAsAdmin();

        $this->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }
}
