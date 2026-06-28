@extends('Admin.Layout.app')

@section('title', 'Customer · ' . $customer->name)
@section('page_title', 'Customer · ' . $customer->name)

@push('styles')
@include('Admin._partials.wp-styles')
<style>
    .avatar-lg { width:64px; height:64px; border-radius:50%; background:linear-gradient(135deg,#6366f1,#a855f7); color:#fff; display:inline-flex; align-items:center; justify-content:center; font-weight:700; font-size:24px; }
    .stat-card { background:#fff; border:1px solid #c3c4c7; padding:16px; border-radius:4px; }
    .stat-card .lbl { font-size:12px; color:#50575e; text-transform:uppercase; letter-spacing:.04em; font-weight:600; }
    .stat-card .val { font-size:24px; color:#1d2327; font-weight:700; margin-top:4px; }
    .order-pill { display:inline-block; padding:2px 10px; font-size:11px; font-weight:600; border-radius:10px; text-transform:capitalize; }
    .info-grid { display: grid; grid-template-columns: 110px 1fr; gap: 8px 12px; font-size: 13px; }
    .info-grid .lbl { color: #50575e; }
    .info-grid .val { color: #1d2327; font-weight: 500; }
</style>
@endpush

@section('content')

@if (session('success'))
    <div class="mb-4 px-4 py-3 bg-green-50 border-l-4 border-green-500 text-green-700 text-[13px]">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="mb-4 px-4 py-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-[13px]">{{ session('error') }}</div>
@endif

<div class="flex items-center gap-3 mb-3 flex-wrap">
    <h1 class="wp-h1">Customer Profile</h1>
    <a href="{{ route('admin.customers.index') }}" class="wp-add-new ml-auto">← Back to customers</a>
</div>

<!-- Profile Header -->
<div class="wp-panel mb-4">
    <div class="wp-panel-body">
        <div class="flex items-center gap-4 flex-wrap">
            <div class="avatar-lg">{{ strtoupper(substr($customer->name, 0, 1)) }}</div>
            <div class="flex-1 min-w-0">
                <h2 class="text-[20px] font-bold text-[#1d2327] m-0 mb-1">{{ $customer->name }}</h2>
                <div class="text-[13px] text-[#50575e]">
                    📞 {{ $customer->phone }}
                    @if ($customer->email)
                        · ✉️ {{ $customer->email }}
                    @endif
                </div>
                <div class="text-[12px] text-[#646970] mt-1">
                    Customer since {{ $customer->created_at->format('d M, Y') }}
                    @if ($customer->last_order_at)
                        · Last order {{ $customer->last_order_at->diffForHumans() }}
                    @endif
                </div>
            </div>
            <div>
                <span class="wp-status-pill {{ $customer->status ? 'wp-status-on' : 'wp-status-off' }}">{{ $customer->status ? 'Active' : 'Inactive' }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
    <div class="stat-card">
        <div class="lbl">Total Orders</div>
        <div class="val">{{ $customer->total_orders }}</div>
    </div>
    <div class="stat-card">
        <div class="lbl">Total Spent</div>
        <div class="val text-emerald-700">৳ {{ number_format($customer->total_spent, 2) }}</div>
    </div>
    <div class="stat-card">
        <div class="lbl">Avg Order Value</div>
        <div class="val text-blue-700">৳ {{ $customer->total_orders > 0 ? number_format($customer->total_spent / $customer->total_orders, 2) : '0.00' }}</div>
    </div>
    <div class="stat-card">
        <div class="lbl">Total Items Bought</div>
        <div class="val text-purple-700">{{ rtrim(rtrim(number_format((float) $customer->orders->flatMap->items->sum('quantity'), 2, '.', ''), '0'), '.') }}</div>
    </div>
</div>

<div class="grid grid-cols-12 gap-5">
    <div class="col-span-12 lg:col-span-8">
        <!-- Orders -->
        <div class="wp-panel">
            <div class="wp-panel-h">Recent Orders ({{ $customer->orders->count() }})</div>
            <div class="wp-panel-body" style="padding:0">
                @if ($customer->orders->isEmpty())
                    <div class="p-6 text-center text-[#646970]">This customer has not placed any orders yet.</div>
                @else
                    <table class="wp-list-table" style="border:0;box-shadow:none">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Date</th>
                                <th class="text-center" style="width:120px">Status</th>
                                <th class="text-center" style="width:110px">Payment</th>
                                <th class="text-right" style="width:110px">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customer->orders as $o)
                                @php
                                    $sMap = [
                                        'pending' => ['#fff4e5', '#d97706'],
                                        'confirmed' => ['#dbeafe', '#1d4ed8'],
                                        'processing' => ['#e0e7ff', '#3730a3'],
                                        'shipped' => ['#cffafe', '#0e7490'],
                                        'delivered' => ['#d1fae5', '#047857'],
                                        'cancelled' => ['#fee2e2', '#b91c1c'],
                                        'returned' => ['#e5e7eb', '#374151'],
                                    ];
                                    [$bg, $fg] = $sMap[$o->status] ?? ['#f3f4f6', '#374151'];
                                @endphp
                                <tr>
                                    <td>
                                        <strong><a href="{{ route('admin.orders.show', $o) }}" class="text-[#2271b1] font-mono text-[12.5px]">#{{ $o->order_no }}</a></strong>
                                    </td>
                                    <td class="text-[#50575e]">{{ ($o->placed_at ?? $o->created_at)->format('d M, Y') }}</td>
                                    <td class="text-center">
                                        <span class="order-pill" style="background:{{ $bg }};color:{{ $fg }}">{{ $o->status }}</span>
                                    </td>
                                    <td class="text-center text-[12px] uppercase">{{ $o->payment_method }} <span class="text-[#646970]">({{ $o->payment_status }})</span></td>
                                    <td class="text-right"><strong>৳ {{ number_format($o->total, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <div class="col-span-12 lg:col-span-4 space-y-5">
        <!-- Edit profile -->
        <div class="wp-panel">
            <div class="wp-panel-h">Edit Details</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.customers.update', $customer) }}">
                    @csrf @method('PUT')
                    <div class="wp-field">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="wp-input" required>
                    </div>
                    <div class="wp-field">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="wp-input" required>
                    </div>
                    <div class="wp-field">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="wp-input">
                    </div>
                    <div class="wp-field">
                        <label>Address</label>
                        <textarea name="address" rows="2" class="wp-input">{{ old('address', $customer->address) }}</textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="wp-field">
                            <label>City</label>
                            <input type="text" name="city" value="{{ old('city', $customer->city) }}" class="wp-input">
                        </div>
                        <div class="wp-field">
                            <label>Area</label>
                            <input type="text" name="area" value="{{ old('area', $customer->area) }}" class="wp-input">
                        </div>
                    </div>
                    <div class="wp-field">
                        <label>Notes</label>
                        <textarea name="notes" rows="2" class="wp-input" placeholder="Internal notes...">{{ old('notes', $customer->notes) }}</textarea>
                    </div>
                    <button type="submit" class="wp-btn wp-btn-primary" style="width:100%">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Status toggle -->
        <div class="wp-panel">
            <div class="wp-panel-h">Status</div>
            <div class="wp-panel-body">
                <form method="POST" action="{{ route('admin.customers.toggle-status', $customer) }}">
                    @csrf @method('PATCH')
                    <button type="submit" class="wp-btn" style="width:100%">
                        {{ $customer->status ? 'Disable Customer' : 'Enable Customer' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
