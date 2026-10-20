@php($_a = Auth::guard('admin')->user())
<nav class="acc-tabs">
    @if($_a->hasPermission('accounts_report.view'))
        <a href="{{ route('admin.accounts.daily') }}" class="{{ request()->routeIs('admin.accounts.daily') ? 'on' : '' }}"><i class="fas fa-calendar-day mr-1"></i> Daily Report</a>
        <a href="{{ route('admin.accounts.monthly') }}" class="{{ request()->routeIs('admin.accounts.monthly') ? 'on' : '' }}"><i class="fas fa-calendar-alt mr-1"></i> Monthly Report</a>
        <a href="{{ route('admin.accounts.products') }}" class="{{ request()->routeIs('admin.accounts.products') ? 'on' : '' }}"><i class="fas fa-box mr-1"></i> Product Profit</a>
    @endif
    @if($_a->hasPermission('investments.view'))
        <a href="{{ route('admin.investments.index') }}" class="{{ request()->routeIs('admin.investments.*') ? 'on' : '' }}"><i class="fas fa-sack-dollar mr-1"></i> Investment</a>
    @endif
    @if($_a->hasPermission('expenses.view'))
        <a href="{{ route('admin.expenses.index') }}" class="{{ request()->routeIs('admin.expenses.*') ? 'on' : '' }}"><i class="fas fa-receipt mr-1"></i> Expenses</a>
    @endif
</nav>
