<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon')->nullable();
            $table->longText('content')->nullable();
            $table->string('last_updated_label')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->timestamps();
        });

        // Seed the three default pages
        DB::table('pages')->insert([
            [
                'slug'              => 'privacy-policy',
                'title'             => 'Privacy Policy',
                'subtitle'          => 'How we collect, use, and protect your information',
                'icon'              => 'fas fa-shield-alt',
                'last_updated_label'=> 'May 8, 2026',
                'content'           => '<h2>1. Introduction</h2>
<p>NF Shop 24 ("we," "our," or "us") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.</p>
<p>By using our website, you agree to the collection and use of information in accordance with this policy.</p>

<h2>2. Information We Collect</h2>
<h3>Personal Information</h3>
<p>We may collect the following personal information when you place an order, create an account, or contact us:</p>
<ul>
  <li>Full name</li>
  <li>Email address</li>
  <li>Phone number</li>
  <li>Delivery address</li>
  <li>Payment information (processed securely through third-party gateways)</li>
</ul>
<h3>Non-Personal Information</h3>
<p>We automatically collect certain non-personal information when you visit our website, including:</p>
<ul>
  <li>IP address</li>
  <li>Browser type and version</li>
  <li>Pages visited and time spent</li>
  <li>Device information</li>
  <li>Cookies and usage data</li>
</ul>

<h2>3. How We Use Your Information</h2>
<ul>
  <li>To process and deliver your orders</li>
  <li>To communicate with you about your orders and account</li>
  <li>To improve our website and services</li>
  <li>To send promotional offers (only with your consent)</li>
  <li>To prevent fraud and ensure security</li>
  <li>To comply with legal obligations</li>
</ul>

<h2>4. Information Sharing</h2>
<p>We do not sell, trade, or rent your personal information to third parties. We may share your information with:</p>
<ul>
  <li>Delivery partners to fulfill your orders</li>
  <li>Payment processors to handle transactions securely</li>
  <li>Legal authorities when required by law</li>
</ul>

<h2>5. Data Security</h2>
<p>We implement a variety of security measures to maintain the safety of your personal information, including encryption, secure servers, and regular security audits.</p>

<h2>6. Cookies</h2>
<p>We use cookies to enhance your browsing experience, analyze site traffic, and personalize content. You can control cookie settings through your browser preferences.</p>

<h2>7. Your Rights</h2>
<ul>
  <li>Access your personal data held by us</li>
  <li>Request correction of inaccurate data</li>
  <li>Request deletion of your data</li>
  <li>Opt-out of marketing communications</li>
  <li>Withdraw consent at any time</li>
</ul>

<h2>8. Contact Us</h2>
<p>If you have any questions about this Privacy Policy, please contact us at info@nfshop24.com.</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug'              => 'terms-conditions',
                'title'             => 'Terms & Conditions',
                'subtitle'          => 'Please read these terms carefully before using our website',
                'icon'              => 'fas fa-file-contract',
                'last_updated_label'=> 'May 8, 2026',
                'content'           => '<h2>1. Acceptance of Terms</h2>
<p>By accessing and using the NF Shop 24 website, you agree to be bound by these Terms and Conditions.</p>

<h2>2. Account Registration</h2>
<p>When you create an account with us, you must provide accurate and complete information. You are responsible for maintaining the confidentiality of your account credentials.</p>

<h2>3. Products &amp; Pricing</h2>
<ul>
  <li>All product images are for illustration purposes. Actual products may vary slightly.</li>
  <li>Prices are listed in Bangladeshi Taka (BDT) and are subject to change without notice.</li>
  <li>We reserve the right to modify or discontinue any product without prior notice.</li>
</ul>

<h2>4. Orders</h2>
<ul>
  <li>Placing an order constitutes an offer to purchase. We reserve the right to accept or decline any order.</li>
  <li>We may cancel orders due to stock unavailability, pricing errors, or suspected fraud.</li>
</ul>

<h2>5. Payment</h2>
<p>We accept Cash on Delivery (COD), bKash, Nagad, Rocket, and Bank Transfer.</p>

<h2>6. Shipping &amp; Delivery</h2>
<ul>
  <li>Delivery time: 2–5 business days within Bangladesh.</li>
  <li>Free shipping on orders above TK 500.</li>
</ul>

<h2>7. Intellectual Property</h2>
<p>All content on this website is the property of NF Shop 24 and protected by applicable intellectual property laws.</p>

<h2>8. Governing Law</h2>
<p>These terms shall be governed by the laws of Bangladesh.</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug'              => 'refund-policy',
                'title'             => 'Refund & Return Policy',
                'subtitle'          => 'Our commitment to your satisfaction',
                'icon'              => 'fas fa-undo-alt',
                'last_updated_label'=> 'May 8, 2026',
                'content'           => '<h2>1. Overview</h2>
<p>At NF Shop 24, customer satisfaction is our top priority. If you are not satisfied with your purchase, we are here to help.</p>

<h2>2. Return Eligibility</h2>
<ul>
  <li>Request must be made within <strong>7 days</strong> of delivery</li>
  <li>Product must be unused and in its original packaging</li>
  <li>All accessories and tags must be included</li>
  <li>Proof of purchase (order ID) must be provided</li>
</ul>

<h2>3. Non-Returnable Items</h2>
<ul>
  <li>Perishable goods</li>
  <li>Personal care items</li>
  <li>Customized or personalized products</li>
  <li>Digital/downloadable products</li>
  <li>Products with broken seals</li>
</ul>

<h2>4. Return Process</h2>
<ol>
  <li><strong>Contact us</strong> within 7 days of delivery with your order ID.</li>
  <li><strong>Get approval</strong> — our team will review your request.</li>
  <li><strong>Ship the product</strong> back in original packaging.</li>
  <li><strong>Refund/Replacement</strong> processed within 5–7 business days.</li>
</ol>

<h2>5. Refund Options</h2>
<ul>
  <li><strong>Full Refund</strong> — returned via original payment method</li>
  <li><strong>Store Credit</strong> — for future purchases</li>
  <li><strong>Replacement</strong> — same product sent again if defective</li>
</ul>

<h2>6. Cancellation Policy</h2>
<ul>
  <li>Orders can be canceled within 24 hours of placement.</li>
  <li>Orders that have already been shipped cannot be canceled.</li>
</ul>

<h2>7. Contact Us</h2>
<p>Phone: +8801820834086 | Email: info@nfshop24.com</p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
