<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            AdminSeeder::class,
            // CategorySeeder::class,
            // BrandSeeder::class,
            // UnitSeeder::class,
            // SupplierSeeder::class,
            // WarehouseSeeder::class,
            // ProductSeeder::class,
            // PurchaseSeeder::class,
            // GRNSeeder::class,
            // CustomerSeeder::class,
            // OrderSeeder::class,
            // CouponSeeder::class,
        ]);
    }
}
