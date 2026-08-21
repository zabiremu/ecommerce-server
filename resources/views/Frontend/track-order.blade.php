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

<section class="trk-section">
    <div class="trk-bg-shapes" aria-hidden="true">
        <div class="trk-shape trk-shape-1"></div>
        <div class="trk-shape trk-shape-2"></div>
    </div>
    <div class="container">
        <div class="trk-search" id="trkSearch">
            <div class="trk-card trk-card-search">
                <div class="trk-card-badge"><i class="fas fa-satellite-dish"></i> Real-time tracking</div>
                <div class="trk-card-icon"><i class="fas fa-search-location"></i></div>
                <h2>Track Your Package</h2>
                <p>Enter your order ID to see real-time delivery status updates</p>
                <div class="trk-input-wrap">
                    <span class="trk-input-icon"><i class="fas fa-box"></i></span>
                    <input type="text" id="orderInput" placeholder="e.g. NF-20260821-439" value="{{ request('id') }}" onkeydown="if(event.key==='Enter')trackOrder()" autocomplete="off">
                    <button type="button" onclick="trackOrder()"><span>Track</span> <i class="fas fa-arrow-right"></i></button>
                </div>

                @if($recentOrders->isNotEmpty())
                    <div class="trk-samples">
                        <span>Your recent orders:</span>
                        @foreach($recentOrders as $o)
                            <button type="button" onclick="document.getElementById('orderInput').value='{{ $o->order_no }}';trackOrder()">
                                <i class="fas {{ ['pending'=>'fa-clock','confirmed'=>'fa-check','processing'=>'fa-cog','shipped'=>'fa-shipping-fast','delivered'=>'fa-check-circle','cancelled'=>'fa-times-circle','returned'=>'fa-undo'][$o->status] ?? 'fa-clock' }}"></i>
                                {{ $o->order_no }}
                            </button>
                        @endforeach
                    </div>
                @endif

                <div class="trk-hint">
                    <i class="fas fa-info-circle"></i> Find your order ID in the order confirmation email or your <a href="{{ route('dashboard') }}">dashboard</a>.
                </div>
            </div>
        </div>

        <div class="trk-result" id="trkResult" style="display:none"></div>
    </div>
</section>

<style>
:root{
    --trk-red:#E63946;
    --trk-red-dark:#C5303C;
    --trk-ink:#1A1A1A;
    --trk-title:#242424;
    --trk-text:#5B5B5B;
    --trk-text-light:#8A8A8A;
    --trk-line:#ECECEC;
    --trk-bg-soft:#F7F7F7;
    --trk-radius:14px;
    --trk-radius-sm:8px;
    --trk-shadow:0 10px 32px rgba(26,26,26,.08);
    --trk-shadow-lg:0 20px 50px rgba(26,26,26,.12);
    --trk-ease:220ms cubic-bezier(.4,0,.2,1);
}

.trk-section{position:relative;padding:56px 0 90px;overflow:hidden;background:var(--trk-bg-soft);}
.trk-bg-shapes{position:absolute;inset:0;pointer-events:none;z-index:0;}
.trk-shape{position:absolute;border-radius:50%;opacity:.08;background:var(--trk-red);}
.trk-shape-1{width:420px;height:420px;top:-180px;right:-140px;}
.trk-shape-2{width:280px;height:280px;bottom:-120px;left:-100px;background:var(--trk-ink);}

.trk-search{position:relative;z-index:1;}
.trk-card{background:#fff;border-radius:var(--trk-radius);box-shadow:var(--trk-shadow);}
.trk-card-search{max-width:600px;margin:0 auto;padding:44px 40px 36px;text-align:center;position:relative;}

.trk-card-badge{
    display:inline-flex;align-items:center;gap:6px;
    padding:6px 14px;margin-bottom:20px;
    background:#FDECEC;color:var(--trk-red-dark);
    font-size:12px;font-weight:700;letter-spacing:.02em;
    border-radius:999px;
}
.trk-card-badge i{font-size:10px;}

.trk-card-icon{
    width:72px;height:72px;margin:0 auto 20px;
    display:flex;align-items:center;justify-content:center;
    border-radius:50%;
    background:linear-gradient(135deg,var(--trk-red),var(--trk-red-dark));
    color:#fff;font-size:28px;
    box-shadow:0 10px 24px rgba(230,57,70,.32);
}

.trk-card-search h2{margin:0 0 8px;font-size:1.5em;font-weight:800;color:var(--trk-title);}
.trk-card-search > p{margin:0 0 28px;color:var(--trk-text);font-size:.95em;}

.trk-input-wrap{
    display:flex;align-items:stretch;
    border:2px solid var(--trk-line);
    border-radius:999px;
    padding:5px 5px 5px 20px;
    transition:border-color var(--trk-ease), box-shadow var(--trk-ease);
}
.trk-input-wrap:focus-within{border-color:var(--trk-red);box-shadow:0 0 0 4px rgba(230,57,70,.1);}
.trk-input-icon{display:flex;align-items:center;color:var(--trk-text-light);margin-right:10px;font-size:15px;}
.trk-input-wrap input{
    flex:1;border:none;outline:none;background:none;
    font-size:15px;color:var(--trk-title);min-width:0;
}
.trk-input-wrap input::placeholder{color:var(--trk-text-light);}
.trk-input-wrap button{
    display:flex;align-items:center;gap:8px;
    padding:0 24px;border:none;border-radius:999px;
    background:linear-gradient(135deg,var(--trk-red),var(--trk-red-dark));
    color:#fff;font-weight:700;font-size:14px;
    cursor:pointer;transition:transform var(--trk-ease), box-shadow var(--trk-ease);
    white-space:nowrap;
}
.trk-input-wrap button:hover{transform:translateY(-1px);box-shadow:0 8px 18px rgba(230,57,70,.35);}
.trk-input-wrap button:active{transform:translateY(0);}

.trk-samples{display:flex;flex-wrap:wrap;align-items:center;gap:8px;justify-content:center;margin-top:20px;}
.trk-samples span{font-size:12px;color:var(--trk-text-light);margin-right:2px;}
.trk-samples button{
    display:inline-flex;align-items:center;gap:6px;
    padding:6px 13px;border:1px solid var(--trk-line);border-radius:999px;
    background:#fff;color:var(--trk-text);font-size:12px;font-weight:600;
    cursor:pointer;transition:all var(--trk-ease);
}
.trk-samples button:hover{border-color:var(--trk-red);color:var(--trk-red-dark);background:#FDECEC;}
.trk-samples button i{font-size:10px;color:var(--trk-red);}

.trk-hint{
    display:flex;align-items:center;justify-content:center;gap:8px;
    margin-top:26px;padding-top:22px;border-top:1px solid var(--trk-line);
    font-size:12.5px;color:var(--trk-text-light);
}
.trk-hint i{color:var(--trk-red);}
.trk-hint a{color:var(--trk-red-dark);font-weight:600;text-decoration:none;}
.trk-hint a:hover{text-decoration:underline;}

/* ── Result state ─────────────────────────────────────── */
.trk-result{margin-top:36px;display:flex;flex-direction:column;gap:22px;}
.trk-result > .trk-card{max-width:600px;margin:0 auto;padding:48px 32px;text-align:center;}
.trk-result > .trk-card h2{margin:22px 0 8px;font-size:1.35em;font-weight:800;color:var(--trk-title);}
.trk-result > .trk-card p{margin:0;color:var(--trk-text);font-size:.95em;}
.trk-result > .trk-card .btn-auth{
    display:inline-flex;align-items:center;gap:8px;margin-top:24px;
    padding:12px 26px;border:none;border-radius:999px;cursor:pointer;
    background:linear-gradient(135deg,var(--trk-red),var(--trk-red-dark));
    color:#fff;font-weight:700;font-size:14px;
}

.trk-order-bar{
    display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px;
    background:#fff;border-radius:var(--trk-radius);box-shadow:var(--trk-shadow);
    padding:26px 30px;
}
.trk-order-bar h3{margin:0 0 4px;font-size:1.25em;font-weight:800;color:var(--trk-title);}
.trk-order-bar .ob-left p{margin:0;font-size:13px;color:var(--trk-text-light);}
.trk-order-bar .ob-right{text-align:right;}
.trk-status-badge{
    display:inline-flex;align-items:center;gap:7px;
    padding:8px 16px;border-radius:999px;font-size:13px;font-weight:800;
    text-transform:uppercase;letter-spacing:.02em;
}
.trk-order-bar .ob-est{font-size:12px;color:var(--trk-text-light);margin-top:6px;}

.trk-block{background:#fff;border-radius:var(--trk-radius);box-shadow:var(--trk-shadow);padding:30px;}
.trk-block h3{
    display:flex;align-items:center;gap:10px;
    margin:0 0 24px;font-size:1.05em;font-weight:800;color:var(--trk-title);
}
.trk-block h3 i{color:var(--trk-red);}

/* Timeline */
.trk-timeline-track{display:flex;flex-direction:column;}
.trk-tl-step{display:flex;gap:18px;position:relative;padding-bottom:26px;}
.trk-tl-step:last-child{padding-bottom:0;}
.trk-tl-step::before{
    content:'';position:absolute;left:19px;top:40px;bottom:0;width:2px;
    background:var(--trk-line);
}
.trk-tl-step:last-child::before{display:none;}
.trk-tl-step.trk-done::before{background:var(--trk-red);}
.trk-tl-dot{
    flex-shrink:0;width:40px;height:40px;border-radius:50%;
    display:flex;align-items:center;justify-content:center;font-size:15px;
    background:var(--trk-bg-soft);color:var(--trk-text-light);
    border:2px solid var(--trk-line);z-index:1;transition:all var(--trk-ease);
}
.trk-tl-step.trk-done .trk-tl-dot{
    background:linear-gradient(135deg,var(--trk-red),var(--trk-red-dark));
    color:#fff;border-color:transparent;
    box-shadow:0 6px 14px rgba(230,57,70,.3);
}
.trk-tl-step.trk-active .trk-tl-dot{
    background:#fff;color:var(--trk-red);border-color:var(--trk-red);
    animation:trkPulse 1.6s ease-in-out infinite;
}
@keyframes trkPulse{
    0%,100%{box-shadow:0 0 0 0 rgba(230,57,70,.28);}
    50%{box-shadow:0 0 0 8px rgba(230,57,70,0);}
}
.trk-tl-info{padding-top:6px;}
.trk-tl-info h4{margin:0 0 3px;font-size:14.5px;font-weight:700;color:var(--trk-title);}
.trk-tl-step:not(.trk-done) .trk-tl-info h4{color:var(--trk-text-light);}
.trk-tl-info p{margin:0;font-size:12.5px;color:var(--trk-text-light);}

/* Items */
.trk-item{display:flex;align-items:center;gap:14px;padding:14px 0;border-bottom:1px solid var(--trk-line);}
.trk-item:last-of-type{border-bottom:none;}
.trk-item-img{
    width:56px;height:56px;flex-shrink:0;border-radius:var(--trk-radius-sm);
    overflow:hidden;background:var(--trk-bg-soft);
    display:flex;align-items:center;justify-content:center;
}
.trk-item-img img{width:100%;height:100%;object-fit:cover;}
.trk-item-info{flex:1;min-width:0;}
.trk-item-info h4{margin:0 0 3px;font-size:14px;font-weight:700;color:var(--trk-title);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;}
.trk-item-info p{margin:0;font-size:12.5px;color:var(--trk-text-light);}
.trk-item-total{font-weight:800;font-size:14px;color:var(--trk-title);white-space:nowrap;}

.trk-summary-row{display:flex;justify-content:space-between;padding:7px 0;font-size:13.5px;color:var(--trk-text);}
.trk-summary-row.trk-discount{color:#16a34a;}
.trk-summary-row.trk-total{
    padding-top:14px;margin-top:6px;border-top:2px solid var(--trk-line);
    font-size:17px;font-weight:800;color:var(--trk-title);
}
.trk-summary-row.trk-total span:last-child{color:var(--trk-red-dark);}
.trk-summary-row span:first-child{color:var(--trk-text-light);}
.trk-summary-row.trk-total span:first-child{color:var(--trk-title);}

/* Delivery details */
.trk-delivery-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:20px;}
.trk-delivery-item h4{
    display:flex;align-items:center;gap:8px;
    margin:0 0 8px;font-size:12.5px;font-weight:700;
    text-transform:uppercase;letter-spacing:.03em;color:var(--trk-text-light);
}
.trk-delivery-item h4 i{color:var(--trk-red);font-size:12px;}
.trk-delivery-item p{margin:0;font-size:14px;color:var(--trk-title);line-height:1.55;}

@media(max-width:640px){
    .trk-card-search{padding:32px 22px 26px;}
    .trk-input-wrap{flex-wrap:wrap;border-radius:20px;padding:14px;}
    .trk-input-wrap input{width:100%;padding:8px 0;}
    .trk-input-wrap button{width:100%;justify-content:center;padding:12px;margin-top:8px;}
    .trk-order-bar{flex-direction:column;align-items:flex-start;}
    .trk-order-bar .ob-right{text-align:left;}
    .trk-block{padding:22px;}
}
</style>

<script>
window.NF_TRACK_LOOKUP_URL = @json(route('track-order.lookup'));

const trkStatusMeta = {
    pending:    { label: 'Pending',    color: '#b45309', bg: '#fef3c7', icon: 'fa-clock' },
    confirmed:  { label: 'Confirmed',  color: '#1d4ed8', bg: '#dbeafe', icon: 'fa-check' },
    processing: { label: 'Processing', color: '#4338ca', bg: '#e0e7ff', icon: 'fa-cog' },
    shipped:    { label: 'Shipped',    color: '#0891b2', bg: '#cffafe', icon: 'fa-shipping-fast' },
    delivered:  { label: 'Delivered',  color: '#15803d', bg: '#dcfce7', icon: 'fa-check-circle' },
    cancelled:  { label: 'Cancelled',  color: '#b91c1c', bg: '#fee2e2', icon: 'fa-times-circle' },
    returned:   { label: 'Returned',   color: '#475569', bg: '#f1f5f9', icon: 'fa-undo' },
};

function trkEscape(s) {
    return String(s == null ? '' : s).replace(/[&<>"']/g, c => ({ '&':'&amp;', '<':'&lt;', '>':'&gt;', '"':'&quot;', "'":'&#39;' }[c]));
}

async function trackOrder() {
    const inp = document.getElementById('orderInput');
    const id = inp ? inp.value.trim().toUpperCase() : '';
    const result = document.getElementById('trkResult');
    if (!id) { alert('Please enter an order ID.'); return; }

    result.style.display = 'flex';
    result.innerHTML = `
        <div class="trk-card">
            <div class="trk-card-icon"><i class="fas fa-circle-notch fa-spin"></i></div>
            <h2>Looking up your order...</h2>
            <p>Fetching the latest status for <strong>${trkEscape(id)}</strong></p>
        </div>
    `;

    const url = (window.NF_TRACK_LOOKUP_URL || '/track-order/lookup') + '?id=' + encodeURIComponent(id);
    try {
        const res = await fetch(url, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await res.json().catch(() => ({}));
        if (!res.ok || !data.success || !data.order) {
            result.innerHTML = `
                <div class="trk-card">
                    <div class="trk-card-icon" style="background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 10px 24px rgba(239,68,68,.32)"><i class="fas fa-exclamation-circle"></i></div>
                    <h2>Order Not Found</h2>
                    <p>${trkEscape(data.message || ('No order found with ID "' + id + '".'))}<br>Please check the ID and try again.</p>
                    <button type="button" class="btn-auth" onclick="document.getElementById('trkResult').style.display='none';document.getElementById('orderInput').value='';document.getElementById('orderInput').focus()"><i class="fas fa-redo"></i> Try Again</button>
                </div>
            `;
            window.scrollTo({ top: result.offsetTop - 140, behavior: 'smooth' });
            return;
        }
        renderTrackResult(data.order);
    } catch (err) {
        result.innerHTML = `
            <div class="trk-card">
                <div class="trk-card-icon" style="background:linear-gradient(135deg,#ef4444,#dc2626);box-shadow:0 10px 24px rgba(239,68,68,.32)"><i class="fas fa-wifi"></i></div>
                <h2>Connection Error</h2>
                <p>Could not reach the server. Please check your connection and try again.</p>
                <button type="button" class="btn-auth" onclick="trackOrder()"><i class="fas fa-redo"></i> Retry</button>
            </div>
        `;
    }
}

function renderTrackResult(order) {
    const result = document.getElementById('trkResult');
    const sm = trkStatusMeta[order.status] || { label: order.status, color: '#64748b', bg: '#f1f5f9', icon: 'fa-clock' };
    const subtotal = parseFloat(order.subtotal || 0);
    const shipping = parseFloat(order.shipping || 0);
    const discount = parseFloat(order.discount || 0);
    const total = parseFloat(order.total || 0) || (subtotal + shipping - discount);
    const itemQty = Array.isArray(order.items) ? order.items.reduce((s, i) => s + parseFloat(i.qty || 0), 0) : 0;
    let activeAssigned = false;

    const timelineHtml = (order.timeline || []).map(t => {
        let cls = '';
        if (t.done) {
            cls = 'trk-done';
        } else if (!activeAssigned) {
            cls = 'trk-active';
            activeAssigned = true;
        }
        return `
            <div class="trk-tl-step ${cls}">
                <div class="trk-tl-dot"><i class="fas ${t.icon}"></i></div>
                <div class="trk-tl-info">
                    <h4>${trkEscape(t.label)}</h4>
                    <p>${trkEscape(t.date)}</p>
                </div>
            </div>
        `;
    }).join('');

    const itemsHtml = (order.items || []).map(i => {
        const lineTotal = parseFloat(i.total || 0) || (parseFloat(i.price || 0) * parseFloat(i.qty || 0));
        return `
            <div class="trk-item">
                <div class="trk-item-img">${i.thumbnail ? `<img src="${i.thumbnail}" alt="${trkEscape(i.title)}">` : '<i class="fas fa-box" style="color:#cbd5e1;font-size:22px"></i>'}</div>
                <div class="trk-item-info">
                    <h4>${trkEscape(i.title)}</h4>
                    <p>Qty: ${parseFloat(i.qty).toLocaleString()} &times; TK ${parseFloat(i.price).toLocaleString()}</p>
                </div>
                <div class="trk-item-total">TK ${lineTotal.toLocaleString()}</div>
            </div>
        `;
    }).join('');

    result.style.display = 'flex';
    result.innerHTML = `
        <div class="trk-order-bar">
            <div class="ob-left">
                <h3>${trkEscape(order.id)}</h3>
                <p>Placed on ${trkEscape(order.date || '-')} &middot; ${itemQty} item(s)</p>
            </div>
            <div class="ob-right">
                <span class="trk-status-badge" style="background:${sm.bg};color:${sm.color}"><i class="fas ${sm.icon}"></i> ${sm.label}</span>
                ${order.est ? `<p class="ob-est">Est. delivery: ${trkEscape(order.est)}</p>` : ''}
            </div>
        </div>

        <div class="trk-block">
            <h3><i class="fas fa-road"></i> Order Timeline</h3>
            <div class="trk-timeline-track">${timelineHtml}</div>
        </div>

        <div class="trk-block">
            <h3><i class="fas fa-box"></i> Order Items</h3>
            ${itemsHtml}
            <div class="trk-summary-row"><span>Subtotal</span><span>TK ${subtotal.toLocaleString()}</span></div>
            <div class="trk-summary-row"><span>Shipping</span><span>${shipping === 0 ? 'FREE' : 'TK ' + shipping.toLocaleString()}</span></div>
            ${discount > 0 ? `<div class="trk-summary-row trk-discount"><span>Discount</span><span>-TK ${discount.toLocaleString()}</span></div>` : ''}
            <div class="trk-summary-row trk-total"><span>Total</span><span>TK ${total.toLocaleString()}</span></div>
        </div>

        <div class="trk-block">
            <h3><i class="fas fa-map-marker-alt"></i> Delivery Details</h3>
            <div class="trk-delivery-grid">
                <div class="trk-delivery-item">
                    <h4><i class="fas fa-user"></i> Customer</h4>
                    <p>${trkEscape(order.address.name)}<br>${trkEscape(order.address.phone)}</p>
                </div>
                <div class="trk-delivery-item">
                    <h4><i class="fas fa-location-dot"></i> Shipping Address</h4>
                    <p>${trkEscape(order.address.addr)}<br>${trkEscape(order.address.city)}</p>
                </div>
                <div class="trk-delivery-item">
                    <h4><i class="fas fa-credit-card"></i> Payment</h4>
                    <p>${trkEscape(order.payment)}${order.payment_status ? ` <span style="font-size:11px;font-weight:800;text-transform:uppercase;color:${order.payment_status === 'paid' ? '#16a34a' : '#b45309'}">(${trkEscape(order.payment_status)})</span>` : ''}</p>
                </div>
                ${order.est ? `
                <div class="trk-delivery-item">
                    <h4><i class="fas fa-calendar"></i> Estimated Delivery</h4>
                    <p>${trkEscape(order.est)}</p>
                </div>` : ''}
            </div>
        </div>
    `;
    window.scrollTo({ top: result.offsetTop - 140, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function () {
    const inp = document.getElementById('orderInput');
    if (inp && inp.value.trim()) {
        trackOrder();
    }
});
</script>
@endsection
