<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Accounts & Reports: profit needs the cost of what was sold, so every order
 * line now keeps the product's purchase price at the time of sale
 * (order_items.unit_cost). Expenses (rent, salary, delivery…) and
 * investments (shop setup, equipment…) are entered by hand.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('unit_cost', 12, 2)->nullable()->after('unit_price');
        });

        // Past sales: best guess is the product's current purchase price.
        DB::statement('UPDATE order_items SET unit_cost = (SELECT purchase_price FROM products WHERE products.id = order_items.product_id) WHERE unit_cost IS NULL');

        foreach (['expenses' => 'expense_date', 'investments' => 'invest_date'] as $name => $dateColumn) {
            Schema::create($name, function (Blueprint $table) use ($dateColumn) {
                $table->id();
                $table->date($dateColumn);
                $table->string('category', 40);
                $table->string('title', 191);
                $table->decimal('amount', 12, 2);
                $table->string('payment_method', 30)->nullable();
                $table->string('note', 500)->nullable();
                $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
                $table->timestamps();

                $table->index([$dateColumn, 'category']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('investments');
        Schema::dropIfExists('expenses');

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn('unit_cost');
        });
    }
};
