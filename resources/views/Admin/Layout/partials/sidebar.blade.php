@php($_admin = Auth::guard('admin')->user())

<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
       class="fixed lg:relative inset-y-0 left-0 z-40 w-60 flex flex-col
              bg-slate-900 text-slate-300
              transform transition-transform duration-300 ease-in-out
              border-r border-slate-800">

    <!-- Brand -->
    <div class="flex items-center justify-between h-14 px-5 border-b border-slate-800 shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-gradient-to-br from-accent-400 to-accent-500 flex items-center justify-center">
                <i class="fas fa-bolt text-slate-900 text-[11px]"></i>
            </div>
            <p class="font-semibold text-[13.5px] text-white tracking-tight">ROVENTEX</p>
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
            <i class="fas fa-xmark text-sm"></i>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto sidebar-scroll px-3 py-4">
        <div class="space-y-5">

            {{-- ── MAIN ── --}}
            <div>
                <p class="px-2.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 mb-1.5">Main</p>
                <ul class="space-y-0.5">
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                            <i class="fas fa-gauge-high w-4 text-[12px] {{ request()->routeIs('admin.dashboard') ? 'text-accent-400' : '' }}"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                </ul>
            </div>

            {{-- ── CATALOG ── --}}
            @if($_admin->hasPermission('products.view') || $_admin->hasPermission('categories.view') || $_admin->hasPermission('brands.view') || $_admin->hasPermission('units.view') || $_admin->hasPermission('suppliers.view') || $_admin->hasPermission('warehouses.view'))
            <div>
                <p class="px-2.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 mb-1.5">Catalog</p>
                <ul class="space-y-0.5">
                    @if($_admin->hasPermission('products.view'))
                    <li><a href="{{ route('admin.products.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-box w-4 text-[12px] {{ request()->routeIs('admin.products.*') ? 'text-accent-400' : '' }}"></i><span>Products</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('categories.view'))
                    <li><a href="{{ route('admin.categories.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-layer-group w-4 text-[12px] {{ request()->routeIs('admin.categories.*') ? 'text-accent-400' : '' }}"></i><span>Categories</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('brands.view'))
                    <li><a href="{{ route('admin.brands.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.brands.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-tags w-4 text-[12px] {{ request()->routeIs('admin.brands.*') ? 'text-accent-400' : '' }}"></i><span>Brands</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('units.view'))
                    <li><a href="{{ route('admin.units.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.units.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-ruler-combined w-4 text-[12px] {{ request()->routeIs('admin.units.*') ? 'text-accent-400' : '' }}"></i><span>Units</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('suppliers.view'))
                    <li><a href="{{ route('admin.suppliers.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.suppliers.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-truck w-4 text-[12px] {{ request()->routeIs('admin.suppliers.*') ? 'text-accent-400' : '' }}"></i><span>Suppliers</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('warehouses.view'))
                    <li><a href="{{ route('admin.warehouses.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.warehouses.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-warehouse w-4 text-[12px] {{ request()->routeIs('admin.warehouses.*') ? 'text-accent-400' : '' }}"></i><span>Warehouses</span>
                    </a></li>
                    @endif
                </ul>
            </div>
            @endif

            {{-- ── INVENTORY ── --}}
            @if($_admin->hasPermission('purchases.view') || $_admin->hasPermission('grn.view') || $_admin->hasPermission('grn_returns.view') || $_admin->hasPermission('stock_transfers.view') || $_admin->hasPermission('stock_adjustments.view') || $_admin->hasPermission('stock_report.view'))
            <div>
                <p class="px-2.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 mb-1.5">Inventory</p>
                <ul class="space-y-0.5">
                    @if($_admin->hasPermission('purchases.view'))
                    <li><a href="{{ route('admin.purchases.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.purchases.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-cart-plus w-4 text-[12px] {{ request()->routeIs('admin.purchases.*') ? 'text-accent-400' : '' }}"></i><span>Purchases</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('grn.view'))
                    <li><a href="{{ route('admin.grn.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.grn.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-clipboard-check w-4 text-[12px] {{ request()->routeIs('admin.grn.*') ? 'text-accent-400' : '' }}"></i><span>GRN</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('grn_returns.view'))
                    <li><a href="{{ route('admin.grn-returns.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.grn-returns.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-rotate-left w-4 text-[12px] {{ request()->routeIs('admin.grn-returns.*') ? 'text-accent-400' : '' }}"></i><span>GRN Returns</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('stock_transfers.view'))
                    <li><a href="{{ route('admin.stock-transfers.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.stock-transfers.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-right-left w-4 text-[12px] {{ request()->routeIs('admin.stock-transfers.*') ? 'text-accent-400' : '' }}"></i><span>Stock Transfers</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('stock_adjustments.view'))
                    <li><a href="{{ route('admin.stock-adjustments.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.stock-adjustments.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-pen-to-square w-4 text-[12px] {{ request()->routeIs('admin.stock-adjustments.*') ? 'text-accent-400' : '' }}"></i><span>Adjustments</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('stock_report.view'))
                    <li><a href="{{ route('admin.stock-report.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.stock-report.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-chart-simple w-4 text-[12px] {{ request()->routeIs('admin.stock-report.*') ? 'text-accent-400' : '' }}"></i><span>Stock Report</span>
                    </a></li>
                    @endif
                </ul>
            </div>
            @endif

            {{-- ── SALES ── --}}
            @if($_admin->hasPermission('orders.view') || $_admin->hasPermission('abandoned_carts.view') || $_admin->hasPermission('customers.view') || $_admin->hasPermission('phone_blacklist.view') || $_admin->hasPermission('coupons.view') || $_admin->hasPermission('contact_messages.view'))
            <div>
                <p class="px-2.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 mb-1.5">Sales</p>
                <ul class="space-y-0.5">
                    @if($_admin->hasPermission('orders.view'))
                    @php($pendingOrderCount = \App\Models\Order::where('status','pending')->count())
                    <li><a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-cart-shopping w-4 text-[12px] {{ request()->routeIs('admin.orders.*') ? 'text-accent-400' : '' }}"></i>
                        <span>Orders</span>
                        @if($pendingOrderCount > 0)<span class="ml-auto text-[10px] bg-red-500/90 text-white px-1.5 py-0.5 rounded font-semibold">{{ $pendingOrderCount }}</span>@endif
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('abandoned_carts.view'))
                    @php($abandonedCount = \App\Models\Cart::whereNull('converted_at')->whereHas('items')->count())
                    <li><a href="{{ route('admin.abandoned-carts.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.abandoned-carts.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-cart-arrow-down w-4 text-[12px] {{ request()->routeIs('admin.abandoned-carts.*') ? 'text-accent-400' : '' }}"></i>
                        <span>Abandoned Carts</span>
                        @if($abandonedCount > 0)<span class="ml-auto text-[10px] bg-orange-500/90 text-white px-1.5 py-0.5 rounded font-semibold">{{ $abandonedCount }}</span>@endif
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('customers.view'))
                    <li><a href="{{ route('admin.customers.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-users w-4 text-[12px] {{ request()->routeIs('admin.customers.*') ? 'text-accent-400' : '' }}"></i><span>Customers</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('phone_blacklist.view'))
                    <li><a href="{{ route('admin.phone-blacklist.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.phone-blacklist.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-ban w-4 text-[12px] {{ request()->routeIs('admin.phone-blacklist.*') ? 'text-accent-400' : '' }}"></i><span>Phone Blacklist</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('coupons.view'))
                    <li><a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.coupons.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-percent w-4 text-[12px] {{ request()->routeIs('admin.coupons.*') ? 'text-accent-400' : '' }}"></i><span>Coupons</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('contact_messages.view'))
                    @php($unreadMessages = \App\Models\ContactMessage::where('status','new')->count())
                    <li><a href="{{ route('admin.contact-messages.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.contact-messages.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-envelope-open-text w-4 text-[12px] {{ request()->routeIs('admin.contact-messages.*') ? 'text-accent-400' : '' }}"></i>
                        <span>Messages</span>
                        @if($unreadMessages > 0)<span class="ml-auto text-[10px] bg-red-500/90 text-white px-1.5 py-0.5 rounded font-semibold">{{ $unreadMessages }}</span>@endif
                    </a></li>
                    @endif
                </ul>
            </div>
            @endif

            {{-- ── CONTENT ── --}}
            @if($_admin->hasPermission('sliders.view') || $_admin->hasPermission('trust_items.view') || $_admin->hasPermission('deals_banner.view') || $_admin->hasPermission('landings.view') || $_admin->hasPermission('about_page.view'))
            @php($homePageActive = request()->routeIs('admin.sliders.*') || request()->routeIs('admin.trust-items.*') || request()->routeIs('admin.deals-banner.*'))
            <div>
                <p class="px-2.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 mb-1.5">Content</p>
                <ul class="space-y-0.5">
                    @if($_admin->hasPermission('landings.view'))
                    <li><a href="{{ route('admin.landings.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.landings.*') || request()->routeIs('admin.products.landing.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-bullseye w-4 text-[12px] {{ request()->routeIs('admin.landings.*') || request()->routeIs('admin.products.landing.*') ? 'text-accent-400' : '' }}"></i><span>Landings</span>
                    </a></li>
                    @endif

                    @if($_admin->hasPermission('sliders.view') || $_admin->hasPermission('trust_items.view') || $_admin->hasPermission('deals_banner.view'))
                    <li x-data="{ open: {{ $homePageActive ? 'true' : 'false' }} }">
                        <button @click="open = !open" type="button" class="w-full flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ $homePageActive ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                            <i class="fas fa-house w-4 text-[12px] {{ $homePageActive ? 'text-accent-400' : '' }}"></i>
                            <span>Home Page</span>
                            <i class="fas fa-chevron-down ml-auto text-[10px] transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <ul class="mt-0.5 ml-3.5 pl-2.5 border-l border-slate-800 space-y-0.5" x-show="open" x-cloak>
                            @if($_admin->hasPermission('sliders.view'))
                            <li><a href="{{ route('admin.sliders.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.sliders.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                                <i class="fas fa-images w-4 text-[12px] {{ request()->routeIs('admin.sliders.*') ? 'text-accent-400' : '' }}"></i><span>Hero Sliders</span>
                            </a></li>
                            @endif
                            @if($_admin->hasPermission('trust_items.view'))
                            <li><a href="{{ route('admin.trust-items.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.trust-items.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                                <i class="fas fa-shield-halved w-4 text-[12px] {{ request()->routeIs('admin.trust-items.*') ? 'text-accent-400' : '' }}"></i><span>Trust Bar</span>
                            </a></li>
                            @endif
                            @if($_admin->hasPermission('deals_banner.view'))
                            <li><a href="{{ route('admin.deals-banner.edit') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.deals-banner.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                                <i class="fas fa-fire w-4 text-[12px] {{ request()->routeIs('admin.deals-banner.*') ? 'text-accent-400' : '' }}"></i><span>Deals Banner</span>
                            </a></li>
                            @endif
                        </ul>
                    </li>
                    @endif

                    @if($_admin->hasPermission('about_page.view'))
                    <li><a href="{{ route('admin.about-page.edit') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.about-page.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-circle-info w-4 text-[12px] {{ request()->routeIs('admin.about-page.*') ? 'text-accent-400' : '' }}"></i><span>About Us</span>
                    </a></li>
                    @endif
                </ul>
            </div>
            @endif

            {{-- ── REPORTS ── --}}
            @if($_admin->hasPermission('sales_report.view') || $_admin->hasPermission('purchase_report.view') || $_admin->hasPermission('customer_report.view'))
            <div>
                <p class="px-2.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 mb-1.5">Reports</p>
                <ul class="space-y-0.5">
                    @if($_admin->hasPermission('sales_report.view'))
                    <li><a href="{{ route('admin.sales-report.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.sales-report.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-chart-line w-4 text-[12px] {{ request()->routeIs('admin.sales-report.*') ? 'text-accent-400' : '' }}"></i><span>Sales Report</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('purchase_report.view'))
                    <li><a href="{{ route('admin.purchase-report.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.purchase-report.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-file-invoice w-4 text-[12px] {{ request()->routeIs('admin.purchase-report.*') ? 'text-accent-400' : '' }}"></i><span>Purchase Report</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('customer_report.view'))
                    <li><a href="{{ route('admin.customer-report.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.customer-report.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-users-rectangle w-4 text-[12px] {{ request()->routeIs('admin.customer-report.*') ? 'text-accent-400' : '' }}"></i><span>Customer Report</span>
                    </a></li>
                    @endif
                </ul>
            </div>
            @endif

            {{-- ── SETTINGS ── --}}
            @if($_admin->hasPermission('pages.view') || $_admin->hasPermission('site_settings.view') || $_admin->hasPermission('admins.view') || $_admin->hasPermission('roles.view'))
            <div>
                <p class="px-2.5 text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-500 mb-1.5">Settings</p>
                <ul class="space-y-0.5">
                    @if($_admin->hasPermission('pages.view'))
                    <li><a href="{{ route('admin.pages.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.pages.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-file-lines w-4 text-[12px] {{ request()->routeIs('admin.pages.*') ? 'text-accent-400' : '' }}"></i><span>Pages</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('site_settings.view'))
                    <li><a href="{{ route('admin.site-settings.edit') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.site-settings.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-store w-4 text-[12px] {{ request()->routeIs('admin.site-settings.*') ? 'text-accent-400' : '' }}"></i><span>Site Settings</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('admins.view'))
                    <li><a href="{{ route('admin.admins.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.admins.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-users-gear w-4 text-[12px] {{ request()->routeIs('admin.admins.*') ? 'text-accent-400' : '' }}"></i><span>Admins</span>
                    </a></li>
                    @endif
                    @if($_admin->hasPermission('roles.view'))
                    <li><a href="{{ route('admin.roles.index') }}" class="flex items-center gap-2.5 px-2.5 py-2 rounded-md text-[13px] font-medium transition-colors {{ request()->routeIs('admin.roles.*') ? 'bg-brand-500/15 text-white' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fas fa-user-shield w-4 text-[12px] {{ request()->routeIs('admin.roles.*') ? 'text-accent-400' : '' }}"></i><span>Roles</span>
                    </a></li>
                    @endif
                </ul>
            </div>
            @endif

        </div>
    </nav>

    <!-- Bottom user mini -->
    <div class="px-3 py-3 border-t border-slate-800 shrink-0">
        <div class="flex items-center gap-2.5 px-2 py-2 rounded-md hover:bg-slate-800/60 transition cursor-pointer">
            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-brand-400 to-brand-600 grid place-items-center text-white text-[11px] font-bold shrink-0">
                {{ strtoupper(substr($_admin->name ?? 'A', 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[12px] font-semibold text-white truncate leading-tight">{{ $_admin->name ?? 'Admin' }}</p>
                <p class="text-[10px] text-slate-500 truncate">{{ $_admin->isSuperAdmin() ? 'Super Admin' : ($_admin->role?->name ?? 'Staff') }}</p>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" title="Sign out" class="text-slate-500 hover:text-red-400 transition w-7 h-7 grid place-items-center rounded">
                    <i class="fas fa-right-from-bracket text-[11px]"></i>
                </button>
            </form>
        </div>
    </div>

</aside>
