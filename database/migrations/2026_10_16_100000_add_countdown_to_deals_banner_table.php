<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Sale countdown timer for the Deals Banner. The banner is rendered on top of
 * the homepage hero only while a countdown is running (ends_at in the future,
 * and starts_at — if set — already passed). Both stored in UTC.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('deals_banner', function (Blueprint $table) {
            $table->timestamp('starts_at')->nullable()->after('button_link');
            $table->timestamp('ends_at')->nullable()->after('starts_at');
        });
    }

    public function down(): void
    {
        Schema::table('deals_banner', function (Blueprint $table) {
            $table->dropColumn(['starts_at', 'ends_at']);
        });
    }
};
