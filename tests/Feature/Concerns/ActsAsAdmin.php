<?php

namespace Tests\Feature\Concerns;

use App\Models\Admin;

trait ActsAsAdmin
{
    /**
     * Admins without a role_id are treated as Super Admins and skip all
     * permission checks (see Admin::isSuperAdmin()).
     */
    protected function makeAdmin(array $overrides = []): Admin
    {
        return Admin::create(array_merge([
            'name'     => 'Test Admin',
            'email'    => 'admin-' . uniqid() . '@example.com',
            'password' => 'secret123',
        ], $overrides));
    }

    protected function actingAsAdmin(array $overrides = []): Admin
    {
        $admin = $this->makeAdmin($overrides);
        $this->actingAs($admin, 'admin');
        return $admin;
    }
}
