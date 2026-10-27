{{-- Product-wise profit rows. Expects $products from ProfitReportService::productWise(). --}}
@php $money = fn ($v) => \App\Support\Money::format($v); @endphp
<div style="overflow-x:auto">
<table class="wp-list-table" style="border:0">
    <thead>
        <tr>
            <th>Product</th>
            <th class="text-right" style="width:80px">Qty Sold</th>
            <th class="text-right" style="width:130px">Sales</th>
            <th class="text-right" style="width:130px">Cost</th>
            <th class="text-right" style="width:130px">Profit</th>
            <th class="text-right" style="width:80px">Margin</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($products as $p)
            <tr>
                <td>
                    @if ($p->product_id)
                        <a href="{{ route('admin.products.edit', $p->product_id) }}" class="text-[#2271b1]">{{ $p->name }}</a>
                    @else
                        {{ $p->name }}
                    @endif
                    @if ($p->sku)<div class="text-[11px] text-[#646970]">{{ $p->sku }}</div>@endif
                    @if ($p->missing_cost)
                        <div class="text-[11px] text-amber-700"><i class="fas fa-triangle-exclamation"></i> No purchase price set</div>
                    @endif
                </td>
                <td class="text-right">{{ rtrim(rtrim(number_format($p->qty, 2), '0'), '.') }}</td>
                <td class="text-right">{{ $money($p->revenue) }}</td>
                <td class="text-right text-[#50575e]">{{ $money($p->cost) }}</td>
                <td class="text-right"><strong class="{{ $p->profit < 0 ? 'amt-neg' : 'amt-pos' }}">{{ $money($p->profit) }}</strong></td>
                <td class="text-right text-[12px]">{{ $p->margin }}%</td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-[#646970] py-8">No products sold in this period.</td></tr>
        @endforelse
    </tbody>
</table>
</div>
