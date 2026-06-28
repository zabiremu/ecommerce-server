@extends('Admin.Layout.app')

@section('title', 'Categories')
@section('page_title', 'Categories')

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .seo-toggle { font-size: 13px; color: #2271b1; cursor: pointer; padding: 6px 0; display: inline-flex; align-items: center; gap: 6px; }
    .seo-toggle:hover { color: #135e96; }
</style>
@endpush

@section('content')

<h1 class="wp-h1">Categories</h1>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h" id="formTitle">Add New Category</div>
            <div class="wp-panel-body">
                <form id="categoryForm" method="POST">
                    @csrf
                    <input type="hidden" id="methodField" name="_method" value="POST">

                    <div class="wp-field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="wp-input" required>
                        <p id="nameError" class="wp-err" style="display:none"></p>
                    </div>

                    <div class="wp-field">
                        <label for="slug">Slug</label>
                        <input type="text" id="slug" name="slug" class="wp-input">
                        <p class="wp-help">Leave empty to auto-generate.</p>
                    </div>

                    <div class="wp-field">
                        <label for="parent_id">Parent Category</label>
                        <select id="parent_id" name="parent_id" class="wp-input">
                            <option value="">— None (Top Level) —</option>
                            @foreach ($categories as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                        <p id="parentError" class="wp-err" style="display:none"></p>
                    </div>

                    <div class="wp-field">
                        <label>Icon</label>
                        @include('Admin._partials.icon-picker', ['name' => 'icon', 'id' => 'catIcon', 'value' => ''])
                    </div>

                    <div class="wp-field">
                        <label for="image">Homepage Image</label>
                        <input type="file" id="image" name="image" accept="image/*" class="wp-input">
                        <p class="wp-help">Used in the "Shop by Category" section on the homepage. Recommended 500×500.</p>
                        <div class="mt-2">
                            <img id="imagePreview" src="" alt="" style="max-width:120px;border-radius:4px;border:1px solid #dcdcde;display:none">
                        </div>
                    </div>

                    <label class="flex items-center gap-2 cursor-pointer mt-1">
                        <input type="hidden" name="home_visible" value="0">
                        <input type="checkbox" id="home_visible" name="home_visible" value="1">
                        <span class="text-[13px]"><strong>Show on Homepage</strong></span>
                    </label>

                    <div class="wp-field mt-2">
                        <label for="home_order">Homepage Order</label>
                        <input type="number" id="home_order" name="home_order" min="0" value="0" class="wp-input">
                        <p class="wp-help">Lower values appear first.</p>
                    </div>

                    <div class="seo-toggle" onclick="$('#seoBlock').toggle(); $(this).find('i.chev').toggleClass('rotate-180');">
                        <i class="fas fa-search"></i> SEO <i class="fas fa-chevron-down chev text-[10px] transition"></i>
                    </div>
                    <div id="seoBlock" style="display:none">
                        <div class="wp-field">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" maxlength="70" class="wp-input">
                            <p class="wp-help"><span id="metaTitleCount">0</span>/70 characters</p>
                        </div>
                        <div class="wp-field">
                            <label for="meta_description">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="3" maxlength="320" class="wp-input"></textarea>
                            <p class="wp-help"><span id="metaDescCount">0</span>/320 characters</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 mt-2">
                        <button type="submit" id="submitBtn" class="wp-btn wp-btn-primary">Add New Category</button>
                        <button type="button" id="cancelEditBtn" class="wp-btn-link" style="display:none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-8">
        <div class="wp-search-box mb-2 justify-end">
            <input type="search" id="searchInput" class="wp-input" style="max-width: 240px;" placeholder="Search categories">
        </div>

        <table class="wp-list-table">
            <thead>
                <tr>
                    <th style="width: 70px;">Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Parent</th>
                    <th class="text-center" style="width: 80px;">Home</th>
                    <th class="text-center" style="width: 100px;">Status</th>
                </tr>
            </thead>
            <tbody id="categoryTbody">
                @forelse ($categories as $cat)
                    <tr data-row-id="{{ $cat->id }}">
                        <td>
                            @if ($cat->image)
                                <img src="{{ Storage::url($cat->image) }}" alt="" style="width:50px;height:50px;object-fit:cover;border-radius:4px;border:1px solid #dcdcde">
                            @else
                                <span class="text-[#c3c4c7]">—</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center gap-2">
                                @if ($cat->icon)
                                    @php $ci = str_contains($cat->icon, ' ') ? $cat->icon : 'fas ' . $cat->icon; @endphp
                                    <i class="{{ $ci }} text-[#787c82] text-[13px] w-4"></i>
                                @endif
                                <strong><a href="javascript:void(0)" onclick="editCategory({{ $cat->id }})" class="text-[#2271b1] hover:text-[#135e96]">{{ $cat->name }}</a></strong>
                            </div>
                            <div class="wp-row-actions">
                                <span><button type="button" onclick="editCategory({{ $cat->id }})">Edit</button> |</span>
                                <span><button type="button" class="trash" onclick="deleteCategory({{ $cat->id }}, '{{ addslashes($cat->name) }}')">Delete</button></span>
                            </div>
                        </td>
                        <td class="text-[#50575e]">{{ $cat->slug }}</td>
                        <td class="text-[#50575e]">{{ $cat->parent?->name ?? '—' }}</td>
                        <td class="text-center">
                            @if ($cat->home_visible)
                                <i class="fas fa-check text-emerald-600"></i>
                                <div class="text-[11px] text-[#50575e]">#{{ $cat->home_order }}</div>
                            @else
                                <span class="text-[#c3c4c7]">—</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="wp-status-pill {{ $cat->status ? 'wp-status-on' : 'wp-status-off' }}"
                                  onclick="toggleStatus({{ $cat->id }})">
                                {{ $cat->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-[#787c82] py-6">No categories found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-[13px] text-[#50575e] mt-2">{{ count($categories) }} item{{ count($categories) === 1 ? '' : 's' }}</div>
    </div>
</div>

@endsection

@push('scripts')
@include('Admin._partials.wp-scripts')
<script>
    let allCategories = @json($categories);

    $(function () {
        $('#name').on('keyup', function () {
            if (!$('#slug').data('manual')) {
                $('#slug').val($(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, ''));
            }
        });
        $('#slug').on('input', function () { $(this).data('manual', !!$(this).val()); });

        $('#meta_title').on('input', function () { $('#metaTitleCount').text($(this).val().length); });
        $('#meta_description').on('input', function () { $('#metaDescCount').text($(this).val().length); });

        $('#searchInput').on('input', function () {
            var q = $(this).val().toLowerCase();
            $('#categoryTbody tr').each(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
            });
        });

        // icon-picker close handled globally in icon-picker partial

        $('#image').on('change', function (e) {
            var file = e.target.files[0];
            if (!file) return;
            $('#imagePreview').attr('src', URL.createObjectURL(file)).show();
        });

        $('#categoryForm').on('submit', function (e) {
            e.preventDefault();
            $('#nameError').hide(); $('#parentError').hide();
            var isEdit = $('#methodField').val() === 'PUT';
            var id = $(this).data('edit-id');
            var url = isEdit ? '/admin/categories/' + id : '{{ route('admin.categories.store') }}';
            var fd = new FormData(this);
            if (isEdit) fd.append('_method', 'PUT');
            $.ajax({
                url: url,
                method: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function (res) {
                    wpToast(res.message, 'success');
                    setTimeout(function () { location.reload(); }, 400);
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON.errors) {
                        var errs = xhr.responseJSON.errors;
                        if (errs.name) $('#nameError').text(errs.name[0]).show();
                        if (errs.parent_id) $('#parentError').text(errs.parent_id[0]).show();
                        var other = Object.keys(errs).find(function (k) { return k !== 'name' && k !== 'parent_id'; });
                        if (other) wpToast(errs[other][0], 'error');
                    } else {
                        wpToast('Something went wrong.', 'error');
                    }
                }
            });
        });

        $('#cancelEditBtn').on('click', function () { resetForm(); });
    });

    // selectIcon replaced by ipSelect from icon-picker partial

    function editCategory(id) {
        var c = allCategories.find(function (x) { return x.id === id; });
        if (!c) return;
        $('#name').val(c.name);
        $('#slug').val(c.slug).data('manual', true);
        $('#parent_id').val(c.parent_id || '');
        // Normalize old 'fa-*' format to full 'fas fa-*'
        var iconVal = c.icon || '';
        if (iconVal && !iconVal.includes(' ')) iconVal = 'fas ' + iconVal;
        ipSetValue('catIcon', iconVal);
        $('#image').val('');
        if (c.image) {
            $('#imagePreview').attr('src', '{{ url('storage') }}/' + c.image).show();
        } else {
            $('#imagePreview').hide().attr('src', '');
        }
        $('#home_visible').prop('checked', !!c.home_visible);
        $('#home_order').val(c.home_order || 0);
        $('#meta_title').val(c.meta_title || ''); $('#metaTitleCount').text((c.meta_title || '').length);
        $('#meta_description').val(c.meta_description || ''); $('#metaDescCount').text((c.meta_description || '').length);

        $('#parent_id option').each(function () {
            $(this).prop('disabled', $(this).val() == id);
        });

        $('#methodField').val('PUT');
        $('#categoryForm').data('edit-id', id);
        $('#formTitle').text('Edit Category');
        $('#submitBtn').text('Update Category');
        $('#cancelEditBtn').show();
        $('html, body').animate({ scrollTop: 0 }, 200);
    }

    function resetForm() {
        $('#categoryForm')[0].reset();
        $('#slug').data('manual', false);
        ipSetValue('catIcon', '');
        $('#imagePreview').hide().attr('src', '');
        $('#metaTitleCount').text('0'); $('#metaDescCount').text('0');
        $('#parent_id option').prop('disabled', false);
        $('#methodField').val('POST');
        $('#categoryForm').removeData('edit-id');
        $('#formTitle').text('Add New Category');
        $('#submitBtn').text('Add New Category');
        $('#cancelEditBtn').hide();
        $('#nameError').hide(); $('#parentError').hide();
    }

    function toggleStatus(id) {
        $.ajax({
            url: '/admin/categories/' + id + '/toggle-status',
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                wpToast(res.message, 'success');
                setTimeout(function () { location.reload(); }, 300);
            },
            error: function () { wpToast('Failed to update.', 'error'); }
        });
    }

    function deleteCategory(id, name) {
        if (!confirm('Delete "' + name + '"?')) return;
        $.ajax({
            url: '/admin/categories/' + id,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                wpToast(res.message, 'success');
                setTimeout(function () { location.reload(); }, 400);
            },
            error: function (xhr) {
                var msg = xhr.responseJSON?.message || 'Failed to delete.';
                wpToast(msg, 'error');
            }
        });
    }
</script>
@endpush
