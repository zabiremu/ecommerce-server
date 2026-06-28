<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deals_banner', function (Blueprint $table) {
            $table->id();
            $table->string('emoji')->nullable();
            $table->string('title');
            $table->string('title_highlight')->nullable();
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        DB::table('deals_banner')->insert([
            'emoji' => '🔥',
            'title' => 'Limited Time',
            'title_highlight' => 'Mega Deals',
            'description' => 'Get up to 60% off on top brands. Free delivery across Bangladesh. Shop now before the deal ends!',
            'button_text' => 'Grab Your Deal',
            'button_link' => '#',
            'status' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('deals_banner');
    }
};
