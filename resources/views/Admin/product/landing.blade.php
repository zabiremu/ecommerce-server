@extends('Admin.Layout.app')

@section('title', 'Landing Page — ' . $product->name)
@section('page_title', 'Landing Page Builder')

@push('styles')
<style>
    body.font-sans { background: #f0f0f1 !important; }
    main { background: #f0f0f1 !important; }
    .wc-panel { background: #fff; border: 1px solid #c3c4c7; box-shadow: 0 1px 1px rgba(0,0,0,.04); border-radius: 4px; }
    .wc-panel-h { padding: 10px 14px; font-size: 13px; font-weight: 600; color: #1d2327; border-bottom: 1px solid #c3c4c7; display: flex; align-items: center; gap: 8px; }
    .wc-panel-body { padding: 14px 16px; }
    .wc-label { font-size: 13px; font-weight: 600; color: #1d2327; display: block; margin-bottom: 5px; }
    .wc-i { padding: 6px 10px; font-size: 13px; border: 1px solid #8c8f94; border-radius: 4px; background: #fff; outline: none; width: 100%; }
    .wc-i:focus { border-color: #2271b1; box-shadow: 0 0 0 1px #2271b1; }
    textarea.wc-i { resize: vertical; }
    .wc-f { margin-bottom: 12px; }
    .wc-f > label { display: block; font-size: 12.5px; font-weight: 600; color: #1d2327; margin-bottom: 4px; }
    .wc-opt { font-weight: 400; color: #787c82; font-size: 11px; }
    .wc-help { font-size: 11.5px; color: #646970; margin-top: 4px; }
    .wc-grid2 { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .wc-btn { padding: 7px 16px; font-size: 13px; font-weight: 500; border-radius: 3px; cursor: pointer; border: 1px solid; transition: all .15s; display: inline-flex; align-items: center; gap: 6px; }
    .wc-btn-primary { background: #2271b1; border-color: #2271b1; color: #fff; }
    .wc-btn-primary:hover { background: #135e96; border-color: #135e96; }
    .wc-btn-secondary { background: #f6f7f7; border-color: #c3c4c7; color: #2c3338; }
    .wc-btn-green { background: #00a32a; border-color: #00a32a; color: #fff; }
    .wc-btn-green:hover { background: #007a1f; }
    .wc-btn-sm { padding: 4px 10px; font-size: 12px; border: 1px dashed #2271b1; color: #2271b1; background: #f6fafe; border-radius: 4px; cursor: pointer; display: inline-flex; align-items: center; gap: 5px; }
    .wc-btn-sm:hover { background: #eef6fc; }
    /* Toggle switch */
    .toggle-sw { position: relative; display: inline-block; width: 38px; height: 20px; flex-shrink: 0; }
    .toggle-sw input { opacity: 0; width: 0; height: 0; }
    .toggle-sw .slider { position: absolute; inset: 0; background: #c3c4c7; border-radius: 20px; cursor: pointer; transition: .2s; }
    .toggle-sw .slider:before { content: ''; position: absolute; width: 14px; height: 14px; left: 3px; top: 3px; background: #fff; border-radius: 50%; transition: .2s; }
    .toggle-sw input:checked + .slider { background: #00a32a; }
    .toggle-sw input:checked + .slider:before { transform: translateX(18px); }
    .wc-toggle-row { display: flex; align-items: center; gap: 10px; padding: 9px 0; border-bottom: 1px solid #f0f0f1; }
    .wc-toggle-row:last-child { border-bottom: 0; }
    .wc-toggle-label { font-size: 13px; color: #1d2327; flex: 1; }
    .wc-toggle-desc { font-size: 11.5px; color: #646970; display: block; margin-top: 1px; }
    .url-preview { font-size: 12px; color: #2271b1; background: #f0f6fc; border: 1px solid #c6d9ee; border-radius: 3px; padding: 5px 10px; word-break: break-all; margin-top: 6px; }
    /* Blocks */
    .lb-block { border: 1px solid #dcdcde; border-radius: 6px; background: #fff; margin-bottom: 12px; box-shadow: 0 1px 2px rgba(0,0,0,.04); }
    .lb-block-h { display: flex; align-items: center; justify-content: space-between; padding: 8px 12px; background: #f6f7f7; border-bottom: 1px solid #e2e4e7; border-radius: 6px 6px 0 0; cursor: default; }
    .lb-block-title { font-size: 12.5px; font-weight: 700; color: #1d2327; display: flex; align-items: center; gap: 7px; }
    .lb-block-title i { color: #2271b1; }
    .lb-block-tools button { width: 26px; height: 26px; border: 1px solid #dcdcde; background: #fff; border-radius: 4px; color: #50575e; cursor: pointer; margin-left: 4px; font-size: 11px; }
    .lb-block-tools button:hover { background: #f0f0f1; color: #2271b1; }
    .lb-block-tools .lb-del:hover { color: #b32d2e; border-color: #f0b8b8; }
    .lb-block-body { padding: 12px 14px; }
    .lb-img-preview { margin-bottom: 8px; }
    .lb-img-preview img { max-height: 120px; border-radius: 6px; border: 1px solid #e2e4e7; background: #f8fafc; }
    .lb-item { display: flex; align-items: center; gap: 6px; margin-bottom: 6px; }
    .lb-item-del { width: 30px; height: 30px; flex-shrink: 0; border: 1px solid #f0b8b8; color: #b32d2e; background: #fff; border-radius: 4px; cursor: pointer; }
    .lb-item-del:hover { background: #fdecea; }
    .lb-empty { text-align: center; padding: 30px 12px; color: #787c82; font-size: 13px; border: 2px dashed #dcdcde; border-radius: 6px; }
    /* Lightweight rich-text editor (no external CDN) */
    .lb-rte { border: 1px solid #8c8f94; border-radius: 4px; overflow: hidden; background: #fff; }
    .lb-rte-toolbar { display: flex; flex-wrap: wrap; align-items: center; gap: 2px; padding: 5px 6px; background: #f6f7f7; border-bottom: 1px solid #dcdcde; }
    .lb-rte-toolbar button { min-width: 28px; height: 28px; padding: 0 7px; border: 1px solid transparent; background: transparent; border-radius: 4px; cursor: pointer; font-size: 12px; color: #1d2327; line-height: 1; }
    .lb-rte-toolbar button:hover { background: #e8eaed; border-color: #c3c4c7; }
    .lb-rte-sep { width: 1px; height: 18px; background: #dcdcde; margin: 0 4px; }
    .lb-rte-area { min-height: 140px; max-height: 360px; overflow-y: auto; padding: 10px 12px; font-size: 13.5px; line-height: 1.7; color: #1d2327; outline: none; }
    .lb-rte-area:focus { box-shadow: inset 0 0 0 2px rgba(34,113,177,.25); }
    .lb-rte-area:empty:before { content: attr(data-placeholder); color: #a7aaad; }
    .lb-rte-area h2 { font-size: 1.3em; font-weight: 700; margin: 8px 0; }
    .lb-rte-area h3 { font-size: 1.12em; font-weight: 700; margin: 8px 0; }
    .lb-rte-area ul, .lb-rte-area ol { padding-left: 22px; margin: 6px 0; }
    .lb-rte-area a { color: #2271b1; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px] rounded">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px] rounded">
        <ul class="list-disc list-inside space-y-1">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="flex items-center gap-2 text-[12.5px] text-[#646970] mb-4">
    <a href="{{ route('admin.landings.index') }}" class="text-[#2271b1] hover:underline">Landings</a>
    <i class="fas fa-chevron-right text-[9px]"></i>
    <span>{{ $product->name }}</span>
</div>

<form method="POST" action="{{ route('admin.products.landing.update', $product) }}" enctype="multipart/form-data" id="landingForm">
@csrf

<div class="grid grid-cols-1 xl:grid-cols-[1fr_300px] gap-4">

    {{-- ── Left: Blocks builder ────────────────────────────── --}}
    <div class="space-y-4">
        <div class="wc-panel">
            <div class="wc-panel-h" style="justify-content:space-between;">
                <span><i class="fas fa-layer-group text-blue-500"></i> Blocks</span>
                <div class="flex items-center gap-2">
                    <select id="addBlockType" class="wc-i" style="width:auto;font-size:12px;padding:5px 8px;">
                        <option value="youtube">YouTube Video</option>
                        <option value="rounded_heading">Rounded Heading</option>
                        <option value="richtext">Rich Text</option>
                        <option value="image">Image</option>
                        <option value="video_thumbs">Video Thumbnails</option>
                        <option value="price_offer">Price Offer</option>
                    </select>
                    <button type="button" class="wc-btn-sm" onclick="lbAddBlock()"><i class="fas fa-plus"></i> Add to blocks</button>
                </div>
            </div>
            <div class="wc-panel-body">
                <div id="blocksContainer">
                    @forelse (($landing->blocks ?? []) as $i => $block)
                        @include('Admin.landing._block_card', ['type' => $block['type'] ?? 'richtext', 'i' => $i, 'block' => $block])
                    @empty
                    @endforelse
                </div>
                <div id="blocksEmpty" class="lb-empty" style="{{ ($landing->blocks && count($landing->blocks)) ? 'display:none;' : '' }}">
                    No blocks yet. Use <strong>Add to blocks</strong> above to build your page.
                </div>
            </div>
        </div>
    </div>

    {{-- ── Right: Settings sidebar ─────────────────────────── --}}
    <div class="space-y-4">

        {{-- Status / Save --}}
        <div class="wc-panel">
            <div class="wc-panel-h"><i class="fas fa-toggle-on text-emerald-500"></i> Status</div>
            <div class="wc-panel-body">
                <div class="wc-toggle-row">
                    <label class="toggle-sw">
                        <input type="checkbox" name="is_active" value="1" id="isActiveToggle" {{ old('is_active', $landing->is_active) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <div class="wc-toggle-label">
                        <span id="activeLabel">{{ $landing->is_active ? 'Active' : 'Inactive' }}</span>
                        <span class="wc-toggle-desc">When active, the page is publicly accessible.</span>
                    </div>
                </div>
                <div class="mt-4 flex flex-col gap-2">
                    <button type="submit" class="wc-btn wc-btn-primary w-full justify-center"><i class="fas fa-save text-[11px]"></i> Save Landing Page</button>
                    @if ($landing->exists && $landing->is_active)
                    <a href="{{ route('landing-page', $landing->slug) }}" target="_blank" class="wc-btn wc-btn-green w-full justify-center text-center">
                        <i class="fas fa-arrow-up-right-from-square text-[11px]"></i> View Live Page
                    </a>
                    @endif
                    <a href="{{ route('admin.products.edit', $product) }}" class="wc-btn wc-btn-secondary w-full justify-center"><i class="fas fa-arrow-left text-[11px]"></i> Back to Product</a>
                </div>
            </div>
        </div>

        {{-- Top bar & CTA --}}
        <div class="wc-panel">
            <div class="wc-panel-h"><i class="fas fa-bullhorn text-amber-500"></i> Top Bar &amp; Button</div>
            <div class="wc-panel-body">
                <div class="wc-f"><label>Announcement (marquee) <span class="wc-opt">(optional)</span></label>
                    <input type="text" name="hero_subheading" class="wc-i" value="{{ old('hero_subheading', $landing->hero_subheading) }}"
                           placeholder="Scrolling text shown in the top gold bar">
                </div>
                <div class="wc-f"><label>Order button text</label>
                    <input type="text" name="cta_text" class="wc-i" value="{{ old('cta_text', $landing->cta_text ?: 'অর্ডার করতে চাই') }}"
                           placeholder="অর্ডার করতে চাই">
                    <p class="wc-help">Shown on the green "order" buttons and the form heading.</p>
                </div>
            </div>
        </div>

        {{-- Layout --}}
        <div class="wc-panel">
            <div class="wc-panel-h"><i class="fas fa-table-cells-large text-slate-500"></i> Layout</div>
            <div class="wc-panel-body">
                <select name="layout" class="wc-i">
                    @foreach ($layouts as $key => $label)
                        <option value="{{ $key }}" {{ old('layout', $landing->layout ?? 'default') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <p class="wc-help">Default matches the reference design; others are colour/spacing skins.</p>
            </div>
        </div>

        {{-- Shipping --}}
        <div class="wc-panel">
            <div class="wc-panel-h"><i class="fas fa-truck text-amber-500"></i> Shipping (TK)</div>
            <div class="wc-panel-body">
                <div class="wc-f"><label>Inside Dhaka</label>
                    <input type="number" step="0.01" min="0" name="shipping_inside_dhaka" class="wc-i"
                           value="{{ old('shipping_inside_dhaka', $landing->shipping_inside_dhaka ?? 0) }}">
                </div>
                <div class="wc-f"><label>Outside Dhaka</label>
                    <input type="number" step="0.01" min="0" name="shipping_outside_dhaka" class="wc-i"
                           value="{{ old('shipping_outside_dhaka', $landing->shipping_outside_dhaka ?? 80) }}">
                </div>
            </div>
        </div>

        {{-- Payment --}}
        <div class="wc-panel">
            <div class="wc-panel-h"><i class="fas fa-money-bill-wave text-green-600"></i> Payment</div>
            <div class="wc-panel-body">
                <p class="wc-help mb-2" style="margin-top:0;">Cash on Delivery is always available.</p>
                <div class="wc-toggle-row" style="border:0;padding:4px 0;">
                    <label class="toggle-sw">
                        <input type="checkbox" name="enable_online_payment" value="1" {{ old('enable_online_payment', $landing->enable_online_payment) ? 'checked' : '' }}>
                        <span class="slider"></span>
                    </label>
                    <div class="wc-toggle-label">Online payment (UddoktaPay)
                        <span class="wc-toggle-desc">Show bKash / Nagad / Card option.</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- URL / Slug --}}
        <div class="wc-panel">
            <div class="wc-panel-h"><i class="fas fa-link text-slate-500"></i> Page URL</div>
            <div class="wc-panel-body">
                <label class="wc-label">Slug</label>
                <div class="flex items-center gap-1">
                    <span class="text-[12px] text-[#646970] whitespace-nowrap">/lp/</span>
                    <input type="text" name="slug" id="slugInput" class="wc-i"
                           value="{{ old('slug', $landing->slug ?: Str::slug($product->name) . '-lp') }}"
                           pattern="[a-z0-9\-]+" title="Lowercase letters, numbers and hyphens only">
                </div>
                <div class="url-preview" id="urlPreview">{{ url('/lp') }}/{{ old('slug', $landing->slug ?: Str::slug($product->name) . '-lp') }}</div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="wc-panel">
            <div class="wc-panel-h"><i class="fas fa-shoe-prints text-slate-500"></i> Footer</div>
            <div class="wc-panel-body">
                <div class="wc-f"><label>Footer text <span class="wc-opt">(optional)</span></label>
                    <input type="text" name="footer_text" class="wc-i" value="{{ old('footer_text', $landing->footer_text) }}" placeholder="e.g. Call for help: 01XXXXXXXXX">
                </div>
                <div class="wc-f"><label>SEO Meta Title <span class="wc-opt">(optional)</span></label>
                    <input type="text" name="meta_title" class="wc-i" value="{{ old('meta_title', $landing->meta_title) }}">
                </div>
                <div class="wc-f"><label>SEO Meta Description <span class="wc-opt">(optional)</span></label>
                    <textarea name="meta_description" class="wc-i" rows="2">{{ old('meta_description', $landing->meta_description) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Product info --}}
        <div class="wc-panel">
            <div class="wc-panel-h"><i class="fas fa-box text-slate-400"></i> Product</div>
            <div class="wc-panel-body">
                @if ($product->thumbnail)
                <img src="{{ Storage::url($product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-24 object-contain rounded mb-2 bg-slate-50">
                @endif
                <p class="text-[13px] font-semibold text-[#1d2327]">{{ $product->name }}</p>
                <p class="text-[12px] font-semibold text-[#2271b1] mt-1">TK {{ number_format($product->selling_price) }}</p>
            </div>
        </div>

    </div>
</div>
</form>

{{-- ── JS templates for new blocks ─────────────────────────── --}}
@foreach (['youtube','rounded_heading','richtext','image','video_thumbs','price_offer'] as $t)
<template id="tpl-{{ $t }}">@include('Admin.landing._block_card', ['type' => $t, 'i' => '__INDEX__', 'block' => []])</template>
@endforeach

<template id="tpl-video-item">
    <div class="lb-item">
        <input type="text" name="blocks[__INDEX__][items][__J__][url]" class="wc-i" placeholder="YouTube link">
        <input type="text" name="blocks[__INDEX__][items][__J__][label]" class="wc-i" placeholder="Label (optional)">
        <button type="button" class="lb-item-del" onclick="lbRemoveItem(this)"><i class="fas fa-xmark"></i></button>
    </div>
</template>

@endsection

@push('scripts')
<script>
    let lbIndex = {{ ($landing->blocks ? count($landing->blocks) : 0) }};

    // ── Lightweight rich-text editor (contenteditable, no external CDN) ──
    function lbRteSync(rte) {
        var area = rte.querySelector('.lb-rte-area');
        var input = rte.querySelector('.lb-rte-input');
        if (area && input) input.value = area.innerHTML.trim() === '<br>' ? '' : area.innerHTML;
    }
    function lbRteSyncAll() {
        document.querySelectorAll('#blocksContainer [data-rte]').forEach(lbRteSync);
    }
    // Toolbar clicks (delegated so dynamically added editors work)
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.lb-rte-toolbar button');
        if (!btn) return;
        e.preventDefault();
        var rte  = btn.closest('[data-rte]');
        var area = rte.querySelector('.lb-rte-area');
        area.focus();
        if (btn.hasAttribute('data-link')) {
            var url = prompt('Enter the link URL:', 'https://');
            if (url) document.execCommand('createLink', false, url);
        } else if (btn.hasAttribute('data-block')) {
            document.execCommand('formatBlock', false, btn.getAttribute('data-block'));
        } else if (btn.hasAttribute('data-cmd')) {
            document.execCommand(btn.getAttribute('data-cmd'), false, null);
        }
        lbRteSync(rte);
    });
    // Keep hidden textarea in sync as the user types
    document.addEventListener('input', function (e) {
        if (e.target.classList && e.target.classList.contains('lb-rte-area')) {
            lbRteSync(e.target.closest('[data-rte]'));
        }
    });

    function lbRefreshEmpty() {
        var has = document.querySelectorAll('#blocksContainer .lb-block').length > 0;
        document.getElementById('blocksEmpty').style.display = has ? 'none' : '';
    }

    function lbAddBlock() {
        var type = document.getElementById('addBlockType').value;
        var tpl  = document.getElementById('tpl-' + type);
        if (!tpl) return;
        var html = tpl.innerHTML.replace(/__INDEX__/g, lbIndex);
        lbIndex++;
        var wrap = document.createElement('div');
        wrap.innerHTML = html.trim();
        document.getElementById('blocksContainer').appendChild(wrap.firstChild);
        lbRefreshEmpty();
    }

    function lbRemove(btn) {
        var block = btn.closest('.lb-block');
        if (block) block.remove();
        lbRefreshEmpty();
    }

    function lbMove(btn, dir) {
        var block = btn.closest('.lb-block');
        if (!block) return;
        if (dir < 0 && block.previousElementSibling) {
            block.parentNode.insertBefore(block, block.previousElementSibling);
        } else if (dir > 0 && block.nextElementSibling) {
            block.parentNode.insertBefore(block.nextElementSibling, block);
        }
    }

    function lbImgPreview(input) {
        var box = input.closest('.wc-f').querySelector('.lb-img-preview');
        if (!box) return;
        var file = input.files && input.files[0];
        if (!file) return;
        var img = box.querySelector('img');
        img.src = URL.createObjectURL(file);
        box.style.display = '';
    }

    function lbAddVideoItem(btn) {
        var block = btn.closest('.lb-block');
        var idx = block.getAttribute('data-index');
        var j   = parseInt(block.getAttribute('data-jindex') || '0', 10);
        block.setAttribute('data-jindex', j + 1);
        var tpl = document.getElementById('tpl-video-item');
        var html = tpl.innerHTML.replace(/__INDEX__/g, idx).replace(/__J__/g, j);
        var wrap = document.createElement('div');
        wrap.innerHTML = html.trim();
        block.querySelector('.lb-items').appendChild(wrap.firstChild);
    }

    function lbRemoveItem(btn) {
        var item = btn.closest('.lb-item');
        if (item) item.remove();
    }

    // Slug → URL preview
    document.getElementById('slugInput').addEventListener('input', function () {
        this.value = this.value.toLowerCase().replace(/[^a-z0-9\-]/g, '');
        document.getElementById('urlPreview').textContent = '{{ url('/lp') }}/' + this.value;
    });
    // Active label
    document.getElementById('isActiveToggle').addEventListener('change', function () {
        document.getElementById('activeLabel').textContent = this.checked ? 'Active' : 'Inactive';
    });
    // Ensure rich-text content is saved into the hidden textareas before submit
    document.getElementById('landingForm').addEventListener('submit', function () {
        lbRteSyncAll();
    });

    // Init on load
    lbRefreshEmpty();
</script>
@endpush
