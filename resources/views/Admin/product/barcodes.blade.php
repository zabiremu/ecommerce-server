@extends('Admin.Layout.app')

@section('title', 'Print Barcodes')
@section('page_title', 'Print Barcodes')

@push('styles')
<style>
    @media print {
        body { background: #fff !important; }
        .no-print { display: none !important; }
        .barcode-label { break-inside: avoid; page-break-inside: avoid; }
    }
    .barcode-label {
        width: 220px;
        padding: 12px 8px;
        text-align: center;
        border: 1px dashed #e2e8f0;
        border-radius: 6px;
        background: #fff;
    }
    .barcode-label img { display: block; margin: 4px auto; }
    .barcode-label .name { font-size: 11px; font-weight: 600; color: #1e293b; margin-bottom: 2px; line-height: 1.2; }
    .barcode-label .price { font-size: 10px; color: #64748b; }
    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, 220px);
        gap: 12px;
        justify-content: center;
    }
    .combo { position: relative; }
    .combo-list {
        display: none; position: absolute; top: calc(100% + 4px); left: 0; right: 0; z-index: 30;
        max-height: 260px; overflow-y: auto; background: #fff; border: 1px solid #e2e8f0; border-radius: 6px;
        box-shadow: 0 8px 24px rgba(15,23,42,.08);
    }
    .combo-list.open { display: block; }
    .combo-item { padding: 7px 12px; font-size: 12.5px; color: #1e293b; cursor: pointer; }
    .combo-item:hover, .combo-item.active { background: #f1f5f9; }
    .combo-item.hidden { display: none; }
</style>
@endpush

@section('content')

<div class="no-print mb-4 flex items-center justify-between">
    <div>
        <p class="text-[13px] text-slate-500">Select products to print barcode labels.</p>
    </div>
    <div class="flex items-center gap-2">
        <button onclick="window.print()"
                class="flex items-center gap-1.5 px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-md text-[12.5px] font-semibold transition">
            <i class="fas fa-print text-[11px]"></i>
            <span>Print</span>
        </button>
        <a href="{{ route('admin.products.index') }}"
           class="px-4 py-2 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 rounded-md text-[12.5px] font-medium transition">Back</a>
    </div>
</div>

<div class="no-print mb-4 bg-white rounded-lg border border-slate-200 shadow-card p-4">
    <form method="GET" action="{{ route('admin.products.barcodes') }}" class="flex items-center gap-3 flex-wrap">
        <span class="text-[13px] font-semibold text-slate-700">Generate:</span>
        <div class="combo" id="productCombo">
            <input type="text" id="productSearch" autocomplete="off" placeholder="Search product…"
                   value="{{ $selectedProduct->name ?? '' }}"
                   class="px-3 py-1.5 text-[13px] rounded-md border border-slate-300 outline-none min-w-[220px]">
            <input type="hidden" name="product" id="productId" value="{{ $selectedProduct->id ?? '' }}">
            <div class="combo-list" id="productList">
                @foreach ($allProducts as $p)
                    <div class="combo-item" data-id="{{ $p->id }}" data-name="{{ $p->name }}">{{ $p->name }}</div>
                @endforeach
            </div>
        </div>
        <input type="number" name="qty" min="1" max="200" value="{{ $qty }}"
               placeholder="Quantity"
               class="px-3 py-1.5 text-[13px] rounded-md border border-slate-300 outline-none w-28">
        <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md text-[12.5px] font-semibold transition">
            <i class="fas fa-barcode text-[11px]"></i> Generate
        </button>
        @if ($selectedProduct)
            <a href="{{ route('admin.products.barcodes') }}" class="px-4 py-2 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 rounded-md text-[12.5px] font-medium transition">
                Clear
            </a>
        @endif
    </form>

    @if (!$selectedProduct)
    <div class="flex items-center gap-3 mt-3 pt-3 border-t border-slate-100">
        <span class="text-[13px] font-semibold text-slate-700">Filter:</span>
        <select id="categoryFilter" class="px-3 py-1.5 text-[13px] rounded-md border border-slate-300 outline-none">
            <option value="">All Categories</option>
            @php $cats = \App\Models\Category::where('status', true)->orderBy('name')->get(); @endphp
            @foreach ($cats as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
        <select id="typeFilter" class="px-3 py-1.5 text-[13px] rounded-md border border-slate-300 outline-none">
            <option value="">All Types</option>
            <option value="physical">Physical</option>
            <option value="digital">Digital</option>
        </select>
    </div>
    @endif
</div>

<div class="bg-white rounded-lg border border-slate-200 shadow-card p-6">
    @if ($selectedProduct)
        <p class="no-print text-[13px] text-slate-500 mb-3">
            Showing <strong>{{ $qty }}</strong> barcode{{ $qty > 1 ? 's' : '' }} for <strong>{{ $selectedProduct->name }}</strong>.
        </p>
    @elseif ($products->isEmpty())
        <p class="no-print text-[13px] text-slate-500 mb-3">
            That product could not be found.
        </p>
    @endif
    <div class="grid-container" id="barcodeGrid">
        @foreach ($products as $p)
            <div class="barcode-label" data-category="{{ $p->category_id }}" data-type="{{ $p->type }}">
                <div class="name">{{ $p->name }}</div>
                <img src="{{ route('admin.products.barcode-image', $p->barcode ?? $p->sku) }}" alt="barcode">
                <div class="price">Tk {{ number_format($p->selling_price, 2) }}</div>
            </div>
        @endforeach
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.getElementById('categoryFilter')?.addEventListener('change', filterLabels);
    document.getElementById('typeFilter')?.addEventListener('change', filterLabels);

    function filterLabels() {
        const cat = document.getElementById('categoryFilter').value;
        const type = document.getElementById('typeFilter').value;
        document.querySelectorAll('.barcode-label').forEach(el => {
            const matchCat = !cat || el.dataset.category === cat;
            const matchType = !type || el.dataset.type === type;
            el.style.display = matchCat && matchType ? '' : 'none';
        });
    }

    // Searchable product combobox
    (function () {
        const search = document.getElementById('productSearch');
        const hidden = document.getElementById('productId');
        const list = document.getElementById('productList');
        const items = Array.from(list.querySelectorAll('.combo-item'));
        if (!search) return;

        function openList() { list.classList.add('open'); }
        function closeList() { list.classList.remove('open'); }

        search.addEventListener('focus', () => { filterItems(); openList(); });
        search.addEventListener('input', () => {
            hidden.value = '';
            filterItems();
            openList();
        });

        function filterItems() {
            const q = search.value.trim().toLowerCase();
            let any = false;
            items.forEach(item => {
                const match = !q || item.dataset.name.toLowerCase().includes(q);
                item.classList.toggle('hidden', !match);
                if (match) any = true;
            });
            return any;
        }

        items.forEach(item => {
            item.addEventListener('click', () => {
                search.value = item.dataset.name;
                hidden.value = item.dataset.id;
                closeList();
            });
        });

        document.addEventListener('click', (e) => {
            if (!document.getElementById('productCombo').contains(e.target)) closeList();
        });
    })();
</script>
@endpush
