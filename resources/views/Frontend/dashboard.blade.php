@extends('Frontend.Layout.app')

@section('content')
@auth('web')
<script>
    (function () {
        var authUser = @json(['email' => $authUser->email, 'name' => $authUser->name]);
        var logged = JSON.parse(localStorage.getItem('nfshop_logged') || 'null');
        if (!logged || logged.email !== authUser.email) {
            localStorage.setItem('nfshop_logged', JSON.stringify(authUser));
        }
    })();
</script>
@endauth
<!-- Breadcrumb -->
<section class="breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>Dashboard</span>
    </div>
</section>

<!-- Dashboard Section -->
<section class="dash-section">
    <div class="container">
        <div class="dash-layout">

            <!-- Sidebar -->
            <aside class="dash-sidebar">
                <div class="dash-user">
                    <div class="dash-user-bg"></div>
                    <div class="dash-avatar-wrap">
                        <div class="dash-avatar" id="dashAvatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <span class="dash-avatar-status"></span>
                    </div>
                    <div class="dash-user-info">
                        <h4 id="dashUserName">User</h4>
                        <p id="dashUserEmail">user@email.com</p>
                        <!-- <sReward Pointspan class="dash-tier"><i class="fas fa-crown"></i> VIP Member</span> -->
                    </div>
                </div>

                <!-- <div class="dash-loyalty">
                    <div class="dash-loyalty-head">
                        <span><i class="fas fa-gem"></i> Reward Points</span>
                        <strong>1,250</strong>
                    </div>
                    <div class="dash-loyalty-bar"><span style="width:62%"></span></div>
                    <p>750 points to next tier</p>
                </div> -->

                <nav class="dash-nav">
                    <button class="dash-nav-item active" onclick="switchDashTab('overview',this)">
                        <i class="fas fa-th-large"></i> <span>Overview</span>
                    </button>
                    <button class="dash-nav-item" onclick="switchDashTab('orders',this)">
                        <i class="fas fa-shopping-bag"></i> <span>My Orders</span>
                        <span class="dash-badge" id="orderCountBadge">0</span>
                    </button>
                    <button class="dash-nav-item" onclick="switchDashTab('wishlist',this)">
                        <i class="far fa-heart"></i> <span>Wishlist</span>
                        <span class="dash-badge" id="wishCountBadge">0</span>
                    </button>
                    <button class="dash-nav-item" onclick="switchDashTab('settings',this)">
                        <i class="fas fa-cog"></i> <span>Settings</span>
                    </button>
                    <button class="dash-nav-item dash-logout" onclick="handleLogout()">
                        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
                    </button>
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="dash-main">

                <!-- Overview Tab -->
                <div class="dash-tab active" id="dashOverview">

                    <!-- Welcome Banner -->
                    <div class="dash-welcome">
                        <div class="dw-bg-pattern"></div>
                        <div class="dw-content">
                            <span class="dw-chip"><i class="fas fa-hand-sparkles"></i> Welcome back</span>
                            <h2>Hello, <span id="dashWelcomeName">User</span> <span class="dw-wave">👋</span></h2>
                            <p>Here's a snapshot of your account and recent activity.</p>
                            <div class="dw-actions">
                                <a href="{{ route('all-products') }}" class="dw-btn primary"><i class="fas fa-shopping-cart"></i> Continue Shopping</a>
                                <a href="{{ route('track-order') }}" class="dw-btn ghost"><i class="fas fa-truck"></i> Track Order</a>
                            </div>
                        </div>
                        <div class="dw-illustration">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                    </div>

                    <!-- Stat Cards -->
                    <div class="dash-stats">
                        <div class="dash-stat-card sc-blue">
                            <div class="dsc-top">
                                <div class="dsc-icon"><i class="fas fa-shopping-bag"></i></div>
                                <span class="dsc-trend up"><i class="fas fa-arrow-up"></i> 12%</span>
                            </div>
                            <h3 id="statOrders">0</h3>
                            <p>Total Orders</p>
                            <span class="dsc-foot">All time</span>
                        </div>
                        <div class="dash-stat-card sc-green">
                            <div class="dsc-top">
                                <div class="dsc-icon"><i class="fas fa-wallet"></i></div>
                                <span class="dsc-trend up"><i class="fas fa-arrow-up"></i> 8%</span>
                            </div>
                            <h3 id="statSpent">TK 0</h3>
                            <p>Total Spent</p>
                            <span class="dsc-foot">Lifetime value</span>
                        </div>
                        <div class="dash-stat-card sc-orange">
                            <div class="dsc-top">
                                <div class="dsc-icon"><i class="far fa-heart"></i></div>
                                <span class="dsc-trend neutral"><i class="fas fa-equals"></i></span>
                            </div>
                            <h3 id="statWishlist">0</h3>
                            <p>Wishlist Items</p>
                            <span class="dsc-foot">Saved for later</span>
                        </div>
                        <div class="dash-stat-card sc-red">
                            <div class="dsc-top">
                                <div class="dsc-icon"><i class="fas fa-shopping-cart"></i></div>
                                <span class="dsc-trend up"><i class="fas fa-arrow-up"></i> 3</span>
                            </div>
                            <h3 id="statCart">0</h3>
                            <p>Items In Cart</p>
                            <span class="dsc-foot">Ready to checkout</span>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="dash-quick">
                        <a href="{{ route('track-order') }}" class="dq-card">
                            <span class="dq-icon" style="background:#eef2ff;color:#4f46e5"><i class="fas fa-truck"></i></span>
                            <div>
                                <h5>Track Order</h5>
                                <p>Live shipment status</p>
                            </div>
                            <i class="fas fa-chevron-right dq-arrow"></i>
                        </a>
                        <a href="#" onclick="switchDashTab('wishlist',document.querySelectorAll('.dash-nav-item')[2]);return false" class="dq-card">
                            <span class="dq-icon" style="background:#fef2f2;color:#ef4444"><i class="far fa-heart"></i></span>
                            <div>
                                <h5>My Wishlist</h5>
                                <p>Saved products</p>
                            </div>
                            <i class="fas fa-chevron-right dq-arrow"></i>
                        </a>
                        <a href="#" onclick="switchDashTab('settings',document.querySelectorAll('.dash-nav-item')[3]);return false" class="dq-card">
                            <span class="dq-icon" style="background:#ecfdf5;color:#10b981"><i class="fas fa-user-edit"></i></span>
                            <div>
                                <h5>Edit Profile</h5>
                                <p>Update your info</p>
                            </div>
                            <i class="fas fa-chevron-right dq-arrow"></i>
                        </a>
                        <a href="{{ route('contact') }}" class="dq-card">
                            <span class="dq-icon" style="background:#fef3c7;color:#d97706"><i class="fas fa-headset"></i></span>
                            <div>
                                <h5>Support</h5>
                                <p>24/7 Help center</p>
                            </div>
                            <i class="fas fa-chevron-right dq-arrow"></i>
                        </a>
                    </div>

                    <div class="dash-section-title">
                        <h3><i class="fas fa-clock"></i> Recent Orders</h3>
                        <a href="#" onclick="switchDashTab('orders',document.querySelectorAll('.dash-nav-item')[1]);return false">View All <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="dash-table-wrap" id="recentOrdersWrap">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="recentOrdersBody"></tbody>
                        </table>
                        <div class="dash-empty" id="recentOrdersEmpty">
                            <i class="fas fa-shopping-bag"></i>
                            <h4>No orders yet</h4>
                            <p>Looks like you haven't placed any orders. Start exploring our products!</p>
                            <a href="{{ route('all-products') }}" class="btn-order-lg">Start Shopping</a>
                        </div>
                    </div>
                </div>

                <!-- Orders Tab -->
                <div class="dash-tab" id="dashOrders">
                    <div class="dash-section-title">
                        <h3><i class="fas fa-shopping-bag"></i> My Orders</h3>
                        <div class="dash-filter-chips">
                            <button class="dfc active" onclick="dashFilterOrders('all',this)">All</button>
                            <button class="dfc" onclick="dashFilterOrders('processing',this)">Processing</button>
                            <button class="dfc" onclick="dashFilterOrders('shipped',this)">Shipped</button>
                            <button class="dfc" onclick="dashFilterOrders('delivered',this)">Delivered</button>
                        </div>
                    </div>
                    <div class="dash-table-wrap">
                        <table class="dash-table">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="ordersBody"></tbody>
                        </table>
                        <div class="dash-empty" id="ordersEmpty">
                            <i class="fas fa-shopping-bag"></i>
                            <h4>No orders yet</h4>
                            <p>Your order history will appear here once you make a purchase.</p>
                            <a href="{{ route('all-products') }}" class="btn-order-lg">Start Shopping</a>
                        </div>
                    </div>
                </div>

                <!-- Wishlist Tab -->
                <div class="dash-tab" id="dashWishlist">
                    <div class="dash-section-title">
                        <h3><i class="far fa-heart"></i> My Wishlist</h3>
                        <a href="{{ route('wishlist') }}">Full View <i class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="dash-wishlist-grid" id="dashWishlistGrid"></div>
                    <div class="dash-empty" id="dashWishlistEmpty" style="display:none">
                        <i class="far fa-heart"></i>
                        <h4>Your wishlist is empty</h4>
                        <p>Save your favorite products and shop them anytime.</p>
                        <a href="{{ route('all-products') }}" class="btn-order-lg">Browse Products</a>
                    </div>
                </div>

                <!-- Settings Tab -->
                <div class="dash-tab" id="dashSettings">
                    <div class="dash-section-title">
                        <h3><i class="fas fa-cog"></i> Account Settings</h3>
                    </div>
                    <div class="dash-settings-grid">
                        <div class="dash-card">
                            <div class="dash-card-head">
                                <h4><i class="fas fa-user-edit"></i> Profile Information</h4>
                                <span class="dash-card-tag">Personal</span>
                            </div>
                            <form class="dash-form" onsubmit="return updateProfile(event)">
                                <div class="form-row-2">
                                    <div class="form-group">
                                        <label for="dashFirst">First Name</label>
                                        <input type="text" id="dashFirst" placeholder="First name" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="dashLast">Last Name</label>
                                        <input type="text" id="dashLast" placeholder="Last name" required>
                                    </div>
                                </div>
                                <div class="form-row-2">
                                    <div class="form-group">
                                        <label for="dashEmail">Email Address</label>
                                        <input type="email" id="dashEmail" placeholder="Email address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="dashPhone">Phone Number</label>
                                        <input type="tel" id="dashPhone" placeholder="Phone number">
                                    </div>
                                </div>
                                <button type="submit" class="btn-auth"><i class="fas fa-save"></i> Save Changes</button>
                            </form>
                        </div>

                        <div class="dash-card">
                            <div class="dash-card-head">
                                <h4><i class="fas fa-lock"></i> Change Password</h4>
                                <span class="dash-card-tag tag-red">Security</span>
                            </div>
                            <form class="dash-form" onsubmit="return changePassword(event)">
                                <div class="form-group">
                                    <label for="dashCurrentPass">Current Password</label>
                                    <div class="password-wrap">
                                        <input type="password" id="dashCurrentPass" placeholder="Enter current password" required>
                                        <button type="button" class="toggle-pass" onclick="togglePass('dashCurrentPass',this)"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dashNewPass">New Password</label>
                                    <div class="password-wrap">
                                        <input type="password" id="dashNewPass" placeholder="Enter new password" required>
                                        <button type="button" class="toggle-pass" onclick="togglePass('dashNewPass',this)"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="dashConfirmPass">Confirm New Password</label>
                                    <div class="password-wrap">
                                        <input type="password" id="dashConfirmPass" placeholder="Confirm new password" required>
                                        <button type="button" class="toggle-pass" onclick="togglePass('dashConfirmPass',this)"><i class="far fa-eye"></i></button>
                                    </div>
                                </div>
                                <button type="submit" class="btn-auth"><i class="fas fa-key"></i> Update Password</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    window.NF_PRODUCTS = @json($products);
    window.NF_CSRF = @json(csrf_token());
    window.NF_DASHBOARD_DATA_URL    = @json(route('dashboard.data'));
    window.NF_DASHBOARD_PROFILE_URL = @json(route('dashboard.profile'));
    window.NF_ORDER_COMPLETE_URL    = @json(route('order-complete'));
</script>
@endsection
