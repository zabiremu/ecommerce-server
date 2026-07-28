{{-- Trust / payment badges. Labels are kept to what checkout.blade.php actually offers
     (Cash on Delivery, bKash, Nagad, and online payment via UddoktaPay) — no fabricated
     card-network branding, since there's no direct Visa/Mastercard gateway integrated. --}}
<div class="gms-trust-badges">
    <div class="gms-trust-badge gms-trust-badge-secure">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="4" y="10.5" width="16" height="10" rx="2" />
            <path d="M7.5 10.5V7a4.5 4.5 0 0 1 9 0v3.5" />
        </svg>
        <span>Secure Checkout</span>
    </div>
    <div class="gms-trust-badge">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="2" y="6" width="20" height="12" rx="2" />
            <circle cx="12" cy="12" r="2.5" />
        </svg>
        <span>Cash on Delivery</span>
    </div>
    <div class="gms-trust-badge">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="6" y="2" width="12" height="20" rx="2" />
            <line x1="6" y1="18" x2="18" y2="18" />
        </svg>
        <span>bKash</span>
    </div>
    <div class="gms-trust-badge">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="6" y="2" width="12" height="20" rx="2" />
            <line x1="6" y1="18" x2="18" y2="18" />
        </svg>
        <span>Nagad</span>
    </div>
    <div class="gms-trust-badge">
        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="2" y="5" width="20" height="14" rx="2" />
            <line x1="2" y1="10" x2="22" y2="10" />
        </svg>
        <span>Online Payment (UddoktaPay)</span>
    </div>
</div>
