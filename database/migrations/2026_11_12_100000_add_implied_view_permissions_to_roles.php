<?php

use App\Models\Role;
use Illuminate\Database\Migrations\Migration;

/**
 * Roles saved before "create/edit/delete imply view" may hold e.g.
 * products.create without products.view — the Products page can't be opened,
 * so the permission does nothing. Add the missing ".view" (never removes any).
 */
return new class extends Migration
{
    public function up(): void
    {
        Role::query()->each(function (Role $role) {
            $current = $role->permissions ?? [];
            $fixed = Role::withImpliedView($current);
            if (count($fixed) !== count($current)) {
                $role->forceFill(['permissions' => $fixed])->save();
            }
        });
    }

    public function down(): void
    {
        // Additive data fix — nothing to undo.
    }
};
