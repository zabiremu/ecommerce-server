@extends('Admin.Layout.app')

@section('title', 'Trust Bar')
@section('page_title', 'Trust Bar')

@push('styles')
@include('Admin._partials.wp-styles')
@endpush

@section('content')

<h1 class="wp-h1">Trust Bar Items</h1>

<div class="grid grid-cols-12 gap-5 mt-3">
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h" id="formTitle">Add New Trust Item</div>
            <div class="wp-panel-body">
                <form id="trustItemForm" method="POST">
                    @csrf
                    <input type="hidden" id="methodField" name="_method" value="POST">

                    <div class="wp-field">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="wp-input" required maxlength="255">
                        <p class="wp-help">Heading shown on the trust bar (e.g. পরামর্শ, অভিযোগ).</p>
                        <p id="titleError" class="wp-err" style="display:none"></p>
                    </div>

                    <div class="wp-field">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" class="wp-input" maxlength="500">
                        <p class="wp-help">Short helper text below the title.</p>
                    </div>

                    <div class="wp-field">
                        <label>Icon</label>
                        @include('Admin._partials.icon-picker', ['name' => 'icon', 'id' => 'trustIcon', 'value' => ''])
                    </div>

                    <div class="wp-field">
                        <label for="sort_order">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" class="wp-input" min="0" value="0">
                        <p class="wp-help">Lower values appear first.</p>
                    </div>

                    <div class="flex items-center gap-2 mt-2">
                        <button type="submit" id="submitBtn" class="wp-btn wp-btn-primary">Add New Item</button>
                        <button type="button" id="cancelEditBtn" class="wp-btn-link" style="display:none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-8">
        <table class="wp-list-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Icon</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th class="text-center" style="width: 80px;">Order</th>
                    <th class="text-center" style="width: 100px;">Status</th>
                </tr>
            </thead>
            <tbody id="itemTbody">
                @forelse ($items as $it)
                    <tr data-row-id="{{ $it->id }}">
                        <td class="text-center">
                            @if ($it->icon)
                                @php $ic = str_contains($it->icon, ' ') ? $it->icon : 'fas ' . $it->icon; @endphp
                                <i class="{{ $ic }} text-[#50575e]"></i>
                            @endif
                        </td>
                        <td>
                            <strong><a href="javascript:void(0)" onclick="editItem({{ $it->id }})" class="text-[#2271b1] hover:text-[#135e96]">{{ $it->title }}</a></strong>
                            <div class="wp-row-actions">
                                <span><button type="button" onclick="editItem({{ $it->id }})">Edit</button> |</span>
                                <span><button type="button" class="trash" onclick="deleteItem({{ $it->id }}, '{{ addslashes($it->title) }}')">Delete</button></span>
                            </div>
                        </td>
                        <td class="text-[#50575e]">{{ $it->description }}</td>
                        <td class="text-center">{{ $it->sort_order }}</td>
                        <td class="text-center">
                            <span class="wp-status-pill {{ $it->status ? 'wp-status-on' : 'wp-status-off' }}"
                                  onclick="toggleStatus({{ $it->id }})">
                                {{ $it->status ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-[#787c82] py-6">No trust items yet.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="text-[13px] text-[#50575e] mt-2">{{ count($items) }} item{{ count($items) === 1 ? '' : 's' }}</div>
    </div>
</div>

@endsection

@push('scripts')
@include('Admin._partials.wp-scripts')
<script>
    let allItems = @json($items);

    $(function () {
        $('#trustItemForm').on('submit', function (e) {
            e.preventDefault();
            $('#titleError').hide();
            var isEdit = $('#methodField').val() === 'PUT';
            var id = $(this).data('edit-id');
            var url = isEdit ? '/admin/trust-items/' + id : '{{ route('admin.trust-items.store') }}';
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
                    if (xhr.status === 422 && xhr.responseJSON.errors && xhr.responseJSON.errors.title) {
                        $('#titleError').text(xhr.responseJSON.errors.title[0]).show();
                    } else {
                        wpToast('Something went wrong.', 'error');
                    }
                }
            });
        });

        $('#cancelEditBtn').on('click', function () { resetForm(); });
    });

    function editItem(id) {
        var it = allItems.find(function (x) { return x.id === id; });
        if (!it) return;
        $('#title').val(it.title);
        $('#description').val(it.description || '');
        ipSetValue('trustIcon', it.icon || '');
        $('#sort_order').val(it.sort_order || 0);
        $('#methodField').val('PUT');
        $('#trustItemForm').data('edit-id', id);
        $('#formTitle').text('Edit Trust Item');
        $('#submitBtn').text('Update Item');
        $('#cancelEditBtn').show();
        $('html, body').animate({ scrollTop: 0 }, 200);
    }

    function resetForm() {
        $('#trustItemForm')[0].reset();
        $('#methodField').val('POST');
        $('#trustItemForm').removeData('edit-id');
        $('#formTitle').text('Add New Trust Item');
        $('#submitBtn').text('Add New Item');
        $('#cancelEditBtn').hide();
        $('#titleError').hide();
        ipSetValue('trustIcon', '');
    }

    function toggleStatus(id) {
        $.ajax({
            url: '/admin/trust-items/' + id + '/toggle-status',
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                wpToast(res.message, 'success');
                setTimeout(function () { location.reload(); }, 300);
            },
            error: function () { wpToast('Failed to update.', 'error'); }
        });
    }

    function deleteItem(id, title) {
        if (!confirm('Delete "' + title + '"?')) return;
        $.ajax({
            url: '/admin/trust-items/' + id,
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
