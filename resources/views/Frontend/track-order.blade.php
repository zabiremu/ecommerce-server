@extends('Frontend.Layout.app')

@section('content')
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>Track Order</span>
    </div>
</section>

<section class="page-header">
    <div class="container">
        <h1><i class="fas fa-truck"></i> Track Your Order</h1>
        <p>Enter your order ID to check the delivery status</p>
    </div>
</section>

<section class="track-section">
    <div class="track-bg-shapes">
        <div class="tshape tshape-1"></div>
        <div class="tshape tshape-2"></div>
        <div class="tshape tshape-3"></div>
    </div>
    <div class="container">
        <div class="track-search" id="trackSearch">
            <div class="track-search-card">
                <div class="ts-card-badge"><i class="fas fa-check-circle"></i> Real-time tracking</div>
                <div class="ts-card-icon"><i class="fas fa-search-location"></i></div>
                <h2>Track Your Package</h2>
                <p>Enter your order ID to see real-time delivery status updates</p>
                <div class="track-input-wrap">
                    <span class="tiw-icon"><i class="fas fa-box"></i></span>
                    <input type="text" id="orderInput" placeholder="e.g. NF-20260508-001" value="{{ request('id') }}" onkeydown="if(event.key==='Enter')trackOrder()" autocomplete="off">
                    <button onclick="trackOrder()"><span>Track</span> <i class="fas fa-arrow-right"></i></button>
                </div>
                <div class="track-samples" id="trackSamples" style="display:none">
                    <span>Your recent orders:</span>
                </div>
                <div class="track-hint">
                    <i class="fas fa-info-circle"></i> Find your order ID in the order confirmation email or your <a href="{{ route('dashboard') }}">dashboard</a>.
                </div>
            </div>
        </div>

        <div class="track-result" id="trackResult" style="display:none"></div>
    </div>
</section>

<script>
    window.NF_TRACK_LOOKUP_URL = @json(route('track-order.lookup'));
</script>
@endsection
