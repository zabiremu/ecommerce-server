<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * One-time token the POS sends with each sale. A double click or a network
 * retry sends the same token again, and the unique index stops a second sale.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('client_token', 64)->nullable()->unique()->after('order_no');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropUnique(['client_token']);
            $table->dropColumn('client_token');
        });
    }
};
