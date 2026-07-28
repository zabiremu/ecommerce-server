<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('pages')->insert([
            'slug'    => 'faq',
            'title'   => 'Frequently Asked Questions',
            'subtitle'=> 'Answers to common questions about ordering, shipping, and returns',
            'icon'    => 'fas fa-circle-question',
            'content' => '<h2>Ordering</h2>
<h3>How do I place an order?</h3>
<p>Browse our products, add the items you want to your cart, and proceed to checkout. Fill in your delivery details and choose a payment method to confirm your order.</p>
<h3>Can I change or cancel my order after placing it?</h3>
<p>Orders can be canceled within 24 hours of placement. Please contact us as soon as possible with your order ID — once an order has shipped, it can no longer be changed or canceled.</p>

<h2>Payment</h2>
<h3>What payment methods do you accept?</h3>
<p>We accept Cash on Delivery (COD), bKash, Nagad, Rocket, and Bank Transfer.</p>
<h3>Is it safe to pay online on your site?</h3>
<p>Yes. Online payments are processed securely through trusted third-party payment gateways — we never store your card or mobile banking credentials.</p>

<h2>Shipping &amp; Delivery</h2>
<h3>How long does delivery take?</h3>
<p>Delivery typically takes 2–5 business days within Bangladesh, depending on your location.</p>
<h3>Do you offer free shipping?</h3>
<p>Yes, we offer free shipping on orders above a minimum amount. The exact threshold is shown at checkout.</p>
<h3>How can I track my order?</h3>
<p>Use the <a href="' . url('/track-order') . '">Track Order</a> page with your order ID to check the latest status, or log in to your account to view your order history.</p>

<h2>Returns &amp; Refunds</h2>
<h3>What is your return policy?</h3>
<p>We accept returns within 7 days of delivery for unused products in their original packaging. See our full <a href="' . url('/refund-policy') . '">Refund &amp; Return Policy</a> for details.</p>
<h3>How long do refunds take?</h3>
<p>Once your return is approved, refunds or replacements are processed within 5–7 business days.</p>

<h2>Account</h2>
<h3>Do I need an account to place an order?</h3>
<p>No, you can check out as a guest. Creating an account lets you track orders, save your details for faster checkout, and view your order history.</p>
<h3>I forgot my password. What do I do?</h3>
<p>Use the "Forgot password" link on the login page to reset it via email.</p>

<h2>Still have questions?</h2>
<p>Reach out to us on our <a href="' . url('/contact') . '">Contact Us</a> page — we\'re happy to help.</p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('pages')->where('slug', 'faq')->delete();
    }
};
