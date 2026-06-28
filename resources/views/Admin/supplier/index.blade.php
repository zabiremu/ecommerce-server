@extends('Admin.Layout.app')

@section('title', 'Suppliers')
@section('page_title', 'Suppliers')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<h1 class="wp-h1">Suppliers</h1>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h" id="formTitle">Add New Supplier</div>
            <div class="wp-panel-body">
                <form id="supplierForm" method="POST">
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
                        <label for="company">Company</label>
                        <input type="text" id="company" name="company" class="wp-input">
                    </div>

                    <div class="wp-field">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="wp-input" placeholder="supplier@example.com">
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
                        <button type="submit" id="submitBtn" class="wp-btn wp-btn-primary">Add New Supplier</button>
                        <button type="button" id="cancelEditBtn" class="wp-btn-link" style="display:none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-8">
        <div class="wp-search-box mb-2 justify-end">
            <input type="search" id="searchInput" class="wp-input" style="max-width: 240px;" placeholder="Search suppliers">
        </div>

        <table class="wp-list-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th class="text-center" style="width: 100px;">Status</th>
                </tr>
            </thead>
            <tbody id="supplierTbody">
                @forelse ($suppliers as $s)
                    <tr data-row-id="{{ $s->id }}">
                        <td>
                            <strong><a href="javascript:void(0)" onclick="editSupplier({{ $s->id }})" class="text-[#2271b1] hover:text-[#135e96]">{{ $s->name }}</a></strong>
                            <div class="text-[12px] text-[#646970]">{{ $s->slug }}</div>
                            <div class="wp-row-actions">
                                <span><button type="button" onclick="editSupplier({{ $s->id }})">Edit</button> |</span>
                                <span><button type="button" class="trash" onclick="deleteSupplier({{ $s->id }}, '{{ addslashes($s->name) }}')">Delete</button></span>
                            </div>
                        </td>
                        <td class="text-[#50575e]">{{ $s->company ?: '—' }}</td>
                        <td class="text-[#50575e]">{{ $s->email ?: '—' }}</td>
                        <td class="text-[#50575e]">{{ $s->phone ?: '—' }}</td>
                        <td class="text-center">
                            <span class="wp-status-pill {{ $s->status ? 'wp-status-on' : 'wp-status-off' }}"
                                  onclick="toggleStatus({{ $s->id }})">
                                {{ $s->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-[#787c82] py-6">No suppliers found.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-[13px] text-[#50575e] mt-2">{{ count($suppliers) }} item{{ count($suppliers) === 1 ? '' : 's' }}</div>
    </div>
</div>

@endsection

@push('scripts')
@include('Admin._partials.wp-scripts')
<script>
    let allSuppliers = @json($suppliers);

    $(function () {
        $('#name').on('keyup', function () {
            if (!$('#slug').data('manual')) {
                $('#slug').val($(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, ''));
            }
        });
        $('#slug').on('input', function () { $(this).data('manual', !!$(this).val()); });

        $('#searchInput').on('input', function () {
            var q = $(this).val().toLowerCase();
            $('#supplierTbody tr').each(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(q) > -1);
            });
        });

        $('#supplierForm').on('submit', function (e) {
            e.preventDefault();
            $('#nameError').hide();
            var isEdit = $('#methodField').val() === 'PUT';
            var id = $(this).data('edit-id');
            var url = isEdit ? '/admin/suppliers/' + id : '{{ route('admin.suppliers.store') }}';
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

    function editSupplier(id) {
        var s = allSuppliers.find(function (x) { return x.id === id; });
        if (!s) return;
        $('#name').val(s.name);
        $('#slug').val(s.slug).data('manual', true);
        $('#company').val(s.company || '');
        $('#email').val(s.email || '');
        $('#phone').val(s.phone || '');
        $('#address').val(s.address || '');
        $('#methodField').val('PUT');
        $('#supplierForm').data('edit-id', id);
        $('#formTitle').text('Edit Supplier');
        $('#submitBtn').text('Update Supplier');
        $('#cancelEditBtn').show();
        $('html, body').animate({ scrollTop: 0 }, 200);
    }

    function resetForm() {
        $('#supplierForm')[0].reset();
        $('#slug').data('manual', false);
        $('#methodField').val('POST');
        $('#supplierForm').removeData('edit-id');
        $('#formTitle').text('Add New Supplier');
        $('#submitBtn').text('Add New Supplier');
        $('#cancelEditBtn').hide();
        $('#nameError').hide();
    }

    function toggleStatus(id) {
        $.ajax({
            url: '/admin/suppliers/' + id + '/toggle-status',
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                wpToast(res.message, 'success');
                setTimeout(function () { location.reload(); }, 300);
            },
            error: function () { wpToast('Failed to update.', 'error'); }
        });
    }

    function deleteSupplier(id, name) {
        if (!confirm('Delete "' + name + '"?')) return;
        $.ajax({
            url: '/admin/suppliers/' + id,
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
