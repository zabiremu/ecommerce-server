@extends('Admin.Layout.app')

@section('title', $labels['plural'])
@section('page_title', $labels['plural'])

@push('styles')
@include('Admin.accounts._styles')
@endpush

@php($money = fn ($v) => \App\Support\Money::format($v))
@php($_a = Auth::guard('admin')->user())
@php($r = $labels['route'])
@php($canCreate = $_a->hasPermission($r . '.create'))
@php($canEdit = $_a->hasPermission($r . '.edit'))
@php($canDelete = $_a->hasPermission($r . '.delete'))

@section('content')

<h1 class="wp-h1">Accounts &amp; Reports</h1>
@include('Admin.accounts._tabs')

<div class="grid grid-cols-12 gap-5">
    @if($canCreate || $canEdit)
    <div class="col-span-12 lg:col-span-4">
        <div class="wp-panel">
            <div class="wp-panel-h" id="formTitle">Add {{ $labels['singular'] }}</div>
            <div class="wp-panel-body">
                <form id="ledgerForm">
                    <div class="wp-field">
                        <label for="f_category">Category</label>
                        <div class="flex gap-2">
                            <select id="f_category" name="account_category_id" class="wp-input">
                                <option value="">— Select —</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                            @if($canCreate)
                            <button type="button" class="wp-btn" id="addCatBtn" title="New category"><i class="fas fa-plus"></i></button>
                            @endif
                        </div>
                    </div>
                    <div class="wp-field">
                        <label for="f_title">Title <span class="text-red-600">*</span></label>
                        <input type="text" id="f_title" name="title" class="wp-input" required
                               placeholder="{{ $r === 'expenses' ? 'e.g. October shop rent' : 'e.g. New display rack' }}">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="wp-field">
                            <label for="f_amount">Amount (৳) <span class="text-red-600">*</span></label>
                            <input type="number" step="0.01" min="0.01" id="f_amount" name="amount" class="wp-input" required>
                        </div>
                        <div class="wp-field">
                            <label for="f_date">Date <span class="text-red-600">*</span></label>
                            <input type="date" id="f_date" name="date" class="wp-input" value="{{ today()->toDateString() }}" max="{{ today()->toDateString() }}" required>
                        </div>
                    </div>
                    <div class="wp-field">
                        <label for="f_method">Paid via</label>
                        <select id="f_method" name="payment_method" class="wp-input">
                            @foreach($methods as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="wp-field">
                        <label for="f_note">Note</label>
                        <textarea id="f_note" name="note" rows="2" class="wp-input"></textarea>
                    </div>
                    <p id="formError" class="wp-err" style="display:none"></p>
                    <div class="flex items-center gap-2 mt-2">
                        <button type="submit" id="submitBtn" class="wp-btn wp-btn-primary">Add {{ $labels['singular'] }}</button>
                        <button type="button" id="cancelEditBtn" class="wp-btn-link" style="display:none">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <div class="col-span-12 {{ ($canCreate || $canEdit) ? 'lg:col-span-8' : '' }}">
        <form method="GET" class="report-filters">
            @if($byMonth)
            <label><i class="fas fa-calendar text-[#787c82]"></i> Month:
                <input type="month" name="month" value="{{ $month->format('Y-m') }}" max="{{ now()->format('Y-m') }}">
            </label>
            @endif
            <label>Category:
                <select name="category">
                    <option value="">All</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ $categoryId == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </label>
            <button type="submit" class="wp-btn wp-btn-primary">Filter</button>
            <a href="{{ route('admin.' . $r . '.index') }}" class="wp-btn">Reset</a>
        </form>

        <div class="stat-cards">
            <div class="stat-card hl">
                <div class="label">{{ $byMonth ? $month->format('F Y') : 'Listed total' }}</div>
                <div class="value">{{ $money($monthTotal) }}</div>
                <div class="sub">{{ $items->count() }} entr{{ $items->count() === 1 ? 'y' : 'ies' }}</div>
            </div>
            <div class="stat-card">
                <div class="label">All-time {{ strtolower($labels['plural']) }}</div>
                <div class="value">{{ $money($allTime) }}</div>
            </div>
        </div>

        <div class="table-scroll">
        <table class="wp-list-table">
            <thead>
                <tr><th style="width:110px">Date</th><th>Title</th><th>Category</th><th>Paid via</th><th class="num">Amount</th></tr>
            </thead>
            <tbody>
            @forelse($items as $i)
                <tr>
                    <td class="text-[#50575e]">{{ $i->{$dateColumn}->format('d M Y') }}</td>
                    <td>
                        <strong>{{ $i->title }}</strong>
                        @if($i->note)<div class="text-[11px] text-[#787c82]">{{ $i->note }}</div>@endif
                        <div class="wp-row-actions">
                            @if($canEdit)<span><button type="button" onclick="editEntry({{ $i->id }})">Edit</button>@if($canDelete) |@endif</span>@endif
                            @if($canDelete)<span><button type="button" class="trash" onclick="deleteEntry({{ $i->id }})">Delete</button></span>@endif
                        </div>
                    </td>
                    <td class="text-[#50575e]">{{ $i->category?->name ?? '—' }}</td>
                    <td class="text-[#50575e]">{{ $methods[$i->payment_method] ?? ucfirst($i->payment_method) }}</td>
                    <td class="num">{{ $money($i->amount) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="text-center text-[#787c82] py-6">No {{ strtolower($labels['plural']) }} found.</td></tr>
            @endforelse
            </tbody>
            @if($items->isNotEmpty())
            <tfoot><tr><td colspan="4">Total</td><td class="num">{{ $money($monthTotal) }}</td></tr></tfoot>
            @endif
        </table>
        </div>
    </div>
</div>

@endsection


@push('scripts')
@include('Admin._partials.wp-scripts')
<script>
    var entries  = @json($entriesJson);
    var baseUrl  = '{{ url('admin/' . $r) }}';
    var singular = @json($labels['singular']);
    var csrf     = '{{ csrf_token() }}';
    var editId   = null;

    $(function () {
        $('#ledgerForm').on('submit', function (e) {
            e.preventDefault();
            $('#formError').hide();
            $.ajax({
                url: editId ? baseUrl + '/' + editId : baseUrl,
                method: editId ? 'PUT' : 'POST',
                data: $(this).serialize(),
                headers: { 'X-CSRF-TOKEN': csrf },
                success: function (res) { wpToast(res.message, 'success'); setTimeout(function () { location.reload(); }, 400); },
                error: function (xhr) {
                    var errs = xhr.responseJSON && xhr.responseJSON.errors;
                    $('#formError').text(errs ? Object.values(errs)[0][0] : 'Something went wrong.').show();
                }
            });
        });

        $('#cancelEditBtn').on('click', resetForm);

        $('#addCatBtn').on('click', function () {
            var name = prompt('New category name');
            if (!name || !name.trim()) return;
            $.ajax({
                url: baseUrl + '/categories', method: 'POST', data: { name: name.trim() },
                headers: { 'X-CSRF-TOKEN': csrf },
                success: function (res) {
                    $('#f_category').append(new Option(res.category.name, res.category.id, true, true));
                    wpToast(res.message, 'success');
                },
                error: function (xhr) {
                    var errs = xhr.responseJSON && xhr.responseJSON.errors;
                    wpToast(errs ? Object.values(errs)[0][0] : 'Could not add category.', 'error');
                }
            });
        });
    });

    function editEntry(id) {
        var e = entries.find(function (x) { return x.id === id; });
        if (!e) return;
        editId = id;
        $('#f_category').val(e.account_category_id || '');
        $('#f_title').val(e.title);
        $('#f_amount').val(e.amount);
        $('#f_date').val(e.date);
        $('#f_method').val(e.payment_method);
        $('#f_note').val(e.note || '');
        $('#formTitle').text('Edit ' + singular);
        $('#submitBtn').text('Update ' + singular);
        $('#cancelEditBtn').show();
        $('html, body').animate({ scrollTop: 0 }, 200);
    }

    function resetForm() {
        editId = null;
        $('#ledgerForm')[0].reset();
        $('#formTitle').text('Add ' + singular);
        $('#submitBtn').text('Add ' + singular);
        $('#cancelEditBtn').hide();
        $('#formError').hide();
    }

    function deleteEntry(id) {
        var e = entries.find(function (x) { return x.id === id; });
        if (!confirm('Delete "' + (e ? e.title : singular) + '"?')) return;
        $.ajax({
            url: baseUrl + '/' + id, method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': csrf },
            success: function (res) { wpToast(res.message, 'success'); setTimeout(function () { location.reload(); }, 400); },
            error: function () { wpToast('Failed to delete.', 'error'); }
        });
    }
</script>
@endpush
