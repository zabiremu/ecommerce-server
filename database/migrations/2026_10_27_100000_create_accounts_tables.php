<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

/**
 * Accounts & Reports: profit needs the cost of what was sold, so every order
 * line now keeps the product's purchase price at the time of sale
 * (order_items.unit_cost). Expenses (rent, salary, delivery…) and
 * investments (shop setup, equipment…) are entered by hand.
 *
 * Safe to re-run, and upgrades databases that already ran the earlier
 * Accounts module (2026_10_20_100000): its expenses/investments tables used
 * account_category_id + investment_date and order_items.cost_price. Those rows
 * are carried over into the new layout instead of failing on "table exists".
 */
return new class extends Migration
{
    /** Old account_categories names => new category keys. */
    private const LEGACY_CATEGORIES = [
        'expenses' => [
            'Shop Rent' => 'shop_rent', 'Staff Salary' => 'staff_salary', 'Delivery Charge' => 'delivery_charge',
            'Utility Bills' => 'utility', 'Marketing & Ads' => 'marketing', 'Packaging' => 'packaging', 'Other' => 'other',
        ],
        'investments' => [
            'Owner Capital' => 'capital', 'Equipment' => 'equipment', 'Shop Setup & Decoration' => 'shop_setup',
            'Website & Software' => 'website', 'Other' => 'other',
        ],
    ];

    public function up(): void
    {
        if (! Schema::hasColumn('order_items', 'unit_cost')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->decimal('unit_cost', 12, 2)->nullable()->after('unit_price');
            });
        }

        // Past sales: prefer the cost the earlier module recorded, else the product's current purchase price.
        if (Schema::hasColumn('order_items', 'cost_price')) {
            DB::statement('UPDATE order_items SET unit_cost = cost_price WHERE unit_cost IS NULL AND cost_price IS NOT NULL');
        }
        DB::statement('UPDATE order_items SET unit_cost = (SELECT purchase_price FROM products WHERE products.id = order_items.product_id) WHERE unit_cost IS NULL');

        foreach (['expenses' => ['expense_date', 'expense_date'], 'investments' => ['invest_date', 'investment_date']] as $name => [$dateColumn, $legacyDateColumn]) {
            $legacy = null;
            if (Schema::hasTable($name)) {
                if (! Schema::hasColumn($name, 'account_category_id')) {
                    continue; // already in the new layout
                }
                // Free the old foreign key names (they are database-wide in MySQL) before renaming out of the way.
                Schema::table($name, function (Blueprint $table) {
                    $table->dropForeign(['account_category_id']);
                    $table->dropForeign(['created_by']);
                });
                $legacy = "{$name}_legacy";
                Schema::rename($name, $legacy);
            }

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

            if ($legacy) {
                $this->copyLegacyRows($legacy, $name, $dateColumn, $legacyDateColumn);
                Schema::drop($legacy);
            }
        }
    }

    private function copyLegacyRows(string $from, string $to, string $dateColumn, string $legacyDateColumn): void
    {
        $categoryNames = Schema::hasTable('account_categories')
            ? DB::table('account_categories')->pluck('name', 'id')
            : collect();
        $adminIds = DB::table('admins')->pluck('id')->flip();

        DB::table($from)->orderBy('id')->get()->each(function ($row) use ($to, $dateColumn, $legacyDateColumn, $categoryNames, $adminIds) {
            $categoryName = $categoryNames[$row->account_category_id] ?? 'Other';
            $category = self::LEGACY_CATEGORIES[$to][$categoryName]
                ?? (Str::limit(Str::slug($categoryName, '_'), 40, '') ?: 'other');

            DB::table($to)->insert([
                'id'             => $row->id,
                $dateColumn      => $row->{$legacyDateColumn},
                'category'       => $category,
                'title'          => Str::limit($row->title, 191, ''),
                'amount'         => $row->amount,
                'payment_method' => $row->payment_method,
                'note'           => $row->note === null ? null : Str::limit($row->note, 500, ''),
                'created_by'     => isset($adminIds[$row->created_by]) ? $row->created_by : null,
                'created_at'     => $row->created_at,
                'updated_at'     => $row->updated_at,
            ]);
        });
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
