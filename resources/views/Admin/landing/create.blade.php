@extends('Admin.Layout.app')

@section('title', 'Create Landing')
@section('page_title', 'Create Landing')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Create Landing</h1>
    <a href="{{ route('admin.landings.index') }}" class="wp-add-new">← All Landings</a>
</div>

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

@if ($products->isEmpty())
    <div class="wp-panel"><div class="wp-panel-body">
        <p class="text-[13px] text-[#50575e]">
            Every product already has a landing page, or there are no products yet.
            <a href="{{ route('admin.products.index') }}" class="text-[#2271b1] hover:underline">Manage products</a>.
        </p>
    </div></div>
@else
<form method="POST" action="{{ route('admin.landings.store') }}">
    @csrf
    <div class="max-w-xl">
        <div class="wp-panel">
            <div class="wp-panel-h">New Landing Page</div>
            <div class="wp-panel-body">

                <div class="wp-field">
                    <label>Product <span class="text-red-500">*</span></label>
                    <select name="product_id" id="productSelect" class="wp-input" required>
                        <option value="">— Select a product —</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}"
                                    data-slug="{{ \Illuminate\Support\Str::slug($p->name) }}-lp"
                                    {{ old('product_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->name }} — TK {{ number_format($p->selling_price) }}
                            </option>
                        @endforeach
                    </select>
                    <p class="wp-help">Only products without a landing page are listed.</p>
                </div>

                <div class="wp-field">
                    <label>Link (slug) <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-1">
                        <span class="text-[12px] text-[#646970] whitespace-nowrap">/lp/</span>
                        <input type="text" name="slug" id="slugInput" class="wp-input"
                               value="{{ old('slug') }}" pattern="[a-z0-9\-]+"
                               title="Lowercase letters, numbers and hyphens only" required>
                    </div>
                    <p class="wp-help">Lowercase letters, numbers and hyphens only.</p>
                </div>

                <div class="wp-field">
                    <label>Layout <span class="text-red-500">*</span></label>
                    <select name="layout" class="wp-input" required>
                        @foreach ($layouts as $key => $label)
                            <option value="{{ $key }}" {{ old('layout', 'default') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-2 mt-4">
                    <button type="submit" class="wp-btn wp-btn-primary">Create</button>
                    <a href="{{ route('admin.landings.index') }}" class="wp-btn">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endif

@endsection

@push('scripts')
<script>
    const sel = document.getElementById('productSelect');
    const slugInput = document.getElementById('slugInput');
    let slugTouched = {{ old('slug') ? 'true' : 'false' }};

    if (sel) {
        sel.addEventListener('change', function () {
            if (!slugTouched) {
                const opt = this.options[this.selectedIndex];
                slugInput.value = opt ? (opt.dataset.slug || '') : '';
            }
        });
    }
    if (slugInput) {
        slugInput.addEventListener('input', function () {
            slugTouched = true;
            this.value = this.value.toLowerCase().replace(/[^a-z0-9\-]/g, '');
        });
    }
</script>
@endpush
