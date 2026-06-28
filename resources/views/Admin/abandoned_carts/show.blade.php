@extends('Admin.Layout.app')

@section('title', 'Abandoned Cart Details')
@section('page_title', 'Abandoned Cart Details')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Abandoned Cart</h1>
    <a href="{{ route('admin.abandoned-carts.index') }}" class="wp-add-new">← Back</a>
</div>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-8 space-y-5">

        {{-- Logged-in User / Known Customer panel --}}
        @if ($cart->contact_name || $cart->contact_email || $cart->contact_phone)
            <div class="wp-panel border-l-4 {{ $customer ? 'border-[#2e7d32]' : 'border-[#2271b1]' }}">
                <div class="wp-panel-h flex items-center gap-2">
                    @if ($customer)
                        <i class="fas fa-user-check text-[#2e7d32] text-[13px]"></i>
                        <span>Known Customer</span>
                        <span class="ml-auto text-[11px] font-semibold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Registered</span>
                    @else
                        <i class="fas fa-user text-[#2271b1] text-[13px]"></i>
                        <span>Logged-in User</span>
                        <span class="ml-auto text-[11px] font-semibold bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">Identified</span>
                    @endif
                </div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 grid place-items-center text-white font-bold text-[15px] shrink-0">
                                {{ strtoupper(substr($cart->contact_name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-[13px] font-semibold text-[#1d2327]">{{ $cart->contact_name ?? 'Unknown' }}</p>
                                <p class="text-[11px] text-[#787c82]">Full Name</p>
                            </div>
                        </div>

                        @if ($cart->contact_phone)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 grid place-items-center text-green-700 shrink-0">
                                    <i class="fas fa-phone text-[13px]"></i>
                                </div>
                                <div>
                                    <a href="tel:{{ $cart->contact_phone }}" class="text-[13px] font-semibold text-[#2271b1] font-mono">{{ $cart->contact_phone }}</a>
                                    <p class="text-[11px] text-[#787c82]">Phone</p>
                                </div>
                            </div>
                        @endif

                        @if ($cart->contact_email)
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-orange-100 grid place-items-center text-orange-700 shrink-0">
                                    <i class="fas fa-envelope text-[13px]"></i>
                                </div>
                                <div>
                                    <a href="mailto:{{ $cart->contact_email }}" class="text-[13px] font-semibold text-[#2271b1]">{{ $cart->contact_email }}</a>
                                    <p class="text-[11px] text-[#787c82]">Email</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($customer)
                        <div class="mt-4 pt-4 border-t border-[#e2e4e7] flex flex-wrap items-center gap-4">
                            <div class="text-[12.5px] text-[#50575e]">
                                <i class="fas fa-shopping-bag mr-1 text-[#787c82]"></i>
                                <strong>{{ $customer->total_orders }}</strong> total order{{ $customer->total_orders !== 1 ? 's' : '' }}
                            </div>
                            <div class="text-[12.5px] text-[#50575e]">
                                <i class="fas fa-taka-sign mr-1 text-[#787c82]"></i>
                                Total spent: <strong>৳{{ number_format($customer->total_spent, 2) }}</strong>
                            </div>
                            @if ($customer->last_order_at)
                                <div class="text-[12.5px] text-[#50575e]">
                                    <i class="fas fa-clock mr-1 text-[#787c82]"></i>
                                    Last order: <strong>{{ \Carbon\Carbon::parse($customer->last_order_at)->diffForHumans() }}</strong>
                                </div>
                            @endif
                            <a href="{{ route('admin.customers.show', $customer) }}" class="ml-auto text-[12px] text-[#2271b1] hover:text-[#135e96] font-medium">
                                <i class="fas fa-external-link-alt mr-1"></i> View Customer Profile
                            </a>
                        </div>

                        @if ($customer->address)
                            <div class="mt-3 px-3 py-2 bg-[#f6f7f7] rounded text-[12px] text-[#50575e]">
                                <i class="fas fa-map-marker-alt mr-1 text-[#787c82]"></i>
                                {{ $customer->address }}{{ $customer->area ? ', ' . $customer->area : '' }}{{ $customer->city ? ', ' . $customer->city : '' }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        {{-- Cart Items --}}
        <div class="wp-panel">
            <div class="wp-panel-h">Cart Items ({{ $cart->items->count() }})</div>
            <div class="wp-panel-body" style="padding: 0;">
                <table class="wp-list-table" style="border: 0; box-shadow: none;">
                    <thead>
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Product</th>
                            <th class="text-right" style="width: 90px;">Qty</th>
                            <th class="text-right" style="width: 110px;">Unit Price</th>
                            <th class="text-right" style="width: 110px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart->items as $i => $item)
                            <tr>
                                <td class="text-[#787c82]">{{ $i + 1 }}</td>
                                <td>
                                    <div class="flex items-center gap-2.5">
                                        @if ($item->thumbnail)
                                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="" class="w-9 h-9 rounded object-cover shrink-0 border border-[#e2e4e7]">
                                        @else
                                            <div class="w-9 h-9 rounded bg-[#f0f0f1] shrink-0 grid place-items-center text-[#787c82]">
                                                <i class="fas fa-box text-[10px]"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong class="text-[13px]">{{ $item->product_name }}</strong>
                                            @if ($item->product)
                                                <div class="text-[11px] text-[#787c82] font-mono">SKU: {{ $item->product->sku }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right text-[#50575e]">{{ $item->quantity }}</td>
                                <td class="text-right text-[#50575e]">৳{{ number_format($item->unit_price, 2) }}</td>
                                <td class="text-right"><strong>৳{{ number_format($item->total, 2) }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Estimated Total</th>
                            <th class="text-right">৳{{ number_format($cart->items->sum('total'), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">

        {{-- Session / Device info --}}
        <div class="wp-panel">
            <div class="wp-panel-h">Session & Device</div>
            <div class="wp-panel-body">
                <div class="wc-info-grid">
                    @if (!$cart->contact_name && !$cart->contact_email && !$cart->contact_phone)
                        <span class="lbl">Identity</span>
                        <span class="val text-[#787c82] italic">Anonymous visitor</span>
                    @endif
                    <span class="lbl">IP Address</span>
                    <span class="val font-mono text-[12px]">{{ $cart->ip_address ?? '—' }}</span>
                    <span class="lbl">Browser</span>
                    <span class="val text-[12px] text-[#50575e] break-all">{{ $cart->user_agent ? Str::limit($cart->user_agent, 80) : '—' }}</span>
                    <span class="lbl">Session</span>
                    <span class="val font-mono text-[11px] text-[#787c82]">{{ substr($cart->session_id, 0, 20) }}…</span>
                    <span class="lbl">Last Activity</span>
                    <span class="val">
                        @if ($cart->last_activity)
                            {{ $cart->last_activity->format('d M Y, H:i') }}
                            <span class="text-[11px] text-[#787c82]">({{ $cart->last_activity->diffForHumans() }})</span>
                        @else —
                        @endif
                    </span>
                    <span class="lbl">Created</span>
                    <span class="val text-[#50575e]">{{ $cart->created_at->format('d M Y, H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Summary --}}
        <div class="wp-panel">
            <div class="wp-panel-h">Summary</div>
            <div class="wp-panel-body">
                <div class="wc-summary-row">
                    <span class="lbl">Items</span>
                    <span class="val">{{ $cart->items->count() }}</span>
                </div>
                <div class="wc-summary-row">
                    <span class="lbl">Total Qty</span>
                    <span class="val">{{ $cart->items->sum('quantity') }}</span>
                </div>
                <div class="wc-summary-total">
                    <span class="lbl">Est. Total</span>
                    <span class="val">৳{{ number_format($cart->items->sum('total'), 2) }}</span>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="wp-panel">
            <div class="wp-panel-h">Actions</div>
            <div class="wp-panel-body space-y-2">
                @if ($cart->contact_phone)
                    <a href="tel:{{ $cart->contact_phone }}" class="wp-btn-link text-[#2e7d32]">
                        <i class="fas fa-phone mr-1"></i> Call {{ $cart->contact_phone }}
                    </a>
                @endif
                @if ($cart->contact_email)
                    <a href="mailto:{{ $cart->contact_email }}" class="wp-btn-link text-[#2271b1]">
                        <i class="fas fa-envelope mr-1"></i> Email {{ $cart->contact_email }}
                    </a>
                @endif
                <form method="POST" action="{{ route('admin.abandoned-carts.destroy', $cart) }}" onsubmit="return confirm('Delete this cart record?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="wp-btn-link text-[#b32d2e]"><i class="fas fa-trash mr-1"></i> Delete Record</button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection
