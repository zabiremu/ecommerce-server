@extends('Admin.Layout.app')

@section('title', 'Point of Sale')
@section('page_title', 'Point of Sale')

@section('content')
<div x-data="posApp()" x-init="init()" class="-m-5 lg:-m-6 h-[calc(100vh-3.5rem)] flex flex-col lg:flex-row overflow-hidden bg-slate-100">

    {{-- ── LEFT: Product browser ─────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0 border-r border-slate-200 bg-white">

        <div class="p-3 border-b border-slate-200 space-y-2.5 shrink-0">
            <div class="flex items-center gap-2">
                <select x-model="warehouseId" @change="resetAndLoad()" class="text-[13px] border border-slate-300 rounded-lg px-2.5 py-2 bg-white font-medium">
                    @foreach ($warehouses as $w)
                        <option value="{{ $w->id }}">{{ $w->name }}</option>
                    @endforeach
                </select>

                <div class="relative flex-1">
                    <i class="fas fa-barcode absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[13px]"></i>
                    <input type="text" x-ref="scanInput" x-model="barcode" @keydown.enter.prevent="scanBarcode()"
                           placeholder="Scan or type barcode, then press Enter"
                           class="w-full pl-8 pr-3 py-2 text-[13px] border border-slate-300 rounded-lg focus:border-brand-400 focus:ring-1 focus:ring-brand-400 outline-none">
                </div>
            </div>

            <div class="relative">
                <i class="fas fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[13px]"></i>
                <input type="text" x-model="search" @input.debounce.350ms="resetAndLoad()"
                       placeholder="Search products by name or SKU…"
                       class="w-full pl-8 pr-3 py-2 text-[13px] border border-slate-300 rounded-lg focus:border-brand-400 focus:ring-1 focus:ring-brand-400 outline-none">
            </div>

            <div class="flex items-center gap-1.5 overflow-x-auto pb-0.5" style="scrollbar-width:none;">
                <button @click="categoryId = ''; resetAndLoad()"
                        :class="categoryId === '' ? 'bg-brand-500 text-white border-brand-500' : 'bg-white text-slate-600 border-slate-300 hover:bg-slate-50'"
                        class="shrink-0 px-3 py-1.5 text-[12px] font-medium rounded-full border transition-colors">All</button>
                @foreach ($categories as $c)
                    <button @click="categoryId = '{{ $c->id }}'; resetAndLoad()"
                            :class="categoryId === '{{ $c->id }}' ? 'bg-brand-500 text-white border-brand-500' : 'bg-white text-slate-600 border-slate-300 hover:bg-slate-50'"
                            class="shrink-0 px-3 py-1.5 text-[12px] font-medium rounded-full border transition-colors">{{ $c->name }}</button>
                @endforeach
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-3">
            <template x-if="loading && products.length === 0">
                <div class="grid place-items-center h-40 text-slate-400 text-[13px]"><i class="fas fa-circle-notch fa-spin mr-2"></i> Loading products…</div>
            </template>

            <template x-if="!loading && products.length === 0">
                <div class="grid place-items-center h-40 text-slate-400 text-[13px]">No products found.</div>
            </template>

            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3">
                <template x-for="p in products" :key="p.id">
                    <div class="border border-slate-200 rounded-xl overflow-hidden bg-white hover:shadow-card transition-shadow flex flex-col">
                        <button type="button" @click="quickAdd(p)" :disabled="p.stock <= 0 && p.variants.length === 0"
                                class="text-left disabled:opacity-50 disabled:cursor-not-allowed">
                            <div class="aspect-square bg-slate-50 grid place-items-center overflow-hidden">
                                <img x-show="p.thumbnail" :src="p.thumbnail" :alt="p.name" class="w-full h-full object-cover" onerror="this.style.display='none'">
                                <i x-show="!p.thumbnail" class="fas fa-image text-slate-300 text-2xl"></i>
                            </div>
                            <div class="p-2.5">
                                <p class="text-[12.5px] font-semibold text-slate-800 leading-tight line-clamp-2 min-h-[2.4em]" x-text="p.name"></p>
                                <div class="flex items-center justify-between mt-1.5">
                                    <span class="text-[13px] font-bold text-brand-600" x-text="fmt(p.price)"></span>
                                    <span class="text-[10.5px] font-semibold px-1.5 py-0.5 rounded"
                                          :class="p.stock > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'"
                                          x-show="p.variants.length === 0"
                                          x-text="p.stock > 0 ? ('Stock: ' + trimNum(p.stock)) : 'Out of stock'"></span>
                                    <span class="text-[10.5px] font-semibold px-1.5 py-0.5 rounded bg-slate-100 text-slate-600" x-show="p.variants.length > 0" x-text="p.variants.length + ' options'"></span>
                                </div>
                            </div>
                        </button>

                        <div x-show="p.variants.length > 0" class="px-2.5 pb-2.5 flex flex-wrap gap-1">
                            <template x-for="v in p.variants" :key="v.id">
                                <button type="button" @click="addToCart(p, v)" :disabled="v.stock <= 0"
                                        class="text-[10.5px] font-medium px-1.5 py-0.5 rounded border disabled:opacity-40 disabled:cursor-not-allowed"
                                        :class="v.stock > 0 ? 'border-slate-300 text-slate-700 hover:border-brand-400 hover:text-brand-600' : 'border-slate-200 text-slate-400'"
                                        x-text="v.label"></button>
                            </template>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex justify-center py-4" x-show="page < lastPage">
                <button @click="loadMore()" class="px-4 py-1.5 text-[12.5px] font-medium border border-slate-300 rounded-lg hover:bg-slate-50">
                    <span x-show="!loading">Load more</span>
                    <span x-show="loading"><i class="fas fa-circle-notch fa-spin"></i></span>
                </button>
            </div>
        </div>
    </div>

    {{-- ── RIGHT: Cart / checkout ────────────────────────────────────── --}}
    <div class="w-full lg:w-[400px] shrink-0 flex flex-col bg-white border-t lg:border-t-0 border-slate-200 max-h-[50vh] lg:max-h-none">

        {{-- Customer --}}
        <div class="p-3 border-b border-slate-200 shrink-0">
            <div class="flex items-center justify-between mb-1.5">
                <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Customer</p>
                <button type="button" @click="resetCustomer()" class="text-[11.5px] text-brand-600 hover:underline">Walk-in</button>
            </div>
            <div class="relative">
                <input type="text" x-model="customerQuery" @input.debounce.300ms="searchCustomers()"
                       placeholder="Search by phone or name…"
                       class="w-full px-2.5 py-1.5 text-[13px] border border-slate-300 rounded-lg focus:border-brand-400 focus:ring-1 focus:ring-brand-400 outline-none">
                <div x-show="customerResults.length > 0" @click.outside="customerResults = []"
                     class="absolute z-10 mt-1 w-full bg-white border border-slate-200 rounded-lg shadow-card max-h-48 overflow-y-auto">
                    <template x-for="c in customerResults" :key="c.id">
                        <button type="button" @click="selectCustomer(c)" class="w-full text-left px-3 py-2 text-[12.5px] hover:bg-slate-50 border-b border-slate-100 last:border-0">
                            <p class="font-medium text-slate-800" x-text="c.name"></p>
                            <p class="text-slate-500" x-text="c.phone"></p>
                        </button>
                    </template>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-1.5 mt-1.5">
                <input type="text" x-model="customer.name" placeholder="Name *" class="px-2.5 py-1.5 text-[12.5px] border border-slate-300 rounded-lg">
                <input type="text" x-model="customer.phone" placeholder="Phone *" class="px-2.5 py-1.5 text-[12.5px] border border-slate-300 rounded-lg">
            </div>
        </div>

        {{-- Cart items --}}
        <div class="flex-1 overflow-y-auto p-3 space-y-2">
            <template x-if="cart.length === 0">
                <div class="grid place-items-center h-full text-slate-400 text-[12.5px] py-10">
                    <i class="fas fa-cart-shopping text-2xl mb-2"></i>
                    Cart is empty — click a product to add it
                </div>
            </template>

            <template x-for="line in cart" :key="line.key">
                <div class="flex items-center gap-2 border border-slate-100 rounded-lg p-2">
                    <div class="flex-1 min-w-0">
                        <p class="text-[12.5px] font-semibold text-slate-800 truncate" x-text="line.name"></p>
                        <p class="text-[11px] text-slate-500" x-text="(line.variant_label ? line.variant_label + ' — ' : '') + fmt(line.price)"></p>
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="changeQty(line, -1)" class="w-6 h-6 grid place-items-center rounded border border-slate-300 text-slate-600 hover:bg-slate-50">−</button>
                        <span class="w-7 text-center text-[12.5px] font-semibold" x-text="trimNum(line.qty)"></span>
                        <button type="button" @click="changeQty(line, 1)" class="w-6 h-6 grid place-items-center rounded border border-slate-300 text-slate-600 hover:bg-slate-50">+</button>
                    </div>
                    <p class="w-16 text-right text-[12.5px] font-bold text-slate-800" x-text="fmt(line.price * line.qty)"></p>
                    <button type="button" @click="removeLine(line)" class="text-slate-400 hover:text-red-500 ml-1">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
            </template>
        </div>

        {{-- Totals / payment --}}
        <div class="border-t border-slate-200 p-3 space-y-2 shrink-0">
            <div class="flex items-center justify-between text-[12.5px]">
                <span class="text-slate-500">Subtotal</span>
                <span class="font-semibold" x-text="fmt(subtotal)"></span>
            </div>
            <div class="flex items-center justify-between text-[12.5px]">
                <span class="text-slate-500">Discount</span>
                <input type="number" min="0" step="0.01" x-model.number="discount" class="w-24 text-right px-2 py-1 text-[12.5px] border border-slate-300 rounded-lg">
            </div>
            <div class="flex items-center justify-between text-[15px] font-bold text-slate-900 pt-1 border-t border-slate-100">
                <span>Total</span>
                <span x-text="fmt(total)"></span>
            </div>

            <div class="grid grid-cols-4 gap-1.5 pt-1">
                <template x-for="pm in paymentMethods" :key="pm">
                    <button type="button" @click="paymentMethod = pm"
                            :class="paymentMethod === pm ? 'bg-brand-500 text-white border-brand-500' : 'bg-white text-slate-600 border-slate-300 hover:bg-slate-50'"
                            class="px-1 py-1.5 text-[11px] font-semibold rounded-lg border capitalize" x-text="pm"></button>
                </template>
            </div>

            <div class="grid grid-cols-2 gap-2" x-show="paymentMethod === 'cash'">
                <div>
                    <label class="text-[11px] text-slate-500">Amount received</label>
                    <input type="number" min="0" step="0.01" x-model.number="paidAmount" class="w-full px-2 py-1.5 text-[12.5px] border border-slate-300 rounded-lg">
                </div>
                <div>
                    <label class="text-[11px] text-slate-500">Change</label>
                    <p class="px-2 py-1.5 text-[13px] font-bold text-emerald-600" x-text="fmt(Math.max(0, (paidAmount || 0) - total))"></p>
                </div>
            </div>

            <p class="text-[12px] text-red-600" x-show="error" x-text="error"></p>

            <button type="button" @click="checkout()" :disabled="cart.length === 0 || submitting"
                    class="w-full py-2.5 rounded-lg bg-brand-500 hover:bg-brand-600 text-white text-[13.5px] font-bold disabled:opacity-50 disabled:cursor-not-allowed">
                <span x-show="!submitting">Complete Sale — <span x-text="fmt(total)"></span></span>
                <span x-show="submitting"><i class="fas fa-circle-notch fa-spin mr-1"></i> Processing…</span>
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function posApp() {
    return {
        warehouses: @json($warehouses->map(fn($w) => ['id' => $w->id, 'name' => $w->name])),
        warehouseId: {{ $warehouses->first()->id ?? 'null' }},
        categoryId: '',
        search: '',
        barcode: '',
        products: [],
        page: 1,
        lastPage: 1,
        loading: false,

        cart: [],
        customer: { id: null, name: '', phone: '', email: '', address: '' },
        customerQuery: '',
        customerResults: [],

        discount: 0,
        paymentMethods: ['cash', 'card', 'bkash', 'nagad', 'bank'],
        paymentMethod: 'cash',
        paidAmount: 0,
        error: '',
        submitting: false,

        get subtotal() {
            return this.cart.reduce((sum, l) => sum + (l.price * l.qty), 0);
        },
        get total() {
            return Math.max(0, this.subtotal - (parseFloat(this.discount) || 0));
        },

        init() {
            this.paidAmount = this.total;
            this.$watch('total', (v) => { if (this.paymentMethod === 'cash') this.paidAmount = v; });
            this.loadProducts();
            this.$nextTick(() => this.$refs.scanInput?.focus());
        },

        fmt(n) { return '৳' + (parseFloat(n) || 0).toFixed(2); },
        trimNum(n) { n = parseFloat(n) || 0; return Number.isInteger(n) ? n : n.toFixed(2); },

        csrf() { return document.querySelector('meta[name="csrf-token"]').getAttribute('content'); },

        resetAndLoad() { this.page = 1; this.products = []; this.loadProducts(); },

        async loadProducts() {
            this.loading = true;
            try {
                const params = new URLSearchParams({
                    warehouse_id: this.warehouseId,
                    s: this.search,
                    category_id: this.categoryId,
                    page: this.page,
                });
                const res = await fetch(`{{ route('admin.pos.products') }}?${params.toString()}`, { headers: { 'Accept': 'application/json' } });
                const json = await res.json();
                this.products = this.page === 1 ? json.data : this.products.concat(json.data);
                this.lastPage = json.last_page;
            } catch (e) {
                console.error(e);
            } finally {
                this.loading = false;
            }
        },

        loadMore() { this.page++; this.loadProducts(); },

        quickAdd(p) {
            if (p.variants.length > 0) return; // pick a variant chip instead
            this.addToCart(p, null);
        },

        addToCart(p, variant) {
            const stock = variant ? variant.stock : p.stock;
            if (stock <= 0) return;

            const key = p.id + ':' + (variant ? variant.id : '0');
            const existing = this.cart.find(l => l.key === key);
            if (existing) {
                if (existing.qty < stock) existing.qty++;
                return;
            }

            this.cart.push({
                key,
                product_id: p.id,
                variant_id: variant ? variant.id : null,
                name: p.name,
                variant_label: variant ? variant.label : null,
                price: variant ? variant.price : p.price,
                qty: 1,
                stock,
            });
        },

        changeQty(line, delta) {
            const next = line.qty + delta;
            if (next <= 0) { this.removeLine(line); return; }
            if (next > line.stock) return;
            line.qty = next;
        },

        removeLine(line) {
            this.cart = this.cart.filter(l => l.key !== line.key);
        },

        scanBarcode() {
            if (!this.barcode.trim()) return;
            fetch(`{{ route('admin.pos.products') }}?${new URLSearchParams({ warehouse_id: this.warehouseId, s: this.barcode.trim(), page: 1 })}`, { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(json => {
                    if (json.data.length === 1) {
                        this.quickAdd(json.data[0]);
                        this.error = '';
                    } else if (json.data.length === 0) {
                        this.error = 'No product found for that code.';
                    } else {
                        this.error = 'Multiple matches — search by name instead.';
                    }
                    this.barcode = '';
                    this.$nextTick(() => this.$refs.scanInput?.focus());
                });
        },

        resetCustomer() {
            this.customer = { id: null, name: 'Walk-in Customer', phone: '', email: '', address: '' };
            this.customerQuery = '';
            this.customerResults = [];
        },

        async searchCustomers() {
            if (!this.customerQuery.trim()) { this.customerResults = []; return; }
            const res = await fetch(`{{ route('admin.pos.customers') }}?s=${encodeURIComponent(this.customerQuery)}`, { headers: { 'Accept': 'application/json' } });
            const json = await res.json();
            this.customerResults = json.data;
        },

        selectCustomer(c) {
            this.customer = { id: c.id, name: c.name, phone: c.phone, email: c.email, address: c.address };
            this.customerResults = [];
            this.customerQuery = '';
        },

        async checkout() {
            this.error = '';
            if (this.cart.length === 0) return;
            if (!this.customer.name.trim() || !this.customer.phone.trim()) {
                this.error = 'Customer name and phone are required.';
                return;
            }

            this.submitting = true;
            try {
                const res = await fetch(`{{ route('admin.pos.checkout') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.csrf(),
                    },
                    body: JSON.stringify({
                        warehouse_id: this.warehouseId,
                        customer_name: this.customer.name,
                        customer_phone: this.customer.phone,
                        customer_email: this.customer.email || null,
                        customer_address: this.customer.address || null,
                        payment_method: this.paymentMethod,
                        discount: this.discount || 0,
                        paid_amount: this.paidAmount || this.total,
                        items: this.cart.map(l => ({ product_id: l.product_id, variant_id: l.variant_id, quantity: l.qty })),
                    }),
                });
                const json = await res.json();
                if (!res.ok || !json.success) {
                    this.error = json.message || 'Checkout failed. Please try again.';
                    return;
                }

                window.open(json.redirect, '_blank');

                // Reset for the next sale
                this.cart = [];
                this.discount = 0;
                this.paymentMethod = 'cash';
                this.resetCustomer();
                this.resetAndLoad();
            } catch (e) {
                this.error = 'Network error — please try again.';
            } finally {
                this.submitting = false;
            }
        },
    };
}
</script>
@endpush
