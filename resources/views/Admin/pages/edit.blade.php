@extends('Admin.Layout.app')

@section('title', 'Edit — ' . $page->title)
@section('page_title', 'Edit — ' . $page->title)

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif

<div class="flex items-center gap-3 mb-3">
    <h1 class="wp-h1">
        @if($page->icon)<i class="{{ $page->icon }} mr-1.5 text-[#50575e]"></i>@endif
        {{ $page->title }}
    </h1>
    <a href="{{ route('admin.pages.index') }}" class="wp-add-new">← All Pages</a>
    <a href="{{ route($page->slug) }}" target="_blank" class="wp-add-new ml-auto" style="background:#f6f7f7;color:#2271b1;border-color:#c3c4c7">
        <i class="fas fa-external-link-alt mr-1"></i> View Page
    </a>
</div>

<form method="POST" action="{{ route('admin.pages.update', $page) }}">
    @csrf @method('PUT')

    @if ($errors->any())
        <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
            <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    <div class="grid grid-cols-12 gap-5">
        <div class="col-span-12 lg:col-span-8 space-y-5">

            <div class="wp-panel">
                <div class="wp-panel-h">Page Content</div>
                <div class="wp-panel-body">
                    <div class="wp-field">
                        <label>Content</label>
                        <div id="pageContentEditor"></div>
                        <textarea name="content" id="pageContent" class="hidden">{{ old('content', $page->content) }}</textarea>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-span-12 lg:col-span-4 space-y-5">

            <div class="wp-panel">
                <div class="wp-panel-h">Publish</div>
                <div class="wp-panel-body">
                    <button type="submit" class="wp-btn wp-btn-primary w-full justify-center">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">Page Info</div>
                <div class="wp-panel-body space-y-3">
                    <div class="wp-field">
                        <label>Page Title</label>
                        <input type="text" name="title" value="{{ old('title', $page->title) }}" required class="wp-input">
                    </div>
                    <div class="wp-field">
                        <label>Subtitle</label>
                        <input type="text" name="subtitle" value="{{ old('subtitle', $page->subtitle) }}" class="wp-input" placeholder="Shown below the title">
                    </div>
                    <div class="wp-field">
                        <label>Header Icon</label>
                        @include('Admin._partials.icon-picker', [
                            'name'  => 'icon',
                            'id'    => 'pageIcon',
                            'value' => old('icon', $page->icon ?? ''),
                        ])
                    </div>
                    <div class="wp-field">
                        <label>Last Updated Label</label>
                        <input type="text" name="last_updated_label" value="{{ old('last_updated_label', $page->last_updated_label) }}" class="wp-input" placeholder="e.g. May 8, 2026">
                        <p class="wp-help">Shown at the top of the page content.</p>
                    </div>
                </div>
            </div>

            <div class="wp-panel">
                <div class="wp-panel-h">SEO</div>
                <div class="wp-panel-body space-y-3">
                    <div class="wp-field">
                        <label>Meta Title</label>
                        <input type="text" name="meta_title" value="{{ old('meta_title', $page->meta_title) }}" class="wp-input" maxlength="255">
                    </div>
                    <div class="wp-field">
                        <label>Meta Description</label>
                        <textarea name="meta_description" rows="3" class="wp-input" maxlength="500">{{ old('meta_description', $page->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
    #pageContentEditor .ql-editor{min-height:500px;font-size:14px;line-height:1.6}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
const pageContentInput = document.getElementById('pageContent');

const quill = new Quill('#pageContentEditor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ header: [1, 2, 3, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            [{ align: [] }],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            ['clean'],
        ],
    },
});

quill.clipboard.dangerouslyPasteHTML(pageContentInput.value);

pageContentInput.closest('form').addEventListener('submit', function () {
    pageContentInput.value = quill.getSemanticHTML();
});
</script>
@endpush
