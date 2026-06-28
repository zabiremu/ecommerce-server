@extends('Frontend.Layout.app')

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>Cart</span>
    </div>
</section>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <h1><i class="fas fa-shopping-cart"></i> Shopping Cart</h1>
        <p id="cartHeaderDesc">Review and manage your items</p>
    </div>
</section>

<!-- Cart Content -->
<section class="cart-section">
    <div class="container">
        <div class="cart-layout" id="cartLayout">
            <!-- Cart Items -->
            <div class="cart-items" id="cartItems"></div>

            <!-- Order Summary -->
            <aside class="cart-summary" id="cartSummary">
                <h3>Order Summary</h3>
                <div class="summary-rows" id="summaryRows">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotalAmt">TK 0</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span id="shippingAmt">TK 0</span>
                    </div>
                    <div class="summary-row discount-row" id="discountRow" style="display:none">
                        <span>Discount</span>
                        <span id="discountAmt" style="color:#22c55e">-TK 0</span>
                    </div>
                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span id="totalAmt">TK 0</span>
                    </div>
                </div>

                <div class="coupon-box">
                    <input type="text" placeholder="Coupon code" id="couponInput">
                    <button onclick="applyCoupon()">Apply</button>
                </div>
                <div id="couponMsg" class="coupon-msg"></div>

                <a href="{{ route('checkout') }}" class="btn-checkout"><i class="fas fa-lock"></i> Proceed to Checkout</a>

                <div class="payment-icons">
                    <span>We accept:</span>
                    <i class="fas fa-money-bill-wave" title="Cash on Delivery"></i>
                    <i class="fas fa-mobile-alt" title="bKash / Nagad / Rocket"></i>
                    <i class="fas fa-university" title="Bank Transfer"></i>
                </div>

                <a href="{{ route('all-products') }}" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
            </aside>
        </div>

        <!-- Empty Cart (hidden by default) -->
        <div class="cart-empty" id="cartEmpty">
            <div class="cart-empty-icon"><i class="fas fa-shopping-cart"></i></div>
            <h2>Your cart is empty</h2>
            <p>Looks like you haven't added any products yet. Start shopping to fill your cart!</p>
            <a href="{{ route('all-products') }}" class="btn-order-lg"><i class="fas fa-store"></i> Browse Products</a>
        </div>
    </div>
</section>

<script>
    window.NF_PRODUCTS = @json($products);
    window.NF_COUPONS = @json($coupons);
    window.NF_CSRF = @json(csrf_token());
</script>
@endsection
