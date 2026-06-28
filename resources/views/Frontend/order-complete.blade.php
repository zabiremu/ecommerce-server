@extends('Frontend.Layout.app')

@php
    use Illuminate\Support\Facades\Storage;

    $paymentLabels = [
        'cod'        => 'Cash on Delivery',
        'bkash'      => 'bKash',
        'nagad'      => 'Nagad',
        'rocket'     => 'Rocket',
        'bank'       => 'Bank Transfer',
        'uddoktapay' => 'UddoktaPay',
    ];

    if (!empty($order)) {
        $placedAt = $order->placed_at ?? $order->created_at;
        $estDate  = $placedAt
            ? $placedAt->copy()->addDays($order->status === 'delivered' ? 0 : 5)
            : null;
        $paymentLabel = $paymentLabels[$order->payment_method] ?? $order->payment_method;
        $cityLine = trim(
            ($order->shipping_area ? $order->shipping_area . ', ' : '') . ($order->shipping_city ?? ''),
            ', '
        );
    }
@endphp

@section('content')
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('cart') }}">Cart</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('checkout') }}">Checkout</a>
        <i class="fas fa-chevron-right"></i>
        <span>Order Complete</span>
    </div>
</section>

<!-- Order Complete Section -->
<section class="oc-section">
    <div class="container">

        @if (empty($order))
            <div class="oc-empty" id="ocEmpty" style="display:block">
                <div class="cart-empty-icon"><i class="fas fa-exclamation-circle"></i></div>
                <h2>Order not found</h2>
                <p>We couldn't find an order with that ID. Please check your order confirmation or try again.</p>
                <a href="{{ route('home') }}" class="btn-order-lg"><i class="fas fa-store"></i> Continue Shopping</a>
            </div>
        @else
            <div class="oc-content" id="ocContent" style="display:block">
                <!-- Success Header -->
                <div class="oc-header">
                    <div class="oc-success-icon"><i class="fas fa-check-circle"></i></div>
                    <h1>Order Placed Successfully!</h1>
                    <p>Thank you for your order, {{ $order->shipping_name }}. We'll confirm it shortly.</p>
                </div>

                <!-- Order Info Bar -->
                <div class="oc-order-bar">
                    <div class="oc-bar-left">
                        <span class="oc-bar-label">Order ID</span>
                        <span class="oc-bar-value" id="ocOrderId">{{ $order->order_no }}</span>
                    </div>
                    <div class="oc-bar-divider"></div>
                    <div class="oc-bar-left">
                        <span class="oc-bar-label">Placed on</span>
                        <span class="oc-bar-value" id="ocDate">{{ optional($placedAt)->format('M j, Y') }}</span>
                    </div>
                    <div class="oc-bar-divider"></div>
                    <div class="oc-bar-left">
                        <span class="oc-bar-label">Estimated Delivery</span>
                        <span class="oc-bar-value" id="ocEst">{{ optional($estDate)->format('M j, Y') ?? '—' }}</span>
                    </div>
                    <div class="oc-bar-divider"></div>
                    <div class="oc-bar-left">
                        <span class="oc-bar-label">Payment</span>
                        <span class="oc-bar-value" id="ocPayment">{{ $paymentLabel }}</span>
                    </div>
                </div>

                <!-- Two Column Layout -->
                <div class="oc-layout">
                    <!-- Left: Items -->
                    <div class="oc-items-wrap">
                        <h3 class="oc-section-title"><i class="fas fa-box"></i> Order Items</h3>
                        <div class="oc-items" id="ocItems">
                            @foreach ($order->items as $item)
                                @php
                                    $thumbUrl = $item->thumbnail ? Storage::url($item->thumbnail) : null;
                                    $lineTotal = (float) $item->total ?: ((float) $item->unit_price * (float) $item->quantity);
                                @endphp
                                <div class="oc-item">
                                    <div class="oc-item-img">
                                        @if ($thumbUrl)
                                            <img src="{{ $thumbUrl }}" alt="{{ $item->product_name }}">
                                        @else
                                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:#f1f5f9;color:#94a3b8"><i class="fas fa-box" style="font-size:24px"></i></div>
                                        @endif
                                    </div>
                                    <div class="oc-item-info">
                                        <div class="oc-item-title">{{ $item->product_name }}</div>
                                        <div class="oc-item-meta">
                                            Qty: {{ rtrim(rtrim(number_format($item->quantity, 2), '0'), '.') }}
                                            x TK {{ number_format((float) $item->unit_price) }}
                                        </div>
                                    </div>
                                    <div class="oc-item-total">TK {{ number_format($lineTotal) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="oc-totals">
                            <div class="oc-total-row"><span>Subtotal</span><span id="ocSubtotal">TK {{ number_format((float) $order->subtotal) }}</span></div>
                            <div class="oc-total-row">
                                <span>Shipping</span>
                                <span id="ocShipping">{{ (float) $order->shipping_charge === 0.0 ? 'FREE' : 'TK ' . number_format((float) $order->shipping_charge) }}</span>
                            </div>
                            @if ((float) $order->discount > 0)
                                <div class="oc-total-row oc-total-row-disc" id="ocDiscountRow" style="display:flex">
                                    <span>Discount</span>
                                    <span id="ocDiscount" style="color:#22c55e">-TK {{ number_format((float) $order->discount) }}</span>
                                </div>
                            @endif
                            <div class="oc-total-row oc-total-final"><span>Total</span><span id="ocTotal">TK {{ number_format((float) $order->total) }}</span></div>
                        </div>

                        @if ($order->notes)
                            <div class="oc-note" id="ocNoteWrap" style="display:block">
                                <h4><i class="fas fa-sticky-note"></i> Order Note</h4>
                                <p id="ocNote">{{ $order->notes }}</p>
                            </div>
                        @endif
                    </div>

                    <!-- Right: Shipping & Actions -->
                    <div class="oc-sidebar">
                        <div class="oc-card">
                            <h4><i class="fas fa-map-marker-alt"></i> Shipping Address</h4>
                            <div class="oc-address" id="ocAddress">
                                {{ $order->shipping_name }}<br>
                                {{ $order->shipping_phone }}<br>
                                {{ $order->shipping_address }}<br>
                                {{ $cityLine }}
                            </div>
                        </div>
                        <div class="oc-card">
                            <h4><i class="fas fa-credit-card"></i> Payment Method</h4>
                            <p id="ocPaymentMethod">
                                {{ $paymentLabel }}
                                <span style="display:inline-block;margin-left:6px;padding:2px 10px;border-radius:100px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.3px;background:{{ $order->payment_status === 'paid' ? '#dcfce7' : ($order->payment_status === 'refunded' ? '#f3e8ff' : '#fef3c7') }};color:{{ $order->payment_status === 'paid' ? '#15803d' : ($order->payment_status === 'refunded' ? '#7e22ce' : '#b45309') }}">
                                    {{ $order->payment_status }}
                                </span>
                            </p>
                        </div>
                        <div class="oc-actions">
                            <a href="{{ route('track-order') }}?id={{ $order->order_no }}" class="btn-auth"><i class="fas fa-truck"></i> Track Order</a>
                            <a href="{{ route('all-products') }}" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
    window.NF_ORDER_SERVER_RENDERED = true;
    document.title = @json(!empty($order) ? 'Order ' . $order->order_no . ' - NF Shop 24' : 'Order Complete - NF Shop 24');
</script>
@endsection
