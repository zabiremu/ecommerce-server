@extends('Admin.Layout.app')

@section('title', 'Warehouses')
@section('page_title', 'Warehouses')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<h1 class="wp-h1">Warehouses</h1>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h" id="formTitle">Add New Warehouse</div>
            <div class="wp-panel-body">
                <form id="warehouseForm" method="POST">
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
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="wp-input" placeholder="warehouse@example.com">
                    </div>

                    <div class="wp-field">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" class="wp-input" placeholder="+8801XXXXXXXXX">
                    </div>

                    <div class="wp-field">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" rows="3" class="wp-input"></textarea>
                    </div>

                    <div class="flex items-center gap-2 mt-2">
                        <button type="submit" id="submitBtn" class="wp-btn wp-btn-primary">Add New Warehouse</button>
                        <button type="button" id="cancelEditBtn" class="wp-btn-link" style="display:none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-8">
        <div class="wp-search-box mb-2 justify-end">
            <input type="search" id="searchInput" class="wp-input" style="max-width: 240px;" placeholder="Search warehouses">
        </div>

        <table class="wp-list-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th class="text-center" style="width: 100px;">Status</th>
                </tr>
            </thead>
            <tbody id="warehouseTbody">
                @forelse ($warehouses as $w)
                    <tr data-row-id="{{ $w->id }}">
                        <td>
                            <strong><a href="javascript:void(0)" onclick="editWarehouse({{ $w->id }})" class="text-[#2271b1] hover:text-[#135e96]">{{ $w->name }}</a></strong>
                            <div class="text-[12px] text-[#646970]">{{ $w->slug }}</div>
                            <div class="wp-row-actions">
                                <span><button type="button" onclick="editWarehouse({{ $w->id }})">Edit</button> |</span>
                                <span><button type="button" class="trash" onclick="deleteWarehouse({{ $w->id }}, '{{ addslashes($w->name) }}')">Delete</button></span>
                            </div>
                        </td>
                        <td class="text-[#50575e]">{{ $w->email ?: '—' }}</td>
                        <td class="text-[#50575e]">{{ $w->phone ?: '—' }}</td>
                        <td class="text-[#50575e]">{{ \Illuminate\Support\Str::limit($w->address ?? '—', 40) }}</td>
                        <td class="text-center">
                            <span class="wp-status-pill {{ $w->status ? 'wp-status-on' : 'wp-status-off' }}"
                                  onclick="toggleStatus({{ $w->id }})">
                                {{ $w->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-[#787c82] py-6">No warehouses found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-[13px] text-[#50575e] mt-2">{{ count($warehouses) }} item{{ count($warehouses) === 1 ? '' : 's' }}</div>
    </div>
</div>

@endsection

@push('scripts')
@include('Admin._partials.wp-scripts')
<script>
    let allWarehouses = @json($warehouses);

    $(function () {
        $('#name').on('keyup', function () {
            if (!$('#slug').data('manual')) {
                $('#slug').val($(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, ''));
            }
        });
        $('#slug').on('input', function () { $(this).data('manual', !!$(this).val()); });

        $('#searchInput').on('input', function () {
            var q = $(this).val().toLowerCase();
            $('#warehouseTbody tr').each(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
            });
        });

        $('#warehouseForm').on('submit', function (e) {
            e.preventDefault();
            $('#nameError').hide();
            var isEdit = $('#methodField').val() === 'PUT';
            var id = $(this).data('edit-id');
            var url = isEdit ? '/admin/warehouses/' + id : '{{ route('admin.warehouses.store') }}';
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

    function editWarehouse(id) {
        var w = allWarehouses.find(function (x) { return x.id === id; });
        if (!w) return;
        $('#name').val(w.name);
        $('#slug').val(w.slug).data('manual', true);
        $('#email').val(w.email || '');
        $('#phone').val(w.phone || '');
        $('#address').val(w.address || '');
        $('#methodField').val('PUT');
        $('#warehouseForm').data('edit-id', id);
        $('#formTitle').text('Edit Warehouse');
        $('#submitBtn').text('Update Warehouse');
        $('#cancelEditBtn').show();
        $('html, body').animate({ scrollTop: 0 }, 200);
    }

    function resetForm() {
        $('#warehouseForm')[0].reset();
        $('#slug').data('manual', false);
        $('#methodField').val('POST');
        $('#warehouseForm').removeData('edit-id');
        $('#formTitle').text('Add New Warehouse');
        $('#submitBtn').text('Add New Warehouse');
        $('#cancelEditBtn').hide();
        $('#nameError').hide();
    }

    function toggleStatus(id) {
        $.ajax({
            url: '/admin/warehouses/' + id + '/toggle-status',
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                wpToast(res.message, 'success');
                setTimeout(function () { location.reload(); }, 300);
            },
            error: function () { wpToast('Failed to update.', 'error'); }
        });
    }

    function deleteWarehouse(id, name) {
        if (!confirm('Delete "' + name + '"?')) return;
        $.ajax({
            url: '/admin/warehouses/' + id,
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
