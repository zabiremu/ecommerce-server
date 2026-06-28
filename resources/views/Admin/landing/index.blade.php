@extends('Admin.Layout.app')

@section('title', 'Landings')
@section('page_title', 'Landings')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Landings</h1>
    <a href="{{ route('admin.landings.create') }}" class="wp-add-new">Add New</a>
    @if ($search)
        <span class="text-[14px] text-[#50575e]">Search results for: <strong>"{{ $search }}"</strong></span>
    @endif
</div>

<form method="GET" action="{{ route('admin.landings.index') }}" class="flex justify-end mb-2">
    <div class="wp-search-box">
        <input type="text" name="s" value="{{ $search }}" placeholder="Search landings" class="wp-input w-56">
        <button type="submit" class="wp-btn">Search</button>
    </div>
</form>

<table class="wp-list-table">
    <thead>
        <tr>
            <th>Product</th>
            <th>URL</th>
            <th class="w-24">Layout</th>
            <th class="w-20">Blocks</th>
            <th class="w-20">Status</th>
            <th class="w-44 text-right">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($landings as $lp)
            <tr>
                <td>
                    <div class="flex items-center gap-2.5">
                        @if ($lp->product && $lp->product->thumbnail)
                            <img src="{{ Storage::url($lp->product->thumbnail) }}" alt="" class="w-9 h-9 rounded object-cover border border-[#dcdcde]">
                        @else
                            <div class="w-9 h-9 rounded bg-[#f0f0f1] border border-[#dcdcde] grid place-items-center text-[#787c82] text-[11px]"><i class="fas fa-image"></i></div>
                        @endif
                        <strong>
                            <a href="{{ route('admin.products.landing.edit', $lp->product) }}" class="text-[#2271b1] hover:text-[#135e96]">
                                {{ $lp->product->name ?? '— deleted product —' }}
                            </a>
                        </strong>
                    </div>
                </td>
                <td class="font-mono text-[12px] text-[#50575e]">/lp/{{ $lp->slug }}</td>
                <td>{{ \App\Http\Controllers\Admin\LandingPageController::LAYOUTS[$lp->layout] ?? ucfirst($lp->layout) }}</td>
                <td>{{ is_array($lp->blocks) ? count($lp->blocks) : 0 }}</td>
                <td>
                    <span class="wp-status-pill {{ $lp->is_active ? 'wp-status-on' : 'wp-status-off' }}">
                        {{ $lp->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="text-right">
                    <div class="inline-flex items-center gap-1.5">
                        @if ($lp->product)
                        <a href="{{ route('admin.products.landing.edit', $lp->product) }}"
                           class="inline-flex items-center gap-1 px-2 py-1 border border-[#2271b1] text-[#2271b1] rounded text-[12px] hover:bg-[#f0f6fc]">
                            <i class="fas fa-pen text-[10px]"></i> Edit
                        </a>
                        @endif
                        @if ($lp->is_active)
                        <a href="{{ route('landing-page', $lp->slug) }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-1 px-2 py-1 border border-[#00a32a] text-[#00a32a] rounded text-[12px] hover:bg-[#f0fdf4]">
                            <i class="fas fa-arrow-up-right-from-square text-[10px]"></i> Live
                        </a>
                        @endif
                        <button type="button" onclick="deleteLanding({{ $lp->id }})"
                                class="inline-flex items-center gap-1 px-2 py-1 border border-[#b32d2e] text-[#b32d2e] rounded text-[12px] hover:bg-[#fdecea]">
                            <i class="fas fa-trash text-[10px]"></i> Delete
                        </button>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="wc-empty">
                <i class="fas fa-bullseye text-2xl text-[#c3c4c7] mb-2 block"></i>
                No Landings yet. <a href="{{ route('admin.landings.create') }}" class="text-[#2271b1] hover:underline">Create your first one</a>.
            </td></tr>
        @endforelse
    </tbody>
</table>

<div class="flex items-center justify-between mt-3">
    <div class="text-[13px] text-[#50575e]">{{ $landings->total() }} item{{ $landings->total() === 1 ? '' : 's' }}</div>
    <div>{{ $landings->links() }}</div>
</div>

<form id="deleteLandingForm" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
function deleteLanding(id) {
    if (!confirm('Delete this landing page? This cannot be undone.')) return;
    var f = document.getElementById('deleteLandingForm');
    f.action = '{{ url('admin/landings') }}/' + id;
    f.submit();
}
</script>
@endpush
