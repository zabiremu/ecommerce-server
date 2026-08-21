<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * Guarantees an admin login always exists after `migrate:fresh`, even
 * without the --seed flag — migrations replay on every fresh reset,
 * seeders don't. Catalog/order data intentionally lives only in
 * DemoCatalogSeeder (opt-in via `db:seed`), not here.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! DB::table('admins')->where('email', 'admin@nfshop24.com')->exists()) {
            DB::table('admins')->insert([
                'name'              => 'Super Admin',
                'email'             => 'admin@nfshop24.com',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }
    }

    public function down(): void
    {
        DB::table('admins')->where('email', 'admin@nfshop24.com')->delete();
    }
};
