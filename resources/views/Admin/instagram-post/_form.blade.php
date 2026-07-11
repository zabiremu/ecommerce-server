@php
    $p = $instagramPost ?? null;
@endphp

@if ($errors->any())
    <div class="mb-4 px-3 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">
        <ul class="list-disc list-inside">@foreach ($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-8 space-y-5">

        <div class="wp-panel">
            <div class="wp-panel-h">Post Image</div>
            <div class="wp-panel-body">
                <div class="wp-field">
                    <label>Image @if (!$p)<span class="text-[#d63638]">*</span>@endif</label>
                    <input type="file" name="image" accept="image/*" class="wp-input" @if (!$p) required @endif onchange="previewInstaImage(event)">
                    <p class="wp-help">Recommended size: 512 × 512 (square). Formats: JPG, PNG, WEBP. Max 4 MB.</p>
                </div>

                <div class="mt-2">
                    <img id="instaImagePreview" src="{{ $p && $p->image ? Storage::url($p->image) : '' }}" alt=""
                         style="max-width: 240px; height: auto; border-radius: 4px; border: 1px solid #dcdcde; {{ $p && $p->image ? '' : 'display:none' }}">
                </div>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Post Details</div>
            <div class="wp-panel-body">
                <div class="wp-field">
                    <label>Link</label>
                    <input type="url" name="link" value="{{ old('link', $p->link ?? '') }}" maxlength="255" class="wp-input" placeholder="https://www.instagram.com/p/...">
                    <p class="wp-help">Where the post should link to. Leave blank to link nowhere.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="wp-field">
                        <label>Likes</label>
                        <input type="number" name="likes_count" value="{{ old('likes_count', $p->likes_count ?? 0) }}" min="0" class="wp-input">
                    </div>
                    <div class="wp-field">
                        <label>Comments</label>
                        <input type="number" name="comments_count" value="{{ old('comments_count', $p->comments_count ?? 0) }}" min="0" class="wp-input">
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">

        <div class="wp-panel">
            <div class="wp-panel-h">Display</div>
            <div class="wp-panel-body">
                <div class="wp-field">
                    <label>Sort Order</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', $p->sort_order ?? 0) }}" min="0" class="wp-input">
                    <p class="wp-help">Lower numbers appear first.</p>
                </div>

                <label class="flex items-center gap-2 cursor-pointer mt-2">
                    <input type="hidden" name="status" value="0">
                    <input type="checkbox" name="status" value="1" {{ old('status', $p->status ?? true) ? 'checked' : '' }}>
                    <span class="text-[13px]"><strong>Active</strong> — show on the homepage.</span>
                </label>
            </div>
        </div>

        <div class="wp-panel">
            <div class="wp-panel-h">Publish</div>
            <div class="wp-panel-body">
                <div class="flex items-center justify-between">
                    <a href="{{ route('admin.instagram-posts.index') }}" class="wp-btn-link">Cancel</a>
                    <button type="submit" class="wp-btn wp-btn-primary">{{ $p ? 'Update Post' : 'Create Post' }}</button>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    function previewInstaImage(e) {
        const file = e.target.files[0];
        if (!file) return;
        const img = document.getElementById('instaImagePreview');
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
    }
</script>
