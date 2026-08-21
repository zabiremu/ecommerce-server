<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Originally tagged starter-catalog products with special_sections and
 * sale prices. That catalog now lives in DemoCatalogSeeder, opt-in via
 * `php artisan db:seed` — this migration is a no-op so `migrate:fresh`
 * alone stays empty.
 */
return new class extends Migration
{
    public function up(): void
    {
        // Intentionally empty — see DemoCatalogSeeder.
    }

    public function down(): void
    {
        // Intentionally empty.
    }
};
