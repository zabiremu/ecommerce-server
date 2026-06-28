@extends('Admin.Layout.app')

@section('title', 'Units')
@section('page_title', 'Units')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<h1 class="wp-h1">Units</h1>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h" id="formTitle">Add New Unit</div>
            <div class="wp-panel-body">
                <form id="unitForm" method="POST">
                    @csrf
                    <input type="hidden" id="methodField" name="_method" value="POST">

                    <div class="wp-field">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="wp-input" required placeholder="e.g. Kilogram, Piece, Liter">
                        <p class="wp-help">Units used to measure products (e.g. kg, pc, ltr).</p>
                        <p id="nameError" class="wp-err" style="display:none"></p>
                    </div>

                    <div class="wp-field">
                        <label for="slug">Slug</label>
                        <input type="text" id="slug" name="slug" class="wp-input">
                        <p class="wp-help">URL-friendly version of the name. Leave empty to auto-generate.</p>
                    </div>

                    <div class="flex items-center gap-2 mt-2">
                        <button type="submit" id="submitBtn" class="wp-btn wp-btn-primary">Add New Unit</button>
                        <button type="button" id="cancelEditBtn" class="wp-btn-link" style="display:none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-8">
        <div class="wp-search-box mb-2 justify-end">
            <input type="search" id="searchInput" class="wp-input" style="max-width: 240px;" placeholder="Search units">
        </div>

        <table class="wp-list-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th class="text-center" style="width: 100px;">Status</th>
                </tr>
            </thead>
            <tbody id="unitTbody">
                @forelse ($units as $u)
                    <tr data-row-id="{{ $u->id }}">
                        <td>
                            <strong><a href="javascript:void(0)" onclick="editUnit({{ $u->id }})" class="text-[#2271b1] hover:text-[#135e96]">{{ $u->name }}</a></strong>
                            <div class="wp-row-actions">
                                <span><button type="button" onclick="editUnit({{ $u->id }})">Edit</button> |</span>
                                <span><button type="button" class="trash" onclick="deleteUnit({{ $u->id }}, '{{ addslashes($u->name) }}')">Delete</button></span>
                            </div>
                        </td>
                        <td class="text-[#50575e]">{{ $u->slug }}</td>
                        <td class="text-center">
                            <span class="wp-status-pill {{ $u->status ? 'wp-status-on' : 'wp-status-off' }}"
                                  onclick="toggleStatus({{ $u->id }})">
                                {{ $u->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center text-[#787c82] py-6">No units found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-[13px] text-[#50575e] mt-2">{{ count($units) }} item{{ count($units) === 1 ? '' : 's' }}</div>
    </div>
</div>

@endsection

@push('scripts')
@include('Admin._partials.wp-scripts')
<script>
    let allUnits = @json($units);

    $(function () {
        $('#name').on('keyup', function () {
            if (!$('#slug').data('manual')) {
                $('#slug').val($(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, ''));
            }
        });
        $('#slug').on('input', function () { $(this).data('manual', !!$(this).val()); });

        $('#searchInput').on('input', function () {
            var q = $(this).val().toLowerCase();
            $('#unitTbody tr').each(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
            });
        });

        $('#unitForm').on('submit', function (e) {
            e.preventDefault();
            $('#nameError').hide();
            var isEdit = $('#methodField').val() === 'PUT';
            var id = $(this).data('edit-id');
            var url = isEdit ? '/admin/units/' + id : '{{ route('admin.units.store') }}';
            $.ajax({
                url: url,
                method: isEdit ? 'PUT' : 'POST',
                data: $(this).serialize(),
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

    function editUnit(id) {
        var u = allUnits.find(function (x) { return x.id === id; });
        if (!u) return;
        $('#name').val(u.name);
        $('#slug').val(u.slug).data('manual', true);
        $('#methodField').val('PUT');
        $('#unitForm').data('edit-id', id);
        $('#formTitle').text('Edit Unit');
        $('#submitBtn').text('Update Unit');
        $('#cancelEditBtn').show();
        $('html, body').animate({ scrollTop: 0 }, 200);
    }

    function resetForm() {
        $('#unitForm')[0].reset();
        $('#slug').data('manual', false);
        $('#methodField').val('POST');
        $('#unitForm').removeData('edit-id');
        $('#formTitle').text('Add New Unit');
        $('#submitBtn').text('Add New Unit');
        $('#cancelEditBtn').hide();
        $('#nameError').hide();
    }

    function toggleStatus(id) {
        $.ajax({
            url: '/admin/units/' + id + '/toggle-status',
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                wpToast(res.message, 'success');
                setTimeout(function () { location.reload(); }, 300);
            },
            error: function () { wpToast('Failed to update.', 'error'); }
        });
    }

    function deleteUnit(id, name) {
        if (!confirm('Delete "' + name + '"?')) return;
        $.ajax({
            url: '/admin/units/' + id,
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
