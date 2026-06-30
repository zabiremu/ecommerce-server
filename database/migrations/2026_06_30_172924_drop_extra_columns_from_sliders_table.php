<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['badge', 'badge_icon', 'button_text', 'button_link', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->string('badge')->nullable();
            $table->string('badge_icon')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
        });
    }
};
