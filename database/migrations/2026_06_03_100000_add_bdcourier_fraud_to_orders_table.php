<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('bdcourier_success_ratio', 5, 2)->nullable()->after('risk_flags');
            $table->unsignedSmallInteger('bdcourier_total_parcels')->nullable()->after('bdcourier_success_ratio');
            $table->unsignedTinyInteger('bdcourier_fraud_reports')->nullable()->after('bdcourier_total_parcels');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['bdcourier_success_ratio', 'bdcourier_total_parcels', 'bdcourier_fraud_reports']);
        });
    }
};
