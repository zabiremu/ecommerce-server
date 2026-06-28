<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')->insert([
            'slug'    => 'about',
            'title'   => 'About Us',
            'subtitle'=> 'Bangladesh\'s trusted e-commerce destination',
            'icon'    => 'fas fa-circle-info',
            'content' => '<h2>Welcome to NF Shop 24</h2>
<p>NF Shop 24 is Bangladesh\'s trusted e-commerce destination, offering quality products at unbeatable prices with hassle-free delivery across the country.</p>

<h2>Our Story</h2>
<p>NF Shop 24 started with a simple mission — to make quality products accessible to every Bangladeshi at fair prices. What began as a small online store has grown into a trusted national e-commerce platform serving thousands of happy customers. We partner directly with trusted brands and local suppliers to ensure every product meets our quality standards.</p>

<h2>Our Mission</h2>
<p>To provide every Bangladeshi with access to quality products at the best prices, delivered reliably to their doorstep.</p>

<h2>Our Vision</h2>
<p>To become Bangladesh\'s most trusted e-commerce platform, setting the standard for quality, service, and customer satisfaction.</p>

<h2>Our Values</h2>
<p>Integrity, transparency, and putting our customers first in everything we do.</p>

<h2>Why Choose Us</h2>
<ul>
  <li><strong>Secure Shopping</strong> — Pay only when you receive your product. Your satisfaction is guaranteed.</li>
  <li><strong>Fast Delivery</strong> — Nationwide delivery network ensuring your order reaches you on time.</li>
  <li><strong>24/7 Support</strong> — Dedicated customer service team ready to help you anytime.</li>
  <li><strong>Easy Returns</strong> — Hassle-free return policy. If you\'re not satisfied, we\'ll make it right.</li>
  <li><strong>Best Prices</strong> — Direct partnerships with brands and suppliers mean lower prices for you.</li>
  <li><strong>Trusted Quality</strong> — Every product is verified for quality before it reaches our customers.</li>
</ul>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('pages')->where('slug', 'about')->delete();
    }
};
