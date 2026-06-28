<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('group')->nullable()->index();
            $table->timestamps();
        });

        $now = now();
        $defaults = [
            // Company
            ['company',  'company_name',        'NF Shop 24'],
            ['company',  'company_tagline',     'NF Shop 24 — Largest E-commerce platform in Bangladesh. Quality products at the best prices with reliable delivery across the country.'],
            // Contact
            ['contact',  'contact_address',     'Chittagong, Bangladesh'],
            ['contact',  'contact_email',       'info@nfshop24.com'],
            ['contact',  'contact_phone',       '+8801820834086'],
            ['contact',  'contact_hours',       'Sat-Thu: 9AM - 10PM'],
            // Social
            ['social',   'social_facebook',     ''],
            ['social',   'social_youtube',      ''],
            ['social',   'social_whatsapp',     'https://api.whatsapp.com/send?phone=8801820834086'],
            ['social',   'social_instagram',    ''],
            // Developer credit
            ['credit',   'developer_name',      'SEBA IT'],
            ['credit',   'developer_url',       '#'],
        ];

        $rows = array_map(fn ($r) => [
            'group'      => $r[0],
            'key'        => $r[1],
            'value'      => $r[2],
            'created_at' => $now,
            'updated_at' => $now,
        ], $defaults);

        DB::table('site_settings')->insert($rows);
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
