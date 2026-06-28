@php
    $c = $coupon ?? null;
@endphp

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-8 space-y-5">
        <!-- Code + Description -->
        <div class="wp-panel">
            <div class="wp-panel-h">Coupon Details</div>
            <div class="wp-panel-body">
                <div class="wp-field">
                    <label>Coupon Code <span class="text-[#d63638]">*</span></label>
                    <div class="flex items-center gap-2">
                        <input type="text" name="code" value="{{ old('code', $c->code ?? '') }}" required maxlength="50"
                               class="wp-input font-mono uppercase" placeholder="e.g. SAVE20" style="text-transform:uppercase;letter-spacing:1px">
                        <button type="button" onclick="generateCode()" class="wp-btn whitespace-nowrap"><i class="fas fa-wand-magic-sparkles mr-1"></i> Generate</button>
                    </div>
                    <p class="wp-help">Customers enter this code at checkout. Auto-uppercased on save.</p>
                </div>
                <div class="wp-field">
                    <label>Description (internal)</label>
                    <input type="text" name="description" value="{{ old('description', $c->description ?? '') }}" maxlength="255" class="wp-input" placeholder="e.g. New customer welcome discount">
                </div>
            </div>
        </div>

        <!-- Discount -->
        <div class="wp-panel">
            <div class="wp-panel-h">Discount</div>
            <div class="wp-panel-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="wp-field">
                        <label>Discount Type <span class="text-[#d63638]">*</span></label>
                        <select name="type" id="couponType" class="wp-input" required onchange="onTypeChange()">
                            @php $t = old('type', $c->type ?? 'percentage'); @endphp
                            <option value="percentage" @selected($t === 'percentage')>Percentage (%)</option>
                            <option value="fixed"      @selected($t === 'fixed')>Fixed Cart Amount (৳)</option>
                        </select>
                    </div>
                    <div class="wp-field">
                        <label>Coupon Amount <span class="text-[#d63638]">*</span></label>
                        <input type="number" name="amount" step="0.01" min="0" value="{{ old('amount', $c->amount ?? '') }}" required class="wp-input" placeholder="0.00">
                        <p class="wp-help" id="amountHelp"></p>
                    </div>
                </div>

                <div class="wp-field" id="maxDiscountWrap">
                    <label>Maximum Discount (cap, optional)</label>
                    <input type="number" name="maximum_discount" step="0.01" min="0" value="{{ old('maximum_discount', $c->maximum_discount ?? '') }}" class="wp-input" placeholder="Leave empty for no cap">
                    <p class="wp-help">Only applies to percentage coupons. Cap the discount at this amount.</p>
                </div>

                <label class="flex items-center gap-2 mt-2 cursor-pointer">
                    <input type="hidden" name="free_shipping" value="0">
                    <input type="checkbox" name="free_shipping" value="1" {{ old('free_shipping', $c->free_shipping ?? false) ? 'checked' : '' }}>
                    <span class="text-[13px]">Also grant <strong>free shipping</strong> on the order.</span>
                </label>
            </div>
        </div>

        <!-- Usage restrictions -->
        <div class="wp-panel">
            <div class="wp-panel-h">Usage Restrictions</div>
            <div class="wp-panel-body">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="wp-field">
                        <label>Minimum Spend (৳)</label>
                        <input type="number" name="minimum_spend" step="0.01" min="0" value="{{ old('minimum_spend', $c->minimum_spend ?? '') }}" class="wp-input" placeholder="No minimum">
                    </div>
                    <div class="wp-field">
                        <label>Total Usage Limit</label>
                        <input type="number" name="usage_limit" min="1" value="{{ old('usage_limit', $c->usage_limit ?? '') }}" class="wp-input" placeholder="Unlimited">
                        <p class="wp-help">How many times this coupon can be used in total.</p>
                    </div>
                    <div class="wp-field">
                        <label>Usage Limit Per Customer</label>
                        <input type="number" name="usage_limit_per_customer" min="1" value="{{ old('usage_limit_per_customer', $c->usage_limit_per_customer ?? '') }}" class="wp-input" placeholder="Unlimited">
                    </div>
                </div>

                <div class="space-y-2 mt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="individual_use_only" value="0">
                        <input type="checkbox" name="individual_use_only" value="1" {{ old('individual_use_only', $c->individual_use_only ?? false) ? 'checked' : '' }}>
                        <span class="text-[13px]"><strong>Individual use only</strong> — cannot be combined with other coupons.</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="exclude_sale_items" value="0">
                        <input type="checkbox" name="exclude_sale_items" value="1" {{ old('exclude_sale_items', $c->exclude_sale_items ?? false) ? 'checked' : '' }}>
                        <span class="text-[13px]"><strong>Exclude sale items</strong> — coupon won't apply to discounted products.</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">
        <!-- Schedule -->
        <div class="wp-panel">
            <div class="wp-panel-h">Validity</div>
            <div class="wp-panel-body">
                <div class="wp-field">
                    <label>Start Date</label>
                    <input type="date" name="starts_at" value="{{ old('starts_at', optional($c->starts_at ?? null)->format('Y-m-d')) }}" class="wp-input">
                    <p class="wp-help">Leave empty to activate immediately.</p>
                </div>
                <div class="wp-field">
                    <label>Expiry Date</label>
                    <input type="date" name="expires_at" value="{{ old('expires_at', optional($c->expires_at ?? null)->format('Y-m-d')) }}" class="wp-input">
                    <p class="wp-help">Leave empty for no expiration.</p>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="wp-panel">
            <div class="wp-panel-h">Status</div>
            <div class="wp-panel-body">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" {{ old('status', $c->status ?? true) ? 'checked' : '' }}>
                    <span class="text-[13px]"><strong>Active</strong> — coupon can be redeemed.</span>
                </label>
                @if ($c)
                    <p class="text-[12px] text-[#646970] mt-3">Used <strong>{{ $c->used_count }}</strong> time(s)
                        @if ($c->usage_limit)of {{ $c->usage_limit }}@endif.</p>
                @endif
            </div>
        </div>

        <!-- Actions -->
        <div class="wp-panel">
            <div class="wp-panel-h">Publish</div>
            <div class="wp-panel-body">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.coupons.index') }}" class="wp-btn-link">Cancel</a>
                    <button type="submit" class="wp-btn wp-btn-primary">
                        {{ $c ? 'Update Coupon' : 'Create Coupon' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function onTypeChange() {
        const t = document.getElementById('couponType').value;
        document.getElementById('amountHelp').textContent =
            t === 'percentage' ? 'Percent off the cart subtotal (e.g. 15 for 15%).' : 'Flat taka amount off the cart total.';
        document.getElementById('maxDiscountWrap').style.opacity = t === 'percentage' ? '1' : '0.4';
    }
    function generateCode() {
        fetch('{{ route('admin.coupons.generate-code') }}')
            .then(r => r.json())
            .then(d => { document.querySelector('input[name="code"]').value = d.code; });
    }
    onTypeChange();
</script>
