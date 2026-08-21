<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Originally back-filled long_description on the starter catalog products.
 * That catalog now lives in DemoCatalogSeeder, opt-in via `php artisan
 * db:seed` — this migration is a no-op so `migrate:fresh` alone stays empty.
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
