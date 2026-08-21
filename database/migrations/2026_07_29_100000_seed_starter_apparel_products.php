<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Originally inserted a starter product catalog directly into the products
 * table, so it silently reappeared on every `migrate:fresh` regardless of
 * --seed. That catalog now lives in DemoCatalogSeeder, opt-in via
 * `php artisan db:seed` — `migrate:fresh` alone leaves products empty.
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
