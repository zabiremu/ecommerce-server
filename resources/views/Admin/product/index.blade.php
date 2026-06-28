@extends('Admin.Layout.app')

@section('title', 'Products')
@section('page_title', 'Products')

@push('styles')
<style>
    body.font-sans { background: #f0f0f1 !important; }
    main { background: #f0f0f1 !important; }
    .wp-list-table { border: 1px solid #c3c4c7; background: #fff; box-shadow: 0 1px 1px rgba(0,0,0,.04); }
    .wp-list-table thead th { background: #fff; color: #2c3338; font-weight: 600; font-size: 13px; padding: 10px 8px; border-bottom: 1px solid #c3c4c7; }
    .wp-list-table tbody td { font-size: 13px; padding: 12px 8px; vertical-align: top; color: #2c3338; border-bottom: 1px solid #f0f0f1; }
    .wp-list-table tbody tr:hover { background: #f6f7f7; }
    .wp-list-table tbody tr:hover .wp-row-actions { visibility: visible; }
    .wp-row-actions { visibility: hidden; margin-top: 4px; font-size: 12px; color: #50575e; }
    .wp-row-actions a, .wp-row-actions button { color: #2271b1; background: none; border: 0; cursor: pointer; font-size: 12px; padding: 0; }
    .wp-row-actions a:hover, .wp-row-actions button:hover { color: #135e96; text-decoration: underline; }
    .wp-row-actions .trash, .wp-row-actions .trash:hover { color: #b32d2e; }
    .wp-subtab { font-size: 13px; }
    .wp-subtab a { color: #2271b1; }
    .wp-subtab a:hover { color: #135e96; }
    .wp-subtab a.current { color: #000; font-weight: 600; }
    .wp-input { padding: 6px 10px; font-size: 13px; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; outline: none; line-height: 1.4; }
    .wp-input:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    .wp-btn { padding: 5px 11px; font-size: 13px; font-weight: 500; border-radius: 3px; cursor: pointer; border: 1px solid #2271b1; background: #f6f7f7; color: #2271b1; line-height: 1.4; }
    .wp-btn:hover { background: #f0f0f1; }
    .wp-btn-primary { background: #2271b1; color: #fff; }
    .wp-btn-primary:hover { background: #135e96; border-color: #135e96; color: #fff; }
    .wp-pagelinks { font-size: 13px; }
    .wp-pagelinks a, .wp-pagelinks span { display: inline-block; padding: 4px 8px; border: 1px solid #c3c4c7; background: #fff; color: #2271b1; border-radius: 3px; margin-left: 4px; }
    .wp-pagelinks span[aria-current="page"] { background: #2c3338; color: #fff; border-color: #2c3338; }
    .lightbox-overlay { position: fixed; inset: 0; z-index: 9999; background: rgba(0,0,0,0.75); display: none; align-items: center; justify-content: center; padding: 2rem; }
    .lightbox-overlay.active { display: flex; }
    .lightbox-overlay img { max-width: 90vw; max-height: 90vh; border-radius: 8px; box-shadow: 0 20px 60px rgba(0,0,0,0.5); }
    .lightbox-overlay .close-lb { position: absolute; top: 1rem; right: 1.5rem; color: #fff; font-size: 1.5rem; cursor: pointer; opacity: 0.7; }
    .lightbox-overlay .close-lb:hover { opacity: 1; }
    .type-pill { display: inline-block; padding: 2px 8px; font-size: 11px; font-weight: 600; border-radius: 3px; }
    .type-physical { background: #e6f4ea; color: #1e7e34; }
    .type-digital { background: #f3e8ff; color: #6f42c1; }
    .stock-ok { color: #1e7e34; font-weight: 600; }
    .stock-low { color: #d97706; font-weight: 600; }
    .stock-out { color: #d63638; font-weight: 600; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="text-[23px] font-normal text-[#1d2327] m-0">Products</h1>
    <a href="{{ route('admin.products.create') }}"
       class="inline-flex items-center gap-1.5 px-2.5 py-1 border border-[#2271b1] hover:bg-[#f0f0f1] text-[#2271b1] rounded text-[13px] font-normal transition">
        Add New
    </a>
    @if ($search)
        <span class="text-[14px] text-[#50575e]">Search results for: <strong>"{{ $search }}"</strong></span>
    @endif
</div>

@php
    $statusTabs = [
        ['key' => 'all', 'label' => 'All', 'count' => $counts['all']],
        ['key' => 'published', 'label' => 'Published', 'count' => $counts['published']],
        ['key' => 'pending', 'label' => 'Pending', 'count' => $counts['pending']],
        ['key' => 'draft', 'label' => 'Draft', 'count' => $counts['draft']],
    ];
@endphp

<ul class="flex items-center flex-wrap gap-x-1 wp-subtab mb-3">
    @foreach ($statusTabs as $i => $tab)
        <li class="flex items-center">
            @if ($i > 0) <span class="text-[#c3c4c7] mx-1.5">|</span> @endif
            <a href="{{ route('admin.products.index', array_filter(['status' => $tab['key'] === 'all' ? null : $tab['key'], 's' => $search ?: null, 'category' => $categoryId ?: null])) }}"
               class="{{ $filter === $tab['key'] ? 'current' : '' }}">
                {{ $tab['label'] }} <span class="text-[#646970]">({{ $tab['count'] }})</span>
            </a>
        </li>
    @endforeach
</ul>

<form method="GET" action="{{ route('admin.products.index') }}" id="filterForm">
    <input type="hidden" name="status" value="{{ $filter }}">

    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
        <div class="flex flex-wrap items-center gap-2">
            <select id="bulkAction" class="wp-input">
                <option value="">Bulk actions</option>
                <option value="published">Publish</option>
                <option value="pending">Move to Pending</option>
                <option value="draft">Move to Draft</option>
                <option value="delete">Delete Permanently</option>
            </select>
            <button type="button" id="applyBulk" class="wp-btn">Apply</button>

            <select name="category" class="wp-input">
                <option value="">All categories</option>
                @foreach ($categories as $c)
                    <option value="{{ $c->id }}" {{ (string) $categoryId === (string) $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="wp-btn">Filter</button>
        </div>

        <div class="flex items-center gap-2">
            <input type="text" name="s" value="{{ $search }}" placeholder="Search products" class="wp-input w-56">
            <button type="submit" class="wp-btn">Search Products</button>
        </div>
    </div>
</form>

<form method="POST" action="{{ route('admin.products.bulk-action') }}" id="bulkForm">
    @csrf
    <input type="hidden" name="action" id="bulkActionInput">

    <div style="overflow-x:auto;-webkit-overflow-scrolling:touch;">
    <table class="wp-list-table w-full">
        <thead>
            <tr>
                <th class="w-8 text-center"><input type="checkbox" id="selectAll"></th>
                <th class="w-14"></th>
                <th class="text-left">Name</th>
                <th class="text-left w-28">SKU</th>
                <th class="text-left w-24">Stock</th>
                <th class="text-right w-24">Price</th>
                <th class="text-left w-32">Categories</th>
                <th class="text-left w-20">Type</th>
                <th class="text-center w-12">Barcode</th>
                <th class="text-left w-32">Landing Page</th>
                <th class="text-left w-32">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $p)
                @php
                    $stockVal = $p->type === 'physical' ? (float) $p->stock : null;
                    $alert = (float) ($p->alert_quantity ?? 0);
                    $stockClass = $stockVal === null ? '' : ($stockVal <= 0 ? 'stock-out' : ($alert > 0 && $stockVal <= $alert ? 'stock-low' : 'stock-ok'));
                    $stockLabel = $stockVal === null ? '—' : ($stockVal <= 0 ? 'Out of stock' : ($alert > 0 && $stockVal <= $alert ? 'Low stock (' . rtrim(rtrim(number_format($stockVal, 2, '.', ''), '0'), '.') . ')' : 'In stock (' . rtrim(rtrim(number_format($stockVal, 2, '.', ''), '0'), '.') . ')'));
                @endphp
                <tr>
                    <td class="text-center"><input type="checkbox" name="ids[]" value="{{ $p->id }}" class="row-check"></td>
                    <td>
                        @if ($p->thumbnail)
                            <a href="#" onclick="openLightbox('{{ Storage::url($p->thumbnail) }}'); return false">
                                <img src="{{ Storage::url($p->thumbnail) }}" alt="" class="w-10 h-10 rounded object-cover border border-[#dcdcde]">
                            </a>
                        @else
                            <div class="w-10 h-10 rounded bg-[#f0f0f1] border border-[#dcdcde] grid place-items-center text-[#787c82] text-[11px]"><i class="fas fa-image"></i></div>
                        @endif
                    </td>
                    <td>
                        <strong>
                            <a href="{{ route('admin.products.edit', $p) }}" class="text-[#2271b1] hover:text-[#135e96]">{{ $p->name }}</a>
                        </strong>
                        @if ($p->publish_status === 'draft')
                            <span class="text-[#50575e] font-semibold"> — Draft</span>
                        @elseif ($p->publish_status === 'pending')
                            <span class="text-[#d97706] font-semibold"> — Pending</span>
                        @endif
                        <div class="wp-row-actions">
                            <span><a href="{{ route('admin.products.edit', $p) }}">Edit</a> |</span>
                            @if ($p->publish_status !== 'published')
                                <span><button type="button" onclick="quickStatus({{ $p->id }}, 'published')">Publish</button> |</span>
                            @endif
                            @if ($p->publish_status !== 'draft')
                                <span><button type="button" onclick="quickStatus({{ $p->id }}, 'draft')">Draft</button> |</span>
                            @endif
                            @if ($p->publish_status !== 'pending')
                                <span><button type="button" onclick="quickStatus({{ $p->id }}, 'pending')">Pending</button> |</span>
                            @endif
                            <span><a href="{{ route('admin.products.barcodes') }}?product={{ $p->id }}">Barcode</a> |</span>
                            <span><button type="button" class="trash" onclick="deleteProduct({{ $p->id }})">Trash</button></span>
                        </div>
                    </td>
                    <td class="font-mono text-[12px] text-[#50575e]">{{ $p->sku }}</td>
                    <td><span class="{{ $stockClass }}">{{ $stockLabel }}</span></td>
                    <td class="text-right"><strong>{{ number_format($p->selling_price, 2) }}</strong></td>
                    <td class="text-[#50575e]">{{ $p->category->name ?? '—' }}</td>
                    <td><span class="type-pill type-{{ $p->type }}">{{ ucfirst($p->type) }}</span></td>
                    <td class="text-center">
                        <a href="{{ route('admin.products.barcodes') }}?product={{ $p->id }}" title="Print Barcode">
                            <img src="{{ route('admin.products.barcode-image', $p->barcode ?? $p->sku) }}" alt="barcode" class="inline-block h-6">
                        </a>
                    </td>
                    <td>
                        @php
                            $lp = $p->landingPage;
                        @endphp
                        <div class="flex items-center gap-1.5 flex-wrap">
                            <a href="{{ route('admin.products.landing.edit', $p) }}"
                               class="inline-flex items-center gap-1 px-2 py-1 border border-[#2271b1] text-[#2271b1] rounded text-[12px] hover:bg-[#f0f6fc]"
                               title="Edit landing page">
                                <i class="fas fa-pen text-[10px]"></i> Edit
                            </a>
                            @if ($lp && $lp->is_active)
                                <a href="{{ route('landing-page', $lp->slug) }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-1 px-2 py-1 border border-[#00a32a] text-[#00a32a] rounded text-[12px] hover:bg-[#f0fdf4]"
                                   title="View live landing page">
                                    <i class="fas fa-arrow-up-right-from-square text-[10px]"></i> Live
                                </a>
                                <button type="button"
                                        onclick="copyLandingLink('{{ route('landing-page', $lp->slug) }}', this)"
                                        class="inline-flex items-center justify-center w-7 h-7 border border-[#dcdcde] text-[#50575e] rounded text-[11px] hover:bg-[#f0f0f1] hover:text-[#2271b1]"
                                        title="Copy link">
                                    <i class="fas fa-copy"></i>
                                </button>
                            @else
                                <span class="text-[11px] text-[#646970] px-1.5 py-0.5 bg-[#f0f0f1] rounded">
                                    {{ $lp ? 'Inactive' : 'Not set' }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="text-[12px] text-[#50575e]">
                        @if ($p->publish_status === 'published')
                            Published<br>
                        @else
                            Last Modified<br>
                        @endif
                        <span class="text-[#646970]">{{ $p->updated_at->format('Y/m/d') }} at {{ $p->updated_at->format('g:i a') }}</span>
                    </td>
                </tr>
            @empty
                <tr><td colspan="11" class="px-3 py-10 text-center text-[#787c82]">No products found.</td></tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th class="text-center"><input type="checkbox" id="selectAll2"></th>
                <th></th>
                <th class="text-left">Name</th>
                <th class="text-left">SKU</th>
                <th class="text-left">Stock</th>
                <th class="text-right">Price</th>
                <th class="text-left">Categories</th>
                <th class="text-left">Type</th>
                <th class="text-center">Barcode</th>
                <th class="text-left">Landing Page</th>
                <th class="text-left">Date</th>
            </tr>
        </tfoot>
    </table>
    </div>
</form>

<div class="flex items-center justify-between mt-3">
    <div class="text-[13px] text-[#50575e]">{{ $products->total() }} item{{ $products->total() === 1 ? '' : 's' }}</div>
    <div class="wp-pagelinks">{{ $products->links() }}</div>
</div>

<div id="lightbox" class="lightbox-overlay" onclick="closeLightbox(event)">
    <span class="close-lb" onclick="closeLightbox()">&times;</span>
    <img id="lightboxImg" src="" alt="Preview">
</div>

<form id="quickStatusForm" method="POST" style="display:none">
    @csrf
    <input type="hidden" name="publish_status" id="quickStatusValue">
</form>

<form id="deleteForm" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script>
    $(function () {
        $('#selectAll, #selectAll2').on('change', function () {
            $('.row-check').prop('checked', this.checked);
            $('#selectAll, #selectAll2').prop('checked', this.checked);
        });

        $('#applyBulk').on('click', function () {
            var action = $('#bulkAction').val();
            var count = $('.row-check:checked').length;
            if (!action) { alert('Please select a bulk action.'); return; }
            if (count === 0) { alert('Please select at least one product.'); return; }
            if (action === 'delete' && !confirm('Permanently delete ' + count + ' product(s)?')) return;
            $('#bulkActionInput').val(action);
            $('#bulkForm').attr('action', '{{ route('admin.products.bulk-action') }}').submit();
        });
    });

    function quickStatus(id, status) {
        var $f = $('#quickStatusForm');
        $f.attr('action', '/admin/products/' + id + '/set-status');
        $('#quickStatusValue').val(status);
        $f.submit();
    }

    function deleteProduct(id) {
        if (!confirm('Move this product to trash (permanently delete)?')) return;
        var $f = $('#deleteForm');
        $f.attr('action', '/admin/products/' + id);
        $f.submit();
    }

    function openLightbox(src) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightbox').classList.add('active');
    }
    function closeLightbox(e) {
        if (!e || e.target === e.currentTarget) {
            document.getElementById('lightbox').classList.remove('active');
        }
    }
    document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closeLightbox(); });

    function copyLandingLink(url, btn) {
        const fullUrl = url.startsWith('http') ? url : (window.location.origin + url);
        const fallback = () => {
            const ta = document.createElement('textarea');
            ta.value = fullUrl;
            document.body.appendChild(ta);
            ta.select();
            try { document.execCommand('copy'); } catch (e) {}
            document.body.removeChild(ta);
        };
        const flash = () => {
            const orig = btn.innerHTML;
            btn.innerHTML = '<i class="fas fa-check"></i>';
            btn.style.color = '#1e7e34';
            btn.style.borderColor = '#1e7e34';
            setTimeout(() => {
                btn.innerHTML = orig;
                btn.style.color = '';
                btn.style.borderColor = '';
            }, 1200);
        };
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(fullUrl).then(flash).catch(() => { fallback(); flash(); });
        } else {
            fallback(); flash();
        }
    }
</script>
@endpush
