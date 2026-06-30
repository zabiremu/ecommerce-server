@extends('Admin.Layout.app')

@section('title', 'Brands')
@section('page_title', 'Brands')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<h1 class="wp-h1">Brands</h1>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h" id="formTitle">Add New Brand</div>
            <div class="wp-panel-body">
                <form id="brandForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="methodField" name="_method" value="POST">

                    <div class="wp-field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="wp-input" required>
                        <p class="wp-help">The name is how it appears on your site.</p>
                        <p id="nameError" class="wp-err" style="display:none"></p>
                    </div>

                    <div class="wp-field">
                        <label for="slug">Slug</label>
                        <input type="text" id="slug" name="slug" class="wp-input">
                        <p class="wp-help">URL-friendly version of the name. Leave empty to auto-generate.</p>
                    </div>

                    <div class="wp-field">
                        <label for="icon">Image</label>
                        <input type="file" id="icon" name="icon" accept="image/*" class="wp-input" onchange="previewBrandIcon(event)">
                        <p class="wp-help">Logo image shown in the homepage gallery. JPG, PNG, WEBP. Max 4 MB.</p>
                        <img id="brandIconPreview" src="" alt="" style="display:none; max-width:120px; height:auto; margin-top:8px; border-radius:4px; border:1px solid #dcdcde;">
                    </div>

                    <div class="flex items-center gap-2 mt-2">
                        <button type="submit" id="submitBtn" class="wp-btn wp-btn-primary">Add New Brand</button>
                        <button type="button" id="cancelEditBtn" class="wp-btn-link" style="display:none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-8">
        <div class="wp-search-box mb-2 justify-end">
            <input type="search" id="searchInput" class="wp-input" style="max-width: 240px;" placeholder="Search brands">
        </div>

        <table class="wp-list-table">
            <thead>
                <tr>
                    <th style="width: 80px;">Image</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th class="text-center" style="width: 100px;">Status</th>
                </tr>
            </thead>
            <tbody id="brandTbody">
                @forelse ($brands as $b)
                    <tr data-row-id="{{ $b->id }}">
                        <td>
                            @if ($b->icon)
                                <img src="{{ Storage::url($b->icon) }}" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:4px;border:1px solid #dcdcde;">
                            @endif
                        </td>
                        <td>
                            <strong><a href="javascript:void(0)" onclick="editBrand({{ $b->id }})" class="text-[#2271b1] hover:text-[#135e96]">{{ $b->name }}</a></strong>
                            <div class="wp-row-actions">
                                <span><button type="button" onclick="editBrand({{ $b->id }})">Edit</button> |</span>
                                <span><button type="button" class="trash" onclick="deleteBrand({{ $b->id }}, '{{ addslashes($b->name) }}')">Delete</button></span>
                            </div>
                        </td>
                        <td class="text-[#50575e]">{{ $b->slug }}</td>
                        <td class="text-center">
                            <span class="wp-status-pill {{ $b->status ? 'wp-status-on' : 'wp-status-off' }}"
                                  onclick="toggleStatus({{ $b->id }})">
                                {{ $b->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-[#787c82] py-6">No brands found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-[13px] text-[#50575e] mt-2">{{ count($brands) }} item{{ count($brands) === 1 ? '' : 's' }}</div>
    </div>
</div>

@endsection

@push('scripts')
@include('Admin._partials.wp-scripts')
<script>
    @php
        $brandsForJs = $brands->map(fn ($b) => [
            'id' => $b->id,
            'name' => $b->name,
            'slug' => $b->slug,
            'icon_url' => $b->icon ? Storage::url($b->icon) : null,
        ]);
    @endphp
    let allBrands = @json($brandsForJs);

    $(function () {
        $('#name').on('keyup', function () {
            if (!$('#slug').data('manual')) {
                $('#slug').val($(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, ''));
            }
        });
        $('#slug').on('input', function () { $(this).data('manual', !!$(this).val()); });

        $('#searchInput').on('input', function () {
            var q = $(this).val().toLowerCase();
            $('#brandTbody tr').each(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
            });
        });

        $('#brandForm').on('submit', function (e) {
            e.preventDefault();
            $('#nameError').hide();
            var isEdit = $('#methodField').val() === 'PUT';
            var id = $(this).data('edit-id');
            var url = isEdit ? '/admin/brands/' + id : '{{ route('admin.brands.store') }}';
            var formData = new FormData(this);
            if (isEdit) {
                formData.append('_method', 'PUT');
            }
            $.ajax({
                url: url,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function (res) {
                    wpToast(res.message, 'success');
                    setTimeout(function () { location.reload(); }, 400);
                },
                error: function (xhr) {
                    if (xhr.status === 422 && xhr.responseJSON.errors && xhr.responseJSON.errors.name) {
                        $('#nameError').text(xhr.responseJSON.errors.name[0]).show();
                    } else {
                        wpToast('Something went wrong.', 'error');
                    }
                }
            });
        });

        $('#cancelEditBtn').on('click', function () { resetForm(); });
    });

    function editBrand(id) {
        var b = allBrands.find(function (x) { return x.id === id; });
        if (!b) return;
        $('#name').val(b.name);
        $('#slug').val(b.slug).data('manual', true);
        $('#methodField').val('PUT');
        $('#brandForm').data('edit-id', id);
        $('#formTitle').text('Edit Brand');
        $('#submitBtn').text('Update Brand');
        $('#cancelEditBtn').show();
        if (b.icon_url) {
            $('#brandIconPreview').attr('src', b.icon_url).show();
        } else {
            $('#brandIconPreview').hide();
        }
        $('html, body').animate({ scrollTop: 0 }, 200);
    }

    function previewBrandIcon(e) {
        var file = e.target.files[0];
        if (!file) return;
        var img = document.getElementById('brandIconPreview');
        img.src = URL.createObjectURL(file);
        img.style.display = 'block';
    }

    function resetForm() {
        $('#brandForm')[0].reset();
        $('#slug').data('manual', false);
        $('#methodField').val('POST');
        $('#brandForm').removeData('edit-id');
        $('#formTitle').text('Add New Brand');
        $('#submitBtn').text('Add New Brand');
        $('#cancelEditBtn').hide();
        $('#nameError').hide();
        $('#brandIconPreview').hide().attr('src', '');
    }

    function toggleStatus(id) {
        $.ajax({
            url: '/admin/brands/' + id + '/toggle-status',
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                wpToast(res.message, 'success');
                setTimeout(function () { location.reload(); }, 300);
            },
            error: function () { wpToast('Failed to update.', 'error'); }
        });
    }

    function deleteBrand(id, name) {
        if (!confirm('Delete "' + name + '"?')) return;
        $.ajax({
            url: '/admin/brands/' + id,
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                wpToast(res.message, 'success');
                setTimeout(function () { location.reload(); }, 400);
            },
            error: function () { wpToast('Failed to delete.', 'error'); }
        });
    }
</script>
@endpush
