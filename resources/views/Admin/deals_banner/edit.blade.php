@extends('Admin.Layout.app')

@section('title', 'Deals Banner')
@section('page_title', 'Deals Banner')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .deal-preview { background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%); color: #fff; padding: 36px 28px; border-radius: 6px; text-align: center; }
    .deal-preview h2 { font-size: 26px; font-weight: 700; margin: 0 0 8px; }
    .deal-preview h2 span { background: rgba(255,255,255,.2); padding: 2px 10px; border-radius: 4px; }
    .deal-preview p { font-size: 14px; opacity: .95; margin: 0 0 14px; }
    .deal-preview a { display: inline-block; background: #fff; color: #ee5a52; padding: 8px 20px; border-radius: 4px; font-weight: 600; font-size: 13px; text-decoration: none; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">Deals Banner</h1>
</div>

<form method="POST" action="{{ route('admin.deals-banner.update') }}">
    @csrf @method('PUT')

    @if ($errors->any())
        <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
            <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid grid-cols-12 gap-5 mt-3">
        <div class="col-span-12 lg:col-span-8 space-y-5">

            <div class="wp-panel">
                <div class="wp-panel-h">Banner Content</div>
                <div class="wp-panel-body">
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <div class="wp-field sm:col-span-1">
                            <label>Emoji</label>
                            <input type="text" name="emoji" value="{{ old('emoji', $banner->emoji) }}" maxlength="10" class="wp-input" placeholder="🔥">
                            <p class="wp-help">Shown before the title.</p>
                        </div>
                        <div class="wp-field sm:col-span-3">
                            <label>Title <span class="text-[#d63638]">*</span></label>
                            <input type="text" name="title" value="{{ old('title', $banner->title) }}" required maxlength="255" class="wp-input" placeholder="e.g. Limited Time">
                        </div>
                    </div>

                    <div class="wp-field">
                        <label>Highlighted Word(s)</label>
                        <input type="text" name="title_highlight" value="{{ old('title_highlight', $banner->title_highlight) }}" maxlength="255" class="wp-input" placeholder="e.g. Mega Deals">
                        <p class="wp-help">Shown next to the title with a colored highlight.</p>
                    </div>

                    <div class="wp-field">
                        <label>Description</label>
                        <textarea name="description" rows="3" maxlength="1000" class="wp-input">{{ old('description', $banner->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="wp-field">
                            <label>Button Text</label>
                            <input type="text" name="button_text" value="{{ old('button_text', $banner->button_text) }}" maxlength="100" class="wp-input" placeholder="e.g. Grab Your Deal">
                        </div>
                        <div class="wp-field">
                            <label>Button Link</label>
                            <input type="text" name="button_link" value="{{ old('button_link', $banner->button_link) }}" maxlength="500" class="wp-input" placeholder="e.g. /all-products">
                        </div>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Preview</div>
                <div class="wp-panel-body">
                    <div class="deal-preview">
                        <h2>{{ $banner->emoji }} {{ $banner->title }} @if ($banner->title_highlight)<span>{{ $banner->title_highlight }}</span>@endif</h2>
                        @if ($banner->description)<p>{{ $banner->description }}</p>@endif
                        @if ($banner->button_text)<a href="javascript:void(0)"><i class="fas fa-bolt mr-1"></i> {{ $banner->button_text }}</a>@endif
                    </div>
                    <p class="wp-help mt-2">Preview reflects the saved state. Save changes to refresh.</p>
                </div>
            </div>

        </div>

        <div class="col-span-12 lg:col-span-4 space-y-5">

            <div class="wp-panel">
                <div class="wp-panel-h">Visibility</div>
                <div class="wp-panel-body">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" {{ old('status', $banner->status) ? 'checked' : '' }}>
                        <span class="text-[13px]"><strong>Show on Homepage</strong></span>
                    </label>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Save</div>
                <div class="wp-panel-body">
                    <button type="submit" class="wp-btn wp-btn-primary w-full">Update Banner</button>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection
