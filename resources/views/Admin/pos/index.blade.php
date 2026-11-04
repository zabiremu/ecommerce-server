@extends('Admin.Layout.app')

@section('title', 'Point of Sale')
@section('page_title', 'Point of Sale')

@section('content')
<div x-data="posApp()" x-init="init()" class="-m-5 lg:-m-6 h-[calc(100vh-3.5rem)] flex flex-col lg:flex-row overflow-hidden bg-slate-100">

    {{-- ── LEFT: Product browser ─────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col min-w-0 border-r border-slate-200 bg-white">

        <div class="p-3 border-b border-slate-200 space-y-2.5 shrink-0">
            {{-- Offline / sync status --}}
            <div x-show="!online" class="flex items-center gap-2 px-3 py-2 rounded-lg bg-amber-50 border border-amber-300 text-[12.5px] text-amber-800">
                <i class="fas fa-wifi"></i>
                <span><strong>Offline</strong> — sales are saved on this computer and will upload automatically when the internet is back.</span>
            </div>
            <div x-show="pendingCount > 0" class="flex items-center justify-between gap-2 px-3 py-2 rounded-lg bg-sky-50 border border-sky-200 text-[12.5px] text-sky-800">
                <span>
                    <i class="fas fa-cloud-arrow-up mr-1"></i>
                    <strong x-text="pendingCount"></strong> offline sale(s) waiting to upload
                    <span x-show="syncMessage" class="text-sky-700" x-text="'— ' + syncMessage"></span>
                </span>
                <button type="button" @click="syncQueue()" :disabled="syncing || !online"
                        class="shrink-0 px-2.5 py-1 text-[11.5px] font-semibold rounded border border-sky-300 bg-white hover:bg-sky-100 disabled:opacity-50">
                    <span x-show="!syncing">Sync now</span>
                    <span x-show="syncing"><i class="fas fa-circle-notch fa-spin"></i></span>
                </button>
            </div>
            <template x-for="f in failedSales" :key="f.payload.client_token">
                <div class="flex items-start justify-between gap-2 px-3 py-2 rounded-lg bg-red-50 border border-red-200 text-[12px] text-red-700">
                    <span>
                        <strong>Offline sale not uploaded</strong>
                        (<span x-text="new Date(f.payload.sold_at).toLocaleString()"></span>, <span x-text="fmt(f.total)"></span>):
                        <span x-text="f.error"></span>
                    </span>
                    <span class="shrink-0 flex gap-1">
                        <button type="button" @click="retryFailed(f)" class="px-2 py-0.5 rounded border border-red-300 bg-white hover:bg-red-100">Retry</button>
                        <button type="button" @click="discardFailed(f)" class="px-2 py-0.5 rounded border border-red-300 bg-white hover:bg-red-100">Remove</button>
                    </span>
                </div>
            </template>

            <div class="flex items-center gap-2">
                <select x-model="warehouseId" @change="refreshCatalog(); resetAndLoad()" class="text-[13px] border border-slate-300 rounded-lg px-2.5 py-2 bg-white font-medium">
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
                                    <span class="flex items-baseline gap-1">
                                        <span class="text-[13px] font-bold text-brand-600" x-text="fmt(p.price)"></span>
                                        <span x-show="p.old_price" class="text-[10.5px] text-slate-400 line-through" x-text="fmt(p.old_price)"></span>
                                    </span>
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
                                        :title="v.label + ' — ' + (v.stock > 0 ? trimNum(v.stock) + ' in stock' : 'Out of stock')">
                                    <span x-text="v.label"></span>
                                    <span class="ml-0.5 font-semibold" :class="v.stock > 0 ? 'text-emerald-600' : 'text-red-500'"
                                          x-text="'(' + trimNum(v.stock) + ')'"></span>
                                </button>
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
                <label class="inline-flex items-center gap-1.5 text-[11.5px] font-medium text-slate-700 cursor-pointer select-none">
                    <input type="checkbox" x-model="walkIn" @change="walkIn ? resetCustomer() : null"
                           class="rounded border-slate-300 text-brand-600 focus:ring-brand-400">
                    Walk-in customer
                </label>
            </div>

            {{-- Walk-in: no name / phone required --}}
            <div x-show="walkIn" class="flex items-center justify-between gap-2 px-2.5 py-2 rounded-lg bg-slate-50 border border-dashed border-slate-300">
                <div class="flex items-center gap-2 text-[12.5px] text-slate-700">
                    <i class="fas fa-person-walking text-slate-500"></i>
                    <span><span class="font-semibold">Walk-in Customer</span> — name &amp; phone not needed</span>
                </div>
                <button type="button" @click="walkIn = false" class="text-[11.5px] text-brand-600 hover:underline shrink-0">Add customer</button>
            </div>

            <div x-show="!walkIn">
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
            <p x-show="customer.due > 0" class="mt-1.5 px-2.5 py-1.5 rounded-lg bg-rose-50 border border-rose-200 text-[12px] text-rose-700">
                <i class="fas fa-circle-exclamation mr-1"></i> Previous due: <strong x-text="fmt(customer.due)"></strong>
            </p>
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

            {{-- Due (credit) sale: customer pays part now, the rest later --}}
            <label class="flex items-center gap-2 pt-1 text-[12.5px] font-semibold text-slate-700 cursor-pointer select-none">
                <input type="checkbox" x-model="isDue" @change="onDueToggle()" class="rounded border-slate-300 text-rose-600 focus:ring-rose-400">
                Due sale <span class="font-normal text-slate-500">(customer pays later)</span>
            </label>
            <div x-show="isDue" class="grid grid-cols-2 gap-2 p-2 rounded-lg bg-rose-50 border border-rose-200">
                <div>
                    <label class="text-[11px] text-slate-500">Paid now</label>
                    <input type="number" min="0" step="0.01" x-model.number="duePaid" class="w-full px-2 py-1.5 text-[12.5px] border border-slate-300 rounded-lg bg-white">
                </div>
                <div>
                    <label class="text-[11px] text-slate-500">Due</label>
                    <p class="px-2 py-1.5 text-[13px] font-bold text-rose-600" x-text="fmt(dueAmount)"></p>
                </div>
                <div class="col-span-2">
                    <label class="text-[11px] text-slate-500">Pay by (due date)</label>
                    <input type="date" x-model="dueDate" class="w-full px-2 py-1.5 text-[12.5px] border border-slate-300 rounded-lg bg-white">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-2" x-show="paymentMethod === 'cash' && !isDue">
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
                <span x-show="!submitting && !isDue">Complete Sale — <span x-text="fmt(total)"></span></span>
                <span x-show="!submitting && isDue">Complete Sale — <span x-text="fmt(dueAmount)"></span> due</span>
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
        walkIn: true,
        customer: { id: null, name: '', phone: '', email: '', address: '' },
        customerQuery: '',
        customerResults: [],

        discount: 0,
        paymentMethods: ['cash', 'card', 'bkash', 'nagad', 'bank'],
        paymentMethod: 'cash',
        paidAmount: 0,
        isDue: false,
        duePaid: 0,
        dueDate: '',
        error: '',
        submitting: false,
        // One token per sale: a double click or retry re-sends it and the server returns the same sale.
        saleToken: '',
        scanBuffer: '',
        scanLastKey: 0,

        // Offline mode: products come from a saved copy and sales queue up on this computer.
        online: navigator.onLine,
        queue: [],          // sales waiting to upload: { payload, total, error? }
        syncing: false,
        syncMessage: '',
        shopName: @json(\App\Models\SiteSetting::get('company_name', 'Roventex')),

        get pendingCount() { return this.queue.filter(q => !q.error).length; },
        get failedSales() { return this.queue.filter(q => q.error); },

        get subtotal() {
            return this.cart.reduce((sum, l) => sum + (l.price * l.qty), 0);
        },
        get total() {
            return Math.max(0, this.subtotal - (parseFloat(this.discount) || 0));
        },
        get dueAmount() {
            return Math.max(0, this.total - (parseFloat(this.duePaid) || 0));
        },
        endOfMonth() {
            // Last day of the current month in Bangladesh time (UTC+6)
            const d = new Date(Date.now() + 6 * 3600000);
            const last = new Date(Date.UTC(d.getUTCFullYear(), d.getUTCMonth() + 1, 0));
            return last.toISOString().slice(0, 10);
        },
        onDueToggle() {
            if (this.isDue) {
                this.walkIn = false;          // a due needs a real customer
                this.duePaid = 0;
                this.dueDate = this.endOfMonth();
            }
        },

        init() {
            this.paidAmount = this.total;
            this.$watch('total', (v) => { if (this.paymentMethod === 'cash') this.paidAmount = v; });
            this.queue = this.store('pos_offline_queue') || [];
            this.loadProducts();
            this.newSaleToken();
            this.$nextTick(() => this.$refs.scanInput?.focus());
            window.addEventListener('keydown', (e) => this.captureScanner(e));

            if ('serviceWorker' in navigator) {
                navigator.serviceWorker.register('{{ asset('pos-sw.js') }}', { scope: '{{ route('admin.pos.index', [], false) }}' })
                    .catch((e) => console.warn('POS offline cache unavailable', e));
            }
            window.addEventListener('online', () => { this.online = true; this.syncQueue(); });
            window.addEventListener('offline', () => { this.online = false; });
            setInterval(() => this.syncQueue(), 30000);
            this.syncQueue().then(() => this.refreshCatalog());
        },

        // ── Local storage (survives closing the browser) ──────────────
        store(key, value) {
            try {
                if (value === undefined) return JSON.parse(localStorage.getItem(key));
                localStorage.setItem(key, JSON.stringify(value));
            } catch (e) {
                if (value !== undefined) this.error = 'Could not save offline data on this computer (browser storage full or blocked).';
                return null;
            }
        },
        saveQueue() { this.store('pos_offline_queue', this.queue); },
        catalogKey() { return 'pos_catalog_' + this.warehouseId; },

        // Full product list for this warehouse, kept for offline use. Skipped while sales are
        // still waiting to upload, so the saved stock keeps those sales deducted.
        async refreshCatalog() {
            if (!navigator.onLine || this.queue.some(q => !q.error && q.payload.warehouse_id == this.warehouseId)) return;
            try {
                const res = await fetch(`{{ route('admin.pos.catalog') }}?warehouse_id=${this.warehouseId}`, { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;
                const json = await res.json();
                this.store(this.catalogKey(), json.data);
            } catch (e) { /* offline — keep the saved copy */ }
        },

        // Take sold quantities off the saved product list, so offline stock stays right.
        deductFromCatalog(warehouseId, items) {
            const key = 'pos_catalog_' + warehouseId;
            const catalog = this.store(key);
            if (!catalog) return;
            items.forEach((it) => {
                const p = catalog.find(x => x.id === it.product_id);
                if (!p) return;
                p.stock = Math.max(0, p.stock - it.quantity);
                const v = it.variant_id ? p.variants.find(x => x.id === it.variant_id) : null;
                if (v) v.stock = Math.max(0, v.stock - it.quantity);
            });
            this.store(key, catalog);
        },

        offlineProducts() {
            const catalog = this.store(this.catalogKey());
            if (!catalog) {
                this.error = 'No saved product list for this warehouse yet — open the POS once while online.';
                return [];
            }
            const s = this.search.trim().toLowerCase();
            return catalog.filter(p =>
                (this.categoryId === '' || String(p.category_id) === String(this.categoryId)) &&
                (s === '' || p.name.toLowerCase().includes(s) || (p.sku || '').toLowerCase().includes(s) || p.barcode === this.search.trim())
            );
        },

        offlineScan(code) {
            const catalog = this.store(this.catalogKey()) || [];
            for (const p of catalog) {
                const v = p.variants.find(x => x.sku && x.sku === code);
                if (v) return { data: [p], matched_variant_id: v.id };
            }
            return { data: catalog.filter(p => p.barcode === code || p.sku === code).slice(0, 2), matched_variant_id: null };
        },

        newSaleToken() {
            this.saleToken = (window.crypto && crypto.randomUUID)
                ? crypto.randomUUID()
                : Date.now().toString(36) + Math.random().toString(36).slice(2);
        },

        // A USB / Bluetooth barcode scanner types the code very fast and ends with Enter.
        // Catch that even when the cursor is not in the scan box (but not while typing in another field).
        captureScanner(e) {
            const t = e.target;
            const typing = t && (t.tagName === 'INPUT' || t.tagName === 'TEXTAREA' || t.tagName === 'SELECT' || t.isContentEditable);
            if (typing) return;

            const now = Date.now();
            if (now - this.scanLastKey > 80) this.scanBuffer = '';
            this.scanLastKey = now;

            if (e.key === 'Enter') {
                if (this.scanBuffer.length >= 3) {
                    e.preventDefault();
                    this.barcode = this.scanBuffer;
                    this.scanBarcode();
                }
                this.scanBuffer = '';
            } else if (e.key.length === 1) {
                this.scanBuffer += e.key;
            }
        },

        fmt(n) { return '৳' + (parseFloat(n) || 0).toFixed(2); },
        trimNum(n) { n = parseFloat(n) || 0; return Number.isInteger(n) ? n : n.toFixed(2); },

        csrf() { return document.querySelector('meta[name="csrf-token"]').getAttribute('content'); },

        resetAndLoad() { this.page = 1; this.products = []; this.loadProducts(); },

        async loadProducts() {
            this.loading = true;
            try {
                if (!navigator.onLine) throw new TypeError('offline');
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
                // No connection: page through the saved product list instead.
                const all = this.offlineProducts();
                this.products = all.slice(0, this.page * 24);
                this.lastPage = Math.max(1, Math.ceil(all.length / 24));
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
            const code = this.barcode.trim();
            (navigator.onLine
                ? fetch(`{{ route('admin.pos.products') }}?${new URLSearchParams({ warehouse_id: this.warehouseId, s: code, page: 1, scan: 1 })}`, { headers: { 'Accept': 'application/json' } })
                    .then(r => r.json())
                    .catch(() => this.offlineScan(code))
                : Promise.resolve(this.offlineScan(code)))
                .then(json => {
                    if (json.data.length === 1) {
                        const p = json.data[0];
                        const variant = json.matched_variant_id ? p.variants.find(v => v.id === json.matched_variant_id) : null;
                        const stock = variant ? variant.stock : p.stock;
                        if (!variant && p.variants.length > 0) {
                            this.error = `"${p.name}" has sizes/colours — pick one from the product card (or scan the variant code).`;
                        } else if (stock <= 0) {
                            this.error = `"${p.name}" is out of stock in this warehouse.`;
                        } else {
                            this.addToCart(p, variant);
                            this.error = '';
                        }
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
            this.walkIn = true;
            this.isDue = false;
            this.customer = { id: null, name: '', phone: '', email: '', address: '' };
            this.customerQuery = '';
            this.customerResults = [];
        },

        async searchCustomers() {
            if (!this.customerQuery.trim()) { this.customerResults = []; return; }
            try {
                const res = await fetch(`{{ route('admin.pos.customers') }}?s=${encodeURIComponent(this.customerQuery)}`, { headers: { 'Accept': 'application/json' } });
                const json = await res.json();
                this.customerResults = json.data;
            } catch (e) {
                // Offline: just type the name and phone below — the customer is matched by phone on upload.
                this.customerResults = [];
            }
        },

        selectCustomer(c) {
            this.walkIn = false;
            this.customer = { id: c.id, name: c.name, phone: c.phone, email: c.email, address: c.address, due: c.due || 0 };
            this.customerResults = [];
            this.customerQuery = '';
        },

        async checkout() {
            this.error = '';
            if (this.cart.length === 0) return;
            if (this.isDue && this.dueAmount <= 0) {
                this.error = 'Nothing is due — paid amount covers the total. Untick "Due sale".';
                return;
            }
            if (!this.walkIn && (!this.customer.name.trim() || !this.customer.phone.trim())) {
                this.error = this.isDue
                    ? 'A due sale needs the customer\'s name and phone.'
                    : 'Customer name and phone are required (or tick "Walk-in customer").';
                return;
            }

            const payload = {
                warehouse_id: this.warehouseId,
                walk_in: this.walkIn,
                customer_name: this.walkIn ? null : this.customer.name,
                customer_phone: this.walkIn ? null : this.customer.phone,
                customer_email: this.walkIn ? null : (this.customer.email || null),
                customer_address: this.walkIn ? null : (this.customer.address || null),
                payment_method: this.paymentMethod,
                discount: this.discount || 0,
                paid_amount: this.isDue ? (parseFloat(this.duePaid) || 0)
                    : (this.paymentMethod === 'cash' ? (this.paidAmount || this.total) : this.total),
                is_due: this.isDue,
                due_date: this.isDue ? (this.dueDate || null) : null,
                items: this.cart.map(l => ({ product_id: l.product_id, variant_id: l.variant_id, quantity: l.qty })),
                client_token: this.saleToken,
            };
            if (!this.isDue && payload.paid_amount < this.total - 0.009) {
                this.error = 'Amount received is less than the total. Tick "Due sale" to sell the rest on credit.';
                return;
            }

            this.submitting = true;
            try {
                let res;
                try {
                    if (!navigator.onLine) throw new TypeError('offline');
                    res = await this.postSale(payload);
                } catch (e) {
                    // No connection — keep the sale on this computer and upload it later.
                    this.queueOfflineSale(payload);
                    return;
                }

                const json = await res.json();
                if (!res.ok || !json.success) {
                    this.error = json.message || 'Checkout failed. Please try again.';
                    return;
                }

                window.open(json.redirect, '_blank');
                this.deductFromCatalog(payload.warehouse_id, payload.items);
                this.finishSale();
            } catch (e) {
                this.error = 'Something went wrong — please try again.';
            } finally {
                this.submitting = false;
            }
        },

        postSale(payload) {
            return fetch(`{{ route('admin.pos.checkout') }}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.csrf(),
                },
                body: JSON.stringify(payload),
            });
        },

        // Reset for the next sale
        finishSale() {
            this.newSaleToken();
            this.cart = [];
            this.discount = 0;
            this.paymentMethod = 'cash';
            this.resetCustomer();
            this.resetAndLoad();
        },

        queueOfflineSale(payload) {
            const sale = {
                payload: { ...payload, offline: true, sold_at: new Date().toISOString() },
                total: this.total,
                lines: this.cart.map(l => ({ name: l.name, variant_label: l.variant_label, qty: l.qty, price: l.price })),
                subtotal: this.subtotal,
            };
            this.queue.push(sale);
            this.saveQueue();
            this.deductFromCatalog(payload.warehouse_id, payload.items);
            this.printOfflineReceipt(sale);
            this.finishSale();
        },

        // Upload queued offline sales. Each carries its own sale token, so a sale that already
        // reached the server is matched, never entered twice.
        async syncQueue() {
            if (this.syncing || !navigator.onLine || this.pendingCount === 0) return;
            this.syncing = true;
            this.syncMessage = '';
            let uploaded = 0;
            try {
                const session = await fetch(`{{ route('admin.pos.session') }}`, { headers: { 'Accept': 'application/json' } });
                if (session.status === 401 || session.redirected) {
                    this.syncMessage = 'log in again to upload them';
                    return;
                }
                const { csrf } = await session.json();
                document.querySelector('meta[name="csrf-token"]').setAttribute('content', csrf);

                for (const sale of this.queue.filter(q => !q.error)) {
                    const res = await this.postSale(sale.payload);
                    if (res.status === 401 || res.status === 419) {
                        this.syncMessage = 'log in again to upload them';
                        break;
                    }
                    const json = await res.json().catch(() => ({}));
                    if (res.ok && json.success) {
                        this.queue = this.queue.filter(q => q !== sale);
                        uploaded++;
                    } else if (res.status === 422) {
                        sale.error = json.message || 'The server rejected this sale.';
                    } else {
                        this.syncMessage = 'server error, will retry';
                        break;
                    }
                    this.saveQueue();
                }
            } catch (e) {
                this.syncMessage = 'still offline, will retry';
            } finally {
                this.syncing = false;
            }

            if (uploaded > 0) {
                this.syncMessage = '';
                await this.refreshCatalog();
                this.resetAndLoad();
            }
        },

        retryFailed(sale) {
            delete sale.error;
            this.saveQueue();
            this.syncQueue();
        },

        discardFailed(sale) {
            if (!confirm('Remove this offline sale? It will NOT be recorded on the server.')) return;
            this.queue = this.queue.filter(q => q !== sale);
            this.saveQueue();
        },

        printOfflineReceipt(sale) {
            const esc = (s) => String(s ?? '').replace(/[&<>"]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
            const p = sale.payload;
            const paid = parseFloat(p.paid_amount) || 0;
            const rows = sale.lines.map(l => `<tr><td>${esc(l.name)}${l.variant_label ? '<br><small>' + esc(l.variant_label) + '</small>' : ''}</td>
                <td style="text-align:center">${this.trimNum(l.qty)}</td><td style="text-align:right">${this.fmt(l.price * l.qty)}</td></tr>`).join('');
            const w = window.open('', '_blank', 'width=380,height=600');
            if (!w) return;
            w.document.write(`<!doctype html><html><head><meta charset="utf-8"><title>Receipt</title>
                <style>body{font:12px monospace;width:72mm;margin:0 auto;padding:8px}h2{text-align:center;margin:4px 0}
                table{width:100%;border-collapse:collapse}td{padding:2px 0;vertical-align:top}.r{text-align:right}hr{border:0;border-top:1px dashed #000}</style></head>
                <body><h2>${esc(this.shopName)}</h2>
                <p style="text-align:center">${new Date(p.sold_at).toLocaleString()}<br>Ref: ${esc(p.client_token.slice(0, 8).toUpperCase())}<br><b>OFFLINE SALE</b></p>
                <p>Customer: ${p.walk_in ? 'Walk-in Customer' : esc(p.customer_name) + ' (' + esc(p.customer_phone) + ')'}</p>
                <hr><table>${rows}</table><hr>
                <table><tr><td>Subtotal</td><td class="r">${this.fmt(sale.subtotal)}</td></tr>
                <tr><td>Discount</td><td class="r">${this.fmt(p.discount)}</td></tr>
                <tr><td><b>Total</b></td><td class="r"><b>${this.fmt(sale.total)}</b></td></tr>
                <tr><td>Paid (${esc(p.payment_method)})</td><td class="r">${this.fmt(paid)}</td></tr>
                ${p.is_due ? `<tr><td>Due</td><td class="r">${this.fmt(sale.total - paid)}</td></tr>` : `<tr><td>Change</td><td class="r">${this.fmt(Math.max(0, paid - sale.total))}</td></tr>`}
                </table><hr><p style="text-align:center">Thank you!</p>
                <script>window.onload=()=>window.print()<\/script></body></html>`);
            w.document.close();
        },
    };
}
</script>
@endpush
