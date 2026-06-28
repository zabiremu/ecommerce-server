@php($adminUser = Auth::guard('admin')->user())

<header class="bg-white border-b border-slate-200 shrink-0 z-20">
    <div class="flex items-center justify-between h-14 px-4 lg:px-6">

        <!-- Left: hamburger + page title + search -->
        <div class="flex items-center gap-3 flex-1 min-w-0">
            <button @click="sidebarOpen = true"
                    class="lg:hidden w-8 h-8 rounded-md hover:bg-slate-100 text-slate-600 grid place-items-center transition">
                <i class="fas fa-bars text-sm"></i>
            </button>

            <div class="hidden lg:block min-w-0">
                <h1 class="text-[14px] font-semibold text-slate-800 truncate">@yield('page_title', 'Dashboard')</h1>
            </div>

            <!-- Global search -->
            <div class="hidden md:block ml-auto lg:ml-6 max-w-sm w-full"
                 x-data="adminSearch()"
                 @keydown.escape.window="close()"
                 x-init="init()">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[12px] pointer-events-none"></i>
                    <input type="text"
                           x-model="query"
                           @input.debounce.300ms="search()"
                           @focus="open = true"
                           @click.outside="open = false"
                           placeholder="Search orders, products, customers…"
                           class="w-full pl-9 pr-3 py-1.5 text-[13px] rounded-md bg-slate-100 border border-transparent
                                  focus:bg-white focus:border-slate-300 focus:ring-2 focus:ring-brand-500/10
                                  outline-none transition placeholder:text-slate-400">

                    <!-- Search results dropdown -->
                    <div x-show="open && (results.length > 0 || loading)"
                         x-cloak
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute top-full left-0 right-0 mt-1.5 bg-white rounded-lg shadow-lg ring-1 ring-slate-200 overflow-hidden z-50 max-h-[420px] overflow-y-auto">

                        <template x-if="loading">
                            <div class="px-4 py-3 text-[12px] text-slate-400 flex items-center gap-2">
                                <i class="fas fa-spinner fa-spin"></i> Searching…
                            </div>
                        </template>

                        <template x-for="group in results" :key="group.group">
                            <div>
                                <div class="px-4 py-1.5 text-[10px] font-semibold uppercase tracking-wider bg-slate-50 border-b border-slate-100"
                                     :class="group.color" x-text="group.group"></div>
                                <template x-for="item in group.items" :key="item.link">
                                    <a :href="item.link"
                                       @click="open = false"
                                       class="flex items-start gap-3 px-4 py-2.5 hover:bg-slate-50 border-b border-slate-100 last:border-0 transition">
                                        <div class="w-7 h-7 rounded-md bg-slate-100 grid place-items-center shrink-0 mt-0.5">
                                            <i class="fas text-[11px] text-slate-500" :class="'fa-' + item.icon.replace('fa-','')"></i>
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-[13px] text-slate-800 font-medium truncate" x-text="item.label"></p>
                                            <p class="text-[11px] text-slate-400 truncate" x-text="item.meta"></p>
                                        </div>
                                    </a>
                                </template>
                            </div>
                        </template>

                        <template x-if="!loading && results.length === 0 && query.length >= 2">
                            <div class="px-4 py-3 text-[12px] text-slate-400">No results found for "<span x-text="query"></span>"</div>
                        </template>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: actions -->
        <div class="flex items-center gap-1">

            <!-- Mobile search trigger -->
            <button class="md:hidden w-8 h-8 rounded-md hover:bg-slate-100 text-slate-600 grid place-items-center transition">
                <i class="fas fa-search text-sm"></i>
            </button>

            <!-- View site -->
            <a href="{{ route('home') }}" target="_blank" title="View site"
               class="hidden sm:grid w-8 h-8 rounded-md hover:bg-slate-100 text-slate-600 place-items-center transition">
                <i class="fas fa-arrow-up-right-from-square text-[12px]"></i>
            </a>

            <!-- Real-time notifications -->
            <div x-data="adminNotifications()" x-init="init()" class="relative">
                <button @click="toggle()"
                        class="relative w-8 h-8 rounded-md hover:bg-slate-100 text-slate-600 grid place-items-center transition">
                    <i class="fas fa-bell text-sm"></i>
                    <span x-show="unread > 0"
                          x-cloak
                          class="absolute top-1 right-1 min-w-[16px] h-4 px-0.5 rounded-full bg-red-500 ring-2 ring-white
                                 text-white text-[9px] font-bold grid place-items-center"
                          x-text="unread > 99 ? '99+' : unread"></span>
                </button>

                <div x-show="open"
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     x-cloak
                     class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-slate-200 overflow-hidden z-50">

                    <div class="px-4 py-2.5 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="font-semibold text-[13px] text-slate-800">
                            Notifications
                            <span x-show="unread > 0" class="ml-1.5 text-[10px] font-bold px-1.5 py-0.5 rounded-full bg-red-100 text-red-600"
                                  x-text="unread + ' new'"></span>
                        </h3>
                        <button @click="markAllRead()" x-show="unread > 0"
                                class="text-[11px] text-brand-500 hover:underline">Mark all read</button>
                    </div>

                    <div class="max-h-80 overflow-y-auto">
                        <template x-if="loading && notifications.length === 0">
                            <div class="px-4 py-5 text-center text-[12px] text-slate-400">
                                <i class="fas fa-spinner fa-spin mr-1"></i> Loading…
                            </div>
                        </template>

                        <template x-if="!loading && notifications.length === 0">
                            <div class="px-4 py-6 text-center text-[12px] text-slate-400">
                                <i class="fas fa-bell-slash text-2xl text-slate-200 block mb-2"></i>
                                No notifications yet
                            </div>
                        </template>

                        <template x-for="n in notifications" :key="n.id">
                            <a :href="n.link || '#'"
                               @click="markRead(n)"
                               class="flex gap-3 px-4 py-2.5 hover:bg-slate-50 border-b border-slate-100 last:border-0 transition"
                               :class="!n.read ? 'bg-brand-50/40' : ''">
                                <div class="w-8 h-8 rounded-full grid place-items-center shrink-0 text-[11px]"
                                     :class="n.bg + ' ' + n.fg">
                                    <i class="fas" :class="'fa-' + n.icon.replace('fa-','')"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-[13px] text-slate-800 leading-snug font-medium" x-text="n.title"></p>
                                    <p class="text-[11px] text-slate-500 truncate mt-0.5" x-text="n.message"></p>
                                    <p class="text-[10px] text-slate-400 mt-0.5" x-text="n.time"></p>
                                </div>
                                <div x-show="!n.read" class="w-2 h-2 rounded-full bg-brand-500 mt-1.5 shrink-0"></div>
                            </a>
                        </template>
                    </div>

                    <div class="px-4 py-2 text-center border-t border-slate-100 bg-slate-50">
                        <span class="text-[11px] text-slate-400">Auto-refreshes every 30s</span>
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="hidden sm:block w-px h-6 bg-slate-200 mx-1.5"></div>

            <!-- User dropdown -->
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open"
                        class="flex items-center gap-2 px-1 py-1 rounded-md hover:bg-slate-100 transition">
                    <div class="w-7 h-7 rounded-md bg-gradient-to-br from-brand-500 to-brand-700
                                grid place-items-center text-white text-[11px] font-bold">
                        {{ strtoupper(substr($adminUser->name ?? 'A', 0, 1)) }}
                    </div>
                    <span class="hidden sm:inline text-[12.5px] font-semibold text-slate-700 truncate max-w-[100px]">{{ explode(' ', $adminUser->name ?? 'Admin')[0] }}</span>
                    <i class="fas fa-chevron-down text-[9px] text-slate-400 hidden sm:inline mr-1"></i>
                </button>

                <div x-show="open"
                     @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 -translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-100"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-1"
                     x-cloak
                     class="absolute right-0 mt-2 w-60 bg-white rounded-lg shadow-lg ring-1 ring-slate-200 overflow-hidden">

                    <div class="px-4 py-3 border-b border-slate-100">
                        <div class="flex items-center gap-2.5">
                            <div class="w-9 h-9 rounded-md bg-gradient-to-br from-brand-500 to-brand-700 grid place-items-center text-white font-bold text-[13px]">
                                {{ strtoupper(substr($adminUser->name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="font-semibold text-[13px] text-slate-800 truncate leading-tight">{{ $adminUser->name ?? 'Admin' }}</p>
                                <p class="text-[11px] text-slate-500 truncate">{{ $adminUser->email ?? '' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="py-1">
                        <a href="{{ route('admin.profile') }}" class="flex items-center gap-2.5 px-4 py-2 text-[13px] text-slate-700 hover:bg-slate-50 transition">
                            <i class="fas fa-user w-3.5 text-slate-400 text-[12px]"></i>
                            <span>My Profile</span>
                        </a>
                        <a href="{{ route('admin.change-password') }}" class="flex items-center gap-2.5 px-4 py-2 text-[13px] text-slate-700 hover:bg-slate-50 transition">
                            <i class="fas fa-key w-3.5 text-slate-400 text-[12px]"></i>
                            <span>Change Password</span>
                        </a>
                    </div>

                    <div class="border-t border-slate-100 py-1">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full flex items-center gap-2.5 px-4 py-2 text-[13px] text-red-600 hover:bg-red-50 transition">
                                <i class="fas fa-right-from-bracket w-3.5 text-[12px]"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</header>

@push('scripts')
<script>
const _ADMIN_NOTIF_URL   = '{{ route('admin.notifications.index') }}';
const _ADMIN_NOTIF_READ  = '{{ route('admin.notifications.mark-all-read') }}';
const _ADMIN_NOTIF_ONE   = '{{ url('admin/notifications') }}/';
const _ADMIN_SEARCH_URL  = '{{ route('admin.search') }}';
const _ADMIN_CSRF        = '{{ csrf_token() }}';

function adminNotifications() {
    return {
        open: false,
        loading: false,
        notifications: [],
        unread: 0,
        _timer: null,

        init() {
            this.fetch();
            this._timer = setInterval(() => this.fetch(), 30000);
        },

        toggle() {
            this.open = !this.open;
            if (this.open) this.fetch();
        },

        async fetch() {
            this.loading = true;
            try {
                const res  = await fetch(_ADMIN_NOTIF_URL, { headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' } });
                const data = await res.json();
                this.notifications = data.notifications || [];
                this.unread        = data.unread_count  || 0;
            } catch (e) {}
            this.loading = false;
        },

        async markAllRead() {
            await fetch(_ADMIN_NOTIF_READ, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': _ADMIN_CSRF, 'X-Requested-With': 'XMLHttpRequest' },
            });
            this.notifications.forEach(n => n.read = true);
            this.unread = 0;
        },

        async markRead(n) {
            if (n.read) return;
            n.read = true;
            this.unread = Math.max(0, this.unread - 1);
            fetch(_ADMIN_NOTIF_ONE + n.id + '/read', {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': _ADMIN_CSRF, 'X-Requested-With': 'XMLHttpRequest' },
            }).catch(() => {});
        },
    };
}

function adminSearch() {
    return {
        query: '',
        results: [],
        loading: false,
        open: false,
        _ctrl: null,

        init() {},

        async search() {
            const q = this.query.trim();
            if (q.length < 2) { this.results = []; this.open = false; return; }
            this.open    = true;
            this.loading = true;
            if (this._ctrl) this._ctrl.abort();
            this._ctrl = new AbortController();
            try {
                const res  = await fetch(_ADMIN_SEARCH_URL + '?q=' + encodeURIComponent(q), {
                    signal:  this._ctrl.signal,
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                });
                const data = await res.json();
                this.results = data.results || [];
            } catch (e) {
                if (e.name !== 'AbortError') this.results = [];
            }
            this.loading = false;
        },

        close() { this.open = false; },
    };
}
</script>
@endpush
