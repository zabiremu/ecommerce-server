<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('phone_blacklists', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 30)->unique();
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('blocked_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('phone_blacklists');
    }
};
