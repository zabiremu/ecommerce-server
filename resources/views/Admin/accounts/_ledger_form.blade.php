{{-- Fields for an Expense / Investment entry. Expects $cfg, $categories, $methods; optional $entry. --}}
@php $e = $entry ?? null; @endphp

@if ($errors->any())
    <div class="mb-3 px-3 py-2 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
    </div>
@endif

<div class="wp-field">
    <label>Date <span class="text-[#d63638]">*</span></label>
    <input type="date" name="entry_date" value="{{ old('entry_date', $e?->entry_date?->toDateString() ?? $defaultDate ?? '') }}" class="wp-input" required>
</div>
<div class="wp-field">
    <label>Category <span class="text-[#d63638]">*</span></label>
    <select name="category" class="wp-input" required>
        @foreach ($categories as $key => $label)
            <option value="{{ $key }}" @selected(old('category', $e?->category) === $key)>{{ $label }}</option>
        @endforeach
    </select>
</div>
<div class="wp-field">
    <label>Description <span class="text-[#d63638]">*</span></label>
    <input type="text" name="title" value="{{ old('title', $e?->title) }}" maxlength="191" class="wp-input" required
           placeholder="{{ $cfg['singular'] === 'Expense' ? 'e.g. October shop rent' : 'e.g. Display rack for the shop' }}">
</div>
<div class="wp-field">
    <label>Amount (৳) <span class="text-[#d63638]">*</span></label>
    <input type="number" name="amount" step="0.01" min="0.01" value="{{ old('amount', $e?->amount) }}" class="wp-input" required>
</div>
<div class="wp-field">
    <label>Paid by <span class="font-normal text-[#646970]">(optional)</span></label>
    <select name="payment_method" class="wp-input">
        <option value="">—</option>
        @foreach ($methods as $m)
            <option value="{{ $m }}" @selected(old('payment_method', $e?->payment_method) === $m)>{{ ucfirst($m) }}</option>
        @endforeach
    </select>
</div>
<div class="wp-field">
    <label>Note <span class="font-normal text-[#646970]">(optional)</span></label>
    <input type="text" name="note" value="{{ old('note', $e?->note) }}" maxlength="500" class="wp-input">
</div>
