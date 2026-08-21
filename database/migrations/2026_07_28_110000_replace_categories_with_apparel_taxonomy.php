<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Originally inserted the apparel category taxonomy (T-Shirt, Jeans,
 * Footwear, Special Sections, ...) directly into the categories table, so
 * it silently reappeared on every `migrate:fresh` regardless of --seed.
 * That taxonomy now lives in DemoCatalogSeeder, opt-in via `php artisan
 * db:seed` — `migrate:fresh` alone leaves categories empty.
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
