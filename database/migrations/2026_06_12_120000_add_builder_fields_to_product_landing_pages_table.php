<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_landing_pages', function (Blueprint $table) {
            $table->string('layout')->default('default')->after('is_active');
            $table->json('blocks')->nullable()->after('layout');
            $table->decimal('shipping_inside_dhaka', 10, 2)->default(0)->after('blocks');
            $table->decimal('shipping_outside_dhaka', 10, 2)->default(80)->after('shipping_inside_dhaka');
            $table->boolean('enable_online_payment')->default(false)->after('shipping_outside_dhaka');
            $table->string('footer_text')->nullable()->after('enable_online_payment');
        });
    }

    public function down(): void
    {
        Schema::table('product_landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'layout',
                'blocks',
                'shipping_inside_dhaka',
                'shipping_outside_dhaka',
                'enable_online_payment',
                'footer_text',
            ]);
        });
    }
};
