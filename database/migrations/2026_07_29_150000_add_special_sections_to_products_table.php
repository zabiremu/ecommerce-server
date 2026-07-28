<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Admin-curated homepage badges (New Arrival, Best Seller, Premium
 * Collection, Flash Sale, Combo Offer, Restock, Clearance) — distinct
 * from the auto-computed "Best Sellers" section (real order history) and
 * the "New Arrival" ribbon (created_at age). A product can carry any
 * number of these; each tag with at least one published product gets its
 * own homepage section.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('special_sections')->nullable()->after('publish_status');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('special_sections');
        });
    }
};
