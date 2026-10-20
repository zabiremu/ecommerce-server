<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Accounts & Reports module.
 *
 *  - account_categories : heads for expenses / investments (Shop Rent, Salary, ...)
 *  - expenses           : day-to-day running costs, deducted from profit
 *  - investments        : money put into the business (capital, equipment, ...)
 *  - order_items.cost_price : purchase price snapshot at the moment of sale,
 *                             so later price changes never rewrite old profit.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('account_categories', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->default('expense'); // expense | investment
            $table->string('name');
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->unique(['type', 'name']);
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_category_id')->nullable()->constrained('account_categories')->nullOnDelete();
            $table->string('title');
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->string('payment_method', 30)->default('cash');
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();

            $table->index('expense_date');
        });

        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_category_id')->nullable()->constrained('account_categories')->nullOnDelete();
            $table->string('title');
            $table->decimal('amount', 12, 2);
            $table->date('investment_date');
            $table->string('payment_method', 30)->default('cash');
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();

            $table->index('investment_date');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('cost_price', 12, 2)->nullable()->after('unit_price');
        });

        // Backfill old sales with the product's current purchase price.
        DB::statement('UPDATE order_items SET cost_price = (SELECT purchase_price FROM products WHERE products.id = order_items.product_id) WHERE cost_price IS NULL AND product_id IS NOT NULL');

        $now = now();
        $defaults = [
            'expense'    => ['Shop Rent', 'Staff Salary', 'Delivery Charge', 'Utility Bills', 'Marketing & Ads', 'Packaging', 'Other'],
            'investment' => ['Owner Capital', 'Stock / Inventory', 'Equipment', 'Shop Setup & Decoration', 'Website & Software', 'Other'],
        ];
        foreach ($defaults as $type => $names) {
            foreach ($names as $name) {
                DB::table('account_categories')->insert([
                    'type' => $type, 'name' => $name, 'status' => true,
                    'created_at' => $now, 'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('cost_price');
        });
        Schema::dropIfExists('investments');
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('account_categories');
    }
};
