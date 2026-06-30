@php
    $s = $slider ?? null;
@endphp

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-8 space-y-5">

        <div class="wp-panel">
            <div class="wp-panel-h">Slide Content</div>
            <div class="wp-panel-body">
                <div class="wp-field">
                    <label>Title <span class="text-[#d63638]">*</span></label>
                    <input type="text" name="title" value="{{ old('title', $s->title ?? '') }}" required maxlength="255" class="wp-input" placeholder="e.g. Premium Products">
                    <p class="wp-help">The main heading. You can split into two lines using "Title" + "Subtitle".</p>
                </div>

                <div class="wp-field">
                    <label>Subtitle (highlighted second line)</label>
                    <input type="text" name="subtitle" value="{{ old('subtitle', $s->subtitle ?? '') }}" maxlength="255" class="wp-input" placeholder="e.g. At Best Prices">
                </div>

                <div class="wp-field">
                    <label>Description</label>
                    <textarea name="description" rows="3" maxlength="1000" class="wp-input">{{ old('description', $s->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Image</div>
            <div class="wp-panel-body">
                <div class="wp-field">
                    <label>Slide Image @if (!$s)<span class="text-[#d63638]">*</span>@endif</label>
                    <input type="file" name="image" accept="image/*" class="wp-input" @if (!$s) required @endif onchange="previewSliderImage(event)">
                    <p class="wp-help">Recommended size: 1920 × 800. Formats: JPG, PNG, WEBP. Max 4 MB.</p>
                </div>

                <div class="mt-2">
                    <img id="sliderImagePreview" src="{{ $s && $s->image ? Storage::url($s->image) : '' }}" alt=""
                         style="max-width: 100%; height: auto; border-radius: 4px; border: 1px solid #dcdcde; {{ $s && $s->image ? '' : 'display:none' }}">
                </div>
            </div>
        </div>

    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">

        <div class="wp-panel">
            <div class="wp-panel-h">Display</div>
            <div class="wp-panel-body">
                <label class="flex items-center gap-2 cursor-pointer mt-2">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" {{ old('status', $s->status ?? true) ? 'checked' : '' }}>
                    <span class="text-[13px]"><strong>Active</strong> — show on the homepage.</span>
                </label>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Publish</div>
            <div class="wp-panel-body">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.sliders.index') }}" class="wp-btn-link">Cancel</a>
                    <button type="submit" class="wp-btn wp-btn-primary">{{ $s ? 'Update Slider' : 'Create Slider' }}</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function previewSliderImage(e) {
        const file = e.target.files[0];
        if (!file) return;
        const img = document.getElementById('sliderImagePreview');
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
    }
</script>
