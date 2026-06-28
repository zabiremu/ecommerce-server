@extends('Admin.Layout.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')

@php
    $adminUser = Auth::guard('admin')->user();

    $statusStyles = [
        'pending'    => 'bg-amber-50 text-amber-700 ring-amber-200',
        'confirmed'  => 'bg-blue-50 text-blue-700 ring-blue-200',
        'processing' => 'bg-indigo-50 text-indigo-700 ring-indigo-200',
        'shipped'    => 'bg-cyan-50 text-cyan-700 ring-cyan-200',
        'delivered'  => 'bg-emerald-50 text-emerald-700 ring-emerald-200',
        'cancelled'  => 'bg-red-50 text-red-700 ring-red-200',
        'returned'   => 'bg-gray-100 text-gray-700 ring-gray-200',
    ];
@endphp

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-3 mb-5">
    <div>
        <h2 class="text-[20px] font-bold text-slate-900 tracking-tight">
            Welcome back, {{ explode(' ', $adminUser->name ?? 'Admin')[0] }}
        </h2>
        <p class="text-[13px] text-slate-500 mt-0.5">
            {{ now()->format('l, F j, Y') }}
            @if ($pendingOrders > 0)
                · <span class="text-amber-600 font-semibold">{{ $pendingOrders }} pending order{{ $pendingOrders > 1 ? 's' : '' }}</span>
            @endif
            @if ($outOfStockCount > 0)
                · <span class="text-red-600 font-semibold">{{ $outOfStockCount }} out of stock</span>
            @endif
        </p>
    </div>

    <div class="flex items-center gap-2">
        <a href="{{ route('admin.orders.index') }}"
           class="flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 hover:border-slate-300 text-slate-700 rounded-md text-[12.5px] font-medium transition shadow-sm">
            <i class="fas fa-cart-shopping text-[11px]"></i>
            <span>Orders</span>
        </a>
        <a href="{{ route('admin.products.create') }}"
           class="flex items-center gap-1.5 px-3 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-md text-[12.5px] font-semibold transition">
            <i class="fas fa-plus text-[11px]"></i>
            <span>New Product</span>
        </a>
    </div>
</div>

<!-- Stat cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4 mb-5">

    {{-- Revenue --}}
    <div class="bg-white rounded-lg p-4 border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Revenue (this month)</span>
            @if ($revenuePct !== null)
                <span class="inline-flex items-center gap-1 text-[10.5px] font-semibold {{ $revenuePct >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    <i class="fas {{ $revenuePct >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[8px]"></i>
                    {{ abs($revenuePct) }}%
                </span>
            @endif
        </div>
        <p class="text-[22px] font-bold text-slate-900 tracking-tight">৳ {{ number_format($revenueThisMonth) }}</p>
        <p class="text-[11.5px] text-slate-400 mt-1">
            Last month: ৳ {{ number_format($revenueLastMonth) }}
        </p>
        <div class="mt-3 h-1 rounded-full bg-slate-100 overflow-hidden">
            @php $revBar = $revenueLastMonth > 0 ? min(100, (int)(($revenueThisMonth/$revenueLastMonth)*100)) : ($revenueThisMonth > 0 ? 100 : 0); @endphp
            <div class="h-full bg-gradient-to-r from-brand-500 to-brand-300" style="width:{{ $revBar }}%"></div>
        </div>
    </div>

    {{-- Orders --}}
    <a href="{{ route('admin.orders.index') }}" class="block bg-white rounded-lg p-4 border border-slate-200 shadow-sm hover:border-amber-300 transition">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Orders</span>
            @if ($ordersPct !== null)
                <span class="inline-flex items-center gap-1 text-[10.5px] font-semibold {{ $ordersPct >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    <i class="fas {{ $ordersPct >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[8px]"></i>
                    {{ abs($ordersPct) }}%
                </span>
            @endif
        </div>
        <p class="text-[22px] font-bold text-slate-900 tracking-tight">{{ number_format($totalOrders) }}</p>
        <p class="text-[11.5px] text-slate-400 mt-1">
            @if ($pendingOrders > 0)
                <span class="text-amber-600 font-semibold">{{ $pendingOrders }} pending</span>
            @else
                {{ $ordersThisMonth }} this month
            @endif
        </p>
        <div class="mt-3 h-1 rounded-full bg-slate-100 overflow-hidden">
            @php $ordBar = $ordersLastMonth > 0 ? min(100, (int)(($ordersThisMonth / max($ordersLastMonth,1))*100)) : ($ordersThisMonth > 0 ? 100 : 0); @endphp
            <div class="h-full bg-gradient-to-r from-amber-400 to-amber-300" style="width:{{ $ordBar }}%"></div>
        </div>
    </a>

    {{-- Customers --}}
    <a href="{{ route('admin.customers.index') }}" class="block bg-white rounded-lg p-4 border border-slate-200 shadow-sm hover:border-emerald-300 transition">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Customers</span>
            @if ($customersPct !== null)
                <span class="inline-flex items-center gap-1 text-[10.5px] font-semibold {{ $customersPct >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                    <i class="fas {{ $customersPct >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} text-[8px]"></i>
                    {{ abs($customersPct) }}%
                </span>
            @endif
        </div>
        <p class="text-[22px] font-bold text-slate-900 tracking-tight">{{ number_format($totalCustomers) }}</p>
        <p class="text-[11.5px] text-slate-400 mt-1">{{ $newCustomers }} new this week</p>
        <div class="mt-3 h-1 rounded-full bg-slate-100 overflow-hidden">
            <div class="h-full bg-gradient-to-r from-emerald-400 to-emerald-300" style="width:{{ $totalCustomers > 0 ? min(100, (int)(($newCustomers/$totalCustomers)*100)*5) : 0 }}%"></div>
        </div>
    </a>

    {{-- Products --}}
    <a href="{{ route('admin.products.index') }}" class="block bg-white rounded-lg p-4 border border-slate-200 shadow-sm hover:border-blue-300 transition">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Products</span>
            @if ($outOfStockCount > 0)
                <span class="inline-flex items-center gap-1 text-[10.5px] font-semibold text-rose-600">
                    <i class="fas fa-arrow-down text-[8px]"></i> {{ $outOfStockCount }} OOS
                </span>
            @endif
        </div>
        <p class="text-[22px] font-bold text-slate-900 tracking-tight">{{ number_format($totalProducts) }}</p>
        <p class="text-[11.5px] text-slate-400 mt-1">
            @if ($outOfStockCount > 0)
                <span class="text-rose-500">{{ $outOfStockCount }} out of stock</span>
            @else
                All products in stock
            @endif
        </p>
        <div class="mt-3 h-1 rounded-full bg-slate-100 overflow-hidden">
            @php $inStockPct = $totalProducts > 0 ? (int)(( ($totalProducts - $outOfStockCount) / $totalProducts) * 100) : 0; @endphp
            <div class="h-full bg-gradient-to-r from-blue-400 to-blue-300" style="width:{{ $inStockPct }}%"></div>
        </div>
    </a>

    {{-- Live Visitors --}}
    <div class="bg-white rounded-lg p-4 border border-emerald-200 shadow-sm">
        <div class="flex items-center justify-between mb-3">
            <span class="text-[11px] uppercase tracking-wider text-slate-500 font-semibold">Live Visitors</span>
            <span class="inline-flex items-center gap-1.5">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[10px] font-semibold text-emerald-600">LIVE</span>
            </span>
        </div>
        <p class="text-[22px] font-bold text-slate-900 tracking-tight" id="liveVisitorCount">—</p>
        <p class="text-[11.5px] text-slate-400 mt-1">Active in last 5 min</p>
        <div class="mt-3 h-1 rounded-full bg-slate-100 overflow-hidden">
            <div class="h-full bg-gradient-to-r from-emerald-500 to-emerald-300 transition-all duration-700" id="liveVisitorBar" style="width:0%"></div>
        </div>
    </div>

</div>

<!-- Visitor Analytics -->
<div class="bg-white rounded-lg border border-slate-200 shadow-sm mb-5">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-4 border-b border-slate-100">
        <div>
            <h3 class="text-[14px] font-semibold text-slate-900">Visitor Analytics</h3>
            <p class="text-[11.5px] text-slate-500 mt-0.5">Unique visitors tracked by session</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="flex items-center gap-2 bg-emerald-50 border border-emerald-200 rounded-lg px-3 py-2">
                <span class="relative flex h-2 w-2 shrink-0">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                <span class="text-[11.5px] text-slate-600 font-medium">Live now:</span>
                <span class="text-[13px] font-bold text-emerald-700" id="vaLiveCount">—</span>
            </div>
            <div class="flex items-center gap-2 bg-blue-50 border border-blue-200 rounded-lg px-3 py-2">
                <i class="fas fa-calendar-day text-blue-400 text-[11px]"></i>
                <span class="text-[11.5px] text-slate-600 font-medium">Today:</span>
                <span class="text-[13px] font-bold text-blue-700" id="vaTodayCount">—</span>
            </div>
        </div>
    </div>

    <div class="p-4">
        {{-- Date filter --}}
        <div class="flex flex-wrap items-end gap-3 mb-4">
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">From Date</label>
                <input type="date" id="vaFrom" value="{{ now()->toDateString() }}"
                    class="border border-slate-200 rounded-md px-3 py-1.5 text-[13px] text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-300">
            </div>
            <div>
                <label class="block text-[11px] font-semibold text-slate-500 uppercase tracking-wide mb-1">To Date <span class="font-normal text-slate-400">(optional)</span></label>
                <input type="date" id="vaTo"
                    class="border border-slate-200 rounded-md px-3 py-1.5 text-[13px] text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-300">
            </div>
            <button onclick="queryVisitorStats()"
                class="flex items-center gap-2 px-4 py-1.5 bg-slate-900 hover:bg-slate-800 text-white rounded-md text-[13px] font-semibold transition">
                <i class="fas fa-search text-[11px]"></i> Search
            </button>
        </div>

        {{-- Results --}}
        <div id="vaResults" class="hidden">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[13px] font-semibold text-slate-700" id="vaResultLabel"></p>
                <span class="text-[20px] font-bold text-slate-900" id="vaResultTotal"></span>
            </div>
            <div class="overflow-x-auto" id="vaTableWrap">
                <table class="w-full text-[12.5px]" id="vaTable">
                    <thead>
                        <tr class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-500 bg-slate-50">
                            <th class="text-left px-3 py-2 rounded-l">Date</th>
                            <th class="text-left px-3 py-2">Day</th>
                            <th class="text-right px-3 py-2 rounded-r">Unique Visitors</th>
                        </tr>
                    </thead>
                    <tbody id="vaTableBody" class="divide-y divide-slate-100"></tbody>
                </table>
            </div>
            <p id="vaEmpty" class="hidden text-[13px] text-slate-400 py-3 text-center">No visitor data for this period.</p>
        </div>

        <div id="vaLoading" class="hidden py-4 text-center text-[13px] text-slate-400">
            <i class="fas fa-circle-notch fa-spin mr-1"></i> Loading...
        </div>
    </div>
</div>

<!-- Sales chart + Recent orders -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4 mb-5">

    <div class="xl:col-span-2 bg-white rounded-lg border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between p-4 border-b border-slate-100">
            <div>
                <h3 class="text-[14px] font-semibold text-slate-900">Sales Overview</h3>
                <p class="text-[11.5px] text-slate-500 mt-0.5">Revenue for the last 7 days</p>
            </div>
            <span class="text-[11px] text-slate-400 font-mono">৳ {{ number_format(collect($bars)->sum(fn($b) => 0)) }}</span>
        </div>

        <div class="p-4">
            <div class="flex items-end justify-between gap-2 h-44">
                @foreach($bars as $bar)
                    <div class="flex-1 flex flex-col items-center gap-1.5 group">
                        <span class="text-[10px] font-semibold text-slate-700 opacity-0 group-hover:opacity-100 transition whitespace-nowrap">{{ $bar['val'] }}</span>
                        <div class="w-full rounded-t-md bg-slate-100 group-hover:bg-slate-200 transition relative overflow-hidden flex items-end" style="height: 100%">
                            <div class="w-full rounded-t-md bg-gradient-to-t from-brand-600 to-brand-400 group-hover:from-brand-700 group-hover:to-brand-500 transition" style="height: {{ $bar['h'] }}%"></div>
                        </div>
                        <span class="text-[10.5px] font-medium text-slate-400">{{ $bar['day'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg border border-slate-200 shadow-sm flex flex-col">
        <div class="flex items-center justify-between p-4 border-b border-slate-100">
            <h3 class="text-[14px] font-semibold text-slate-900">Recent Orders</h3>
            <a href="{{ route('admin.orders.index') }}" class="text-[11.5px] font-semibold text-brand-500 hover:underline">View all</a>
        </div>

        @if ($recentOrders->isEmpty())
            <div class="p-6 text-center text-[13px] text-slate-400">No orders yet.</div>
        @else
        <ul class="divide-y divide-slate-100 flex-1">
            @foreach($recentOrders as $order)
                <li class="flex items-center gap-3 px-4 py-2.5">
                    <div class="w-8 h-8 rounded-md bg-slate-100 grid place-items-center text-slate-600 font-bold text-[11px] shrink-0">
                        {{ strtoupper(substr($order['name'], 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ $order['url'] }}" class="text-[13px] font-medium text-slate-800 truncate leading-tight hover:text-brand-600 block">{{ $order['name'] }}</a>
                        <p class="text-[10.5px] text-slate-400 mt-0.5 font-mono">{{ $order['order'] }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-[12.5px] font-semibold text-slate-800">{{ $order['amt'] }}</p>
                        <span class="text-[9px] font-semibold uppercase px-1.5 py-0.5 rounded ring-1 {{ $statusStyles[$order['status']] ?? 'bg-gray-100 text-gray-600 ring-gray-200' }}">
                            {{ $order['status'] }}
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
        @endif
    </div>

</div>

<!-- Top products + Activity -->
<div class="grid grid-cols-1 xl:grid-cols-3 gap-4">

    <div class="xl:col-span-2 bg-white rounded-lg border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between p-4 border-b border-slate-100">
            <div>
                <h3 class="text-[14px] font-semibold text-slate-900">Top Selling Products</h3>
                <p class="text-[11.5px] text-slate-500 mt-0.5">By total quantity ordered</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="text-[11.5px] font-semibold text-brand-500 hover:underline">View all</a>
        </div>

        @if ($topProducts->isEmpty())
            <div class="p-6 text-center text-[13px] text-slate-400">No orders yet to rank products.</div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-[13px]">
                <thead>
                    <tr class="text-[10.5px] font-semibold uppercase tracking-wider text-slate-500 bg-slate-50/60">
                        <th class="text-left px-4 py-2">Product</th>
                        <th class="text-left px-4 py-2">Category</th>
                        <th class="text-right px-4 py-2">Sold</th>
                        <th class="text-right px-4 py-2">Revenue</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($topProducts as $p)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-4 py-2.5">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-7 h-7 rounded bg-slate-100 grid place-items-center text-slate-400 text-[11px] shrink-0">
                                        <i class="fas fa-box"></i>
                                    </div>
                                    @if ($p['product_id'])
                                        <a href="{{ route('admin.products.edit', $p['product_id']) }}"
                                           class="font-medium text-slate-800 hover:text-brand-600 truncate max-w-[180px] block">{{ $p['name'] }}</a>
                                    @else
                                        <span class="font-medium text-slate-800">{{ $p['name'] }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-2.5">
                                <span class="text-[10.5px] px-1.5 py-0.5 bg-slate-100 text-slate-600 rounded font-medium">{{ $p['cat'] }}</span>
                            </td>
                            <td class="px-4 py-2.5 text-right font-semibold text-slate-800">{{ number_format($p['sold']) }}</td>
                            <td class="px-4 py-2.5 text-right font-semibold text-slate-900">{{ $p['rev'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>

    <div class="bg-white rounded-lg border border-slate-200 shadow-sm">
        <div class="flex items-center justify-between p-4 border-b border-slate-100">
            <h3 class="text-[14px] font-semibold text-slate-900">Recent Activity</h3>
        </div>

        @if ($activity->isEmpty())
            <div class="p-6 text-center text-[13px] text-slate-400">No activity yet.</div>
        @else
        <ol class="relative px-4 py-4 space-y-4">
            <div class="absolute left-[27px] top-6 bottom-6 w-px bg-slate-200"></div>

            @foreach ($activity as $event)
                <li class="relative flex gap-3">
                    <div class="w-7 h-7 rounded-full {{ $event['color'] }} ring-4 ring-white grid place-items-center shrink-0 z-10">
                        <i class="{{ $event['icon'] }} text-[10px]"></i>
                    </div>
                    <div class="flex-1 -mt-0.5">
                        <p class="text-[12.5px] text-slate-800 leading-snug">{!! $event['message'] !!}</p>
                        <p class="text-[10.5px] text-slate-400 mt-0.5">{{ $event['time'] }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
        @endif
    </div>

</div>

@endsection

@push('scripts')
<script>
    const LIVE_VISITORS_URL  = '{{ route('admin.live-visitors') }}';
    const VISITOR_STATS_URL  = '{{ route('admin.visitor-stats') }}';

    const DAYS = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];

    // ── Live visitor stat card (top row) ──────────────────────────────
    function fetchLiveVisitors() {
        fetch(LIVE_VISITORS_URL, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                const count = data.count ?? 0;
                const el  = document.getElementById('liveVisitorCount');
                const bar = document.getElementById('liveVisitorBar');
                const va  = document.getElementById('vaLiveCount');
                if (el)  el.textContent = count;
                if (va)  va.textContent = count;
                if (bar) bar.style.width = Math.min(100, count * 10) + '%';
            })
            .catch(() => {});
    }

    // ── Visitor Analytics panel ───────────────────────────────────────
    function fetchTodayVisitors() {
        fetch(VISITOR_STATS_URL + '?from={{ now()->toDateString() }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(r => r.json())
            .then(data => {
                const el = document.getElementById('vaTodayCount');
                if (el) el.textContent = data.today ?? 0;
            })
            .catch(() => {});
    }

    function queryVisitorStats() {
        const from = document.getElementById('vaFrom').value;
        const to   = document.getElementById('vaTo').value;
        if (!from) return;

        document.getElementById('vaResults').classList.add('hidden');
        document.getElementById('vaLoading').classList.remove('hidden');

        let url = VISITOR_STATS_URL + '?from=' + from;
        if (to) url += '&to=' + to;

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                document.getElementById('vaLoading').classList.add('hidden');

                const q = data.queried;
                if (!q) return;

                const isSingle = q.from === q.to;
                const label    = isSingle
                    ? 'Visitors on ' + q.from
                    : 'Visitors from ' + q.from + ' to ' + q.to;

                document.getElementById('vaResultLabel').textContent = label;
                document.getElementById('vaResultTotal').textContent  = q.total + ' visitor' + (q.total !== 1 ? 's' : '');

                // Update today pill as well
                const todayEl = document.getElementById('vaTodayCount');
                if (todayEl) todayEl.textContent = data.today ?? 0;

                const tbody = document.getElementById('vaTableBody');
                tbody.innerHTML = '';

                if (q.days.length === 0) {
                    document.getElementById('vaEmpty').classList.remove('hidden');
                    document.getElementById('vaTableWrap').classList.add('hidden');
                } else {
                    document.getElementById('vaEmpty').classList.add('hidden');
                    document.getElementById('vaTableWrap').classList.remove('hidden');

                    q.days.forEach(row => {
                        const d    = new Date(row.date + 'T00:00:00');
                        const day  = DAYS[d.getDay()];
                        const tr   = document.createElement('tr');
                        tr.className = 'hover:bg-slate-50 transition';
                        tr.innerHTML =
                            '<td class="px-3 py-2 font-mono text-slate-600">' + row.date + '</td>' +
                            '<td class="px-3 py-2 text-slate-500">' + day + '</td>' +
                            '<td class="px-3 py-2 text-right font-semibold text-slate-800">' + row.count + '</td>';
                        tbody.appendChild(tr);
                    });
                }

                document.getElementById('vaResults').classList.remove('hidden');
            })
            .catch(() => {
                document.getElementById('vaLoading').classList.add('hidden');
            });
    }

    // Initial loads
    fetchLiveVisitors();
    fetchTodayVisitors();

    // Auto-refresh every 30 seconds
    setInterval(fetchLiveVisitors,   30000);
    setInterval(fetchTodayVisitors,  30000);
</script>
@endpush
