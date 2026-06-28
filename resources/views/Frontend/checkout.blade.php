@extends('Frontend.Layout.app')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart') }}">Cart</a>
        <i class="fas fa-chevron-right"></i>
        <span>Checkout</span>
    </div>
</section>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><i class="fas fa-credit-card"></i> Checkout</h1>
        <p>Complete your order</p>
    </div>
</section>

<!-- Checkout Section -->
<section class="checkout-section">
    <div class="container">
        <div class="checkout-empty" id="checkoutEmpty">
            <div class="cart-empty-icon"><i class="fas fa-shopping-cart"></i></div>
            <h2>Your cart is empty</h2>
            <p>Add some products to your cart before checking out.</p>
            <a href="{{ route('all-products') }}" class="btn-order-lg"><i class="fas fa-store"></i> Browse Products</a>
        </div>

        <div class="checkout-layout" id="checkoutLayout">
            <!-- Left: Billing Form -->
            <div class="checkout-form-wrap">
                <form class="checkout-form" id="checkoutForm" onsubmit="return placeOrder(event)">
                    <div class="co-section">
                        <h3><i class="fas fa-user"></i> Contact Information</h3>
                        <div class="form-row-2">
                            <div class="form-group">
                                <label><i class="fas fa-user"></i> Full Name</label>
                                <input type="text" id="coName" placeholder="Your full name" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fas fa-phone"></i> Phone Number</label>
                                <input type="tel" id="coPhone" placeholder="01XXXXXXXXX" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email (Optional)</label>
                            <input type="email" id="coEmail" placeholder="your@email.com">
                        </div>
                    </div>

                    <div class="co-section">
                        <h3><i class="fas fa-map-marker-alt"></i> Shipping Address</h3>
                        <div class="form-group">
                            <label><i class="fas fa-location-dot"></i> Address</label>
                            <textarea id="coAddress" rows="3" placeholder="House, Road, Area" required></textarea>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-city"></i> City</label>
                            <input type="text" id="coCity" placeholder="Dhaka" required>
                        </div>
                    </div>

                    <div class="co-section">
                        <h3><i class="fas fa-credit-card"></i> Payment Method</h3>
                        <div class="co-payment-options">
                            <label class="co-payment-option active" onclick="selectPayment(this, 'cod')">
                                <input type="radio" name="payment" value="cod" checked hidden>
                                <i class="fas fa-money-bill-wave"></i>
                                <div>
                                    <strong>Cash on Delivery</strong>
                                    <span>Pay when you receive</span>
                                </div>
                            </label>
                            
                            <label class="co-payment-option uddoktapay-option" onclick="selectPayment(this, 'uddoktapay')">
                                <input type="radio" name="payment" value="uddoktapay" hidden>
                                <i class="fas fa-bolt" style="color:#e85d04"></i>
                                <div>
                                    <strong>UddoktaPay</strong>
                                    <span>Pay online — bKash, Nagad, Card & more</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="co-section">
                        <h3><i class="fas fa-sticky-note"></i> Order Note (Optional)</h3>
                        <div class="form-group">
                            <textarea id="coNote" rows="3" placeholder="Any special instructions for your order..."></textarea>
                        </div>
                    </div>

                    <div class="co-section co-section-mobile-total">
                        <div class="co-mobile-summary" id="coMobileSummary">
                            <div class="co-mobile-row"><span>Subtotal</span><span id="coMobileSubtotal">TK 0</span></div>
                            <div class="co-mobile-row"><span>Shipping</span><span id="coMobileShipping">TK 0</span></div>
                            <div class="co-mobile-row co-mobile-total-row"><span>Total</span><span id="coMobileTotal">TK 0</span></div>
                        </div>
                        <button type="submit" class="btn-auth"><i class="fas fa-lock"></i> Place Order</button>
                    </div>
                </form>
            </div>

            <!-- Right: Order Summary -->
            <aside class="checkout-summary" id="checkoutSummary">
                <h3><i class="fas fa-shopping-bag"></i> Order Summary</h3>
                <div class="co-summary-items" id="coSummaryItems"></div>
                <div class="co-summary-rows">
                    <div class="co-summary-row"><span>Subtotal</span><span id="coSubtotal">TK 0</span></div>
                    <div class="co-summary-row"><span>Shipping</span><span id="coShipping">TK 0</span></div>
                    <div class="co-summary-row" id="coDiscountRow" style="display:none"><span>Discount</span><span id="coDiscount" style="color:#22c55e">-TK 0</span></div>
                    <div class="co-summary-row co-summary-total"><span>Total</span><span id="coTotal">TK 0</span></div>
                </div>
                <button type="submit" form="checkoutForm" class="btn-checkout"><i class="fas fa-lock"></i> Place Order</button>
                <a href="{{ route('cart') }}" class="continue-shopping"><i class="fas fa-arrow-left"></i> Back to Cart</a>

                <div class="co-payment-icons">
                    <span>We accept:</span>
                    <i class="fas fa-money-bill-wave" title="Cash on Delivery"></i>
                    <i class="fas fa-mobile-alt" title="bKash / Nagad / Rocket"></i>
                    <i class="fas fa-university" title="Bank Transfer"></i>
                </div>
            </aside>
        </div>

    </div>
</section>

<script>
    window.NF_PRODUCTS = @json($products);
    window.NF_COUPONS = @json($coupons);
    window.NF_ORDER_STORE_URL = @json(route('orders.store'));
    window.NF_ORDER_COMPLETE_URL = @json(route('order-complete'));
    window.NF_CSRF = @json(csrf_token());
    window.NF_RECAPTCHA_SITE_KEY = @json(config('services.recaptcha.site_key'));
</script>
@if(config('services.recaptcha.site_key'))
<script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site_key') }}"></script>
@endif
@endsection
