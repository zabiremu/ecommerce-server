<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\UnitController as AdminUnitController;
use App\Http\Controllers\Admin\SupplierController as AdminSupplierController;
use App\Http\Controllers\Admin\WarehouseController as AdminWarehouseController;
use App\Http\Controllers\Admin\PurchaseController as AdminPurchaseController;
use App\Http\Controllers\Admin\GRNController as AdminGRNController;
use App\Http\Controllers\Admin\GRNReturnController as AdminGRNReturnController;
use App\Http\Controllers\Admin\SteadfastController as AdminSteadfastController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\StockTransferController as AdminStockTransferController;
use App\Http\Controllers\Admin\StockAdjustmentController as AdminStockAdjustmentController;
use App\Http\Controllers\Admin\StockReportController as AdminStockReportController;
use App\Http\Controllers\Admin\PhoneBlacklistController as AdminPhoneBlacklistController;
use App\Http\Controllers\Admin\SalesReportController as AdminSalesReportController;
use App\Http\Controllers\Admin\PurchaseReportController as AdminPurchaseReportController;
use App\Http\Controllers\Admin\CustomerReportController as AdminCustomerReportController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\SiteSettingController as AdminSiteSettingController;
use App\Http\Controllers\Admin\SliderController as AdminSliderController;
use App\Http\Controllers\Admin\TrustItemController as AdminTrustItemController;
use App\Http\Controllers\Admin\DealsBannerController as AdminDealsBannerController;
use App\Http\Controllers\Admin\AboutPageController as AdminAboutPageController;
use App\Http\Controllers\Frontend\HomePageController;
use App\Http\Controllers\Frontend\OrderController as FrontendOrderController;
use App\Http\Controllers\Frontend\CartSyncController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\UddoktaPayController;
use App\Http\Controllers\Admin\AbandonedCartController as AdminAbandonedCartController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\RoleController as AdminRoleController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminSearchController;
use App\Http\Controllers\Admin\LandingPageController as AdminLandingPageController;
use App\Http\Controllers\Frontend\LandingPageController as FrontendLandingPageController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::view('/product-detail', 'Frontend.product-details');
Route::get('/', [HomePageController::class, 'index'])->name('home');
Route::get('/about', [HomePageController::class, 'about'])->name('about');
Route::get('/all-products', [HomePageController::class, 'allProducts'])->name('all-products');
Route::get('/cart', [HomePageController::class, 'cart'])->name('cart');
Route::get('/category-products', [HomePageController::class, 'categoryProducts'])->name('category-products');
Route::get('/checkout', [HomePageController::class, 'checkout'])->name('checkout');
Route::post('/orders', [FrontendOrderController::class, 'store'])->name('orders.store');
Route::post('/cart/sync', [CartSyncController::class, 'sync'])->name('cart.sync');
Route::post('/cart/contact', [CartSyncController::class, 'contact'])->name('cart.contact');
Route::post('/api/steadfast/webhook', [AdminSteadfastController::class, 'webhook'])->name('steadfast.webhook')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/uddoktapay/callback', [UddoktaPayController::class, 'callback'])->name('uddoktapay.callback');
Route::get('/uddoktapay/cancel',   [UddoktaPayController::class, 'cancel'])->name('uddoktapay.cancel');
Route::post('/uddoktapay/webhook', [UddoktaPayController::class, 'webhook'])->name('uddoktapay.webhook')->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');
Route::post('/contact', [HomePageController::class, 'contactStore'])->name('contact.store');
Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [HomePageController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard/data', [HomePageController::class, 'dashboardData'])->name('dashboard.data');
    Route::put('/dashboard/profile', [HomePageController::class, 'dashboardUpdateProfile'])->name('dashboard.profile');
});


Route::get('/forgot-password', [HomePageController::class, 'forgotPassword'])->name('forgot-password');
Route::get('/login', [HomePageController::class, 'login'])->name('login');
Route::post('/login', [HomePageController::class, 'loginSubmit'])->name('login.submit');
Route::post('/logout', [HomePageController::class, 'logoutCustomer'])->name('logout');
Route::get('/order-complete', [HomePageController::class, 'orderComplete'])->name('order-complete');
Route::get('/privacy-policy', [HomePageController::class, 'privacyPolicy'])->name('privacy-policy');
Route::get('/product-details', [HomePageController::class, 'productDetails'])->name('product-details');
Route::post('/product-reviews', [ReviewController::class, 'store'])->name('product-reviews.store');
Route::get('/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'store'])->name('newsletter.subscribe');
Route::get('/refund-policy', [HomePageController::class, 'refundPolicy'])->name('refund-policy');
Route::get('/register', [HomePageController::class, 'register'])->name('register');
Route::post('/register', [HomePageController::class, 'registerSubmit'])->name('register.submit');
Route::get('/reset-password', [HomePageController::class, 'resetPassword'])->name('reset-password');
Route::get('/terms-conditions', [HomePageController::class, 'termsConditions'])->name('terms-conditions');
Route::get('/track-order', [HomePageController::class, 'trackOrder'])->name('track-order');
Route::get('/track-order/lookup', [HomePageController::class, 'trackOrderLookup'])->name('track-order.lookup');
Route::get('/wishlist', [HomePageController::class, 'wishlist'])->name('wishlist');
Route::get('/lp/{slug}', [FrontendLandingPageController::class, 'show'])->name('landing-page');
Route::post('/lp/{slug}/order', [FrontendLandingPageController::class, 'order'])->name('landing.order');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
        Route::get('/forgot-password', [AdminLoginController::class, 'showForgotPasswordForm'])->name('forgot-password');
        Route::post('/forgot-password', [AdminLoginController::class, 'sendResetLink'])->name('forgot-password.submit');
    });

    Route::middleware(['auth:admin', 'admin.permission'])->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/live-visitors', [AdminDashboardController::class, 'liveVisitors'])->name('live-visitors');
        Route::get('/visitor-stats', [AdminDashboardController::class, 'visitorStats'])->name('visitor-stats');
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');

        // Notifications
        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('notifications.index');
        Route::post('/notifications/mark-all-read', [AdminNotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
        Route::post('/notifications/{notification}/read', [AdminNotificationController::class, 'markRead'])->name('notifications.read');

        // Global search
        Route::get('/search', [AdminSearchController::class, 'search'])->name('search');

        Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::get('/change-password', [AdminProfileController::class, 'showChangePasswordForm'])->name('change-password');
        Route::put('/change-password', [AdminProfileController::class, 'updatePassword'])->name('password.update');

        Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
        Route::patch('/categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');

        Route::get('/brands', [AdminBrandController::class, 'index'])->name('brands.index');
        Route::post('/brands', [AdminBrandController::class, 'store'])->name('brands.store');
        Route::put('/brands/{brand}', [AdminBrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [AdminBrandController::class, 'destroy'])->name('brands.destroy');
        Route::patch('/brands/{brand}/toggle-status', [AdminBrandController::class, 'toggleStatus'])->name('brands.toggle-status');

        Route::get('/units', [AdminUnitController::class, 'index'])->name('units.index');
        Route::post('/units', [AdminUnitController::class, 'store'])->name('units.store');
        Route::put('/units/{unit}', [AdminUnitController::class, 'update'])->name('units.update');
        Route::delete('/units/{unit}', [AdminUnitController::class, 'destroy'])->name('units.destroy');
        Route::patch('/units/{unit}/toggle-status', [AdminUnitController::class, 'toggleStatus'])->name('units.toggle-status');

        Route::get('/suppliers', [AdminSupplierController::class, 'index'])->name('suppliers.index');
        Route::post('/suppliers', [AdminSupplierController::class, 'store'])->name('suppliers.store');
        Route::put('/suppliers/{supplier}', [AdminSupplierController::class, 'update'])->name('suppliers.update');
        Route::delete('/suppliers/{supplier}', [AdminSupplierController::class, 'destroy'])->name('suppliers.destroy');
        Route::patch('/suppliers/{supplier}/toggle-status', [AdminSupplierController::class, 'toggleStatus'])->name('suppliers.toggle-status');

        Route::get('/warehouses', [AdminWarehouseController::class, 'index'])->name('warehouses.index');
        Route::post('/warehouses', [AdminWarehouseController::class, 'store'])->name('warehouses.store');
        Route::put('/warehouses/{warehouse}', [AdminWarehouseController::class, 'update'])->name('warehouses.update');
        Route::delete('/warehouses/{warehouse}', [AdminWarehouseController::class, 'destroy'])->name('warehouses.destroy');
        Route::patch('/warehouses/{warehouse}/toggle-status', [AdminWarehouseController::class, 'toggleStatus'])->name('warehouses.toggle-status');

        Route::get('/purchases', [AdminPurchaseController::class, 'index'])->name('purchases.index');
        Route::get('/purchases/create', [AdminPurchaseController::class, 'create'])->name('purchases.create');
        Route::post('/purchases', [AdminPurchaseController::class, 'store'])->name('purchases.store');
        Route::get('/purchases/{purchase}', [AdminPurchaseController::class, 'show'])->name('purchases.show');
        Route::delete('/purchases/{purchase}', [AdminPurchaseController::class, 'destroy'])->name('purchases.destroy');
        Route::patch('/purchases/{purchase}/status', [AdminPurchaseController::class, 'updateStatus'])->name('purchases.status');

        Route::get('/grn', [AdminGRNController::class, 'index'])->name('grn.index');
        Route::get('/grn/create', [AdminGRNController::class, 'create'])->name('grn.create');
        Route::get('/grn/purchase/{purchase}/items', [AdminGRNController::class, 'getPurchaseItems'])->name('grn.purchase-items');
        Route::post('/grn', [AdminGRNController::class, 'store'])->name('grn.store');
        Route::get('/grn/{goodsReceivedNote}', [AdminGRNController::class, 'show'])->name('grn.show');
        Route::delete('/grn/{goodsReceivedNote}', [AdminGRNController::class, 'destroy'])->name('grn.destroy');

        Route::get('/grn-returns', [AdminGRNReturnController::class, 'index'])->name('grn-returns.index');
        Route::get('/grn-returns/create', [AdminGRNReturnController::class, 'create'])->name('grn-returns.create');
        Route::get('/grn-returns/grn/{goodsReceivedNote}/items', [AdminGRNReturnController::class, 'getGrnItems'])->name('grn-returns.grn-items');
        Route::post('/grn-returns', [AdminGRNReturnController::class, 'store'])->name('grn-returns.store');
        Route::get('/grn-returns/{grnReturn}', [AdminGRNReturnController::class, 'show'])->name('grn-returns.show');
        Route::delete('/grn-returns/{grnReturn}', [AdminGRNReturnController::class, 'destroy'])->name('grn-returns.destroy');

        Route::get('/products', [AdminProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
        Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
        Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
        Route::post('/products/{product}/set-status', [AdminProductController::class, 'setStatus'])->name('products.set-status');
        Route::post('/products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk-action');
        Route::get('/products/barcodes', [AdminProductController::class, 'printBarcodes'])->name('products.barcodes');
        Route::get('/products/barcode-image/{code}', [AdminProductController::class, 'barcodeImage'])->name('products.barcode-image');
        Route::get('/products/{product}/gallery-delete/{index}', [AdminProductController::class, 'deleteGalleryImage'])->name('products.gallery-delete');
        Route::post('/products/{product}/gallery-color/{index}', [AdminProductController::class, 'updateGalleryColor'])->name('products.gallery-color');
        Route::get('/products/{product}/landing', [AdminLandingPageController::class, 'edit'])->name('products.landing.edit');
        Route::post('/products/{product}/landing', [AdminLandingPageController::class, 'update'])->name('products.landing.update');

        // Landing pages (block builder) — list + create on top of the per-product builder above
        Route::get('/landings', [AdminLandingPageController::class, 'index'])->name('landings.index');
        Route::get('/landings/create', [AdminLandingPageController::class, 'create'])->name('landings.create');
        Route::post('/landings', [AdminLandingPageController::class, 'store'])->name('landings.store');
        Route::delete('/landings/{landing}', [AdminLandingPageController::class, 'destroy'])->name('landings.destroy');

        Route::get('/stock-transfers', [AdminStockTransferController::class, 'index'])->name('stock-transfers.index');
        Route::get('/stock-transfers/create', [AdminStockTransferController::class, 'create'])->name('stock-transfers.create');
        Route::post('/stock-transfers', [AdminStockTransferController::class, 'store'])->name('stock-transfers.store');
        Route::get('/stock-transfers/{stockTransfer}', [AdminStockTransferController::class, 'show'])->name('stock-transfers.show');
        Route::delete('/stock-transfers/{stockTransfer}', [AdminStockTransferController::class, 'destroy'])->name('stock-transfers.destroy');
        Route::patch('/stock-transfers/{stockTransfer}/status', [AdminStockTransferController::class, 'updateStatus'])->name('stock-transfers.status');
        Route::get('/stock-transfers/product-stock/{productId}/{warehouseId}', [AdminStockTransferController::class, 'getProductStock'])->name('stock-transfers.product-stock');

        Route::get('/stock-adjustments', [AdminStockAdjustmentController::class, 'index'])->name('stock-adjustments.index');
        Route::get('/stock-adjustments/create', [AdminStockAdjustmentController::class, 'create'])->name('stock-adjustments.create');
        Route::post('/stock-adjustments', [AdminStockAdjustmentController::class, 'store'])->name('stock-adjustments.store');
        Route::get('/stock-adjustments/{stockAdjustment}', [AdminStockAdjustmentController::class, 'show'])->name('stock-adjustments.show');
        Route::delete('/stock-adjustments/{stockAdjustment}', [AdminStockAdjustmentController::class, 'destroy'])->name('stock-adjustments.destroy');
        Route::get('/stock-adjustments/product-stock/{productId}/{warehouseId}', [AdminStockAdjustmentController::class, 'getProductStock'])->name('stock-adjustments.product-stock');

        Route::get('/stock-report', [AdminStockReportController::class, 'index'])->name('stock-report.index');
        Route::get('/sales-report', [AdminSalesReportController::class, 'index'])->name('sales-report.index');
        Route::get('/purchase-report', [AdminPurchaseReportController::class, 'index'])->name('purchase-report.index');
        Route::get('/customer-report', [AdminCustomerReportController::class, 'index'])->name('customer-report.index');

        // Steadfast courier
        Route::post('/steadfast/{order}/send', [AdminSteadfastController::class, 'send'])->name('steadfast.send');
        Route::post('/steadfast/{order}/check-status', [AdminSteadfastController::class, 'checkStatus'])->name('steadfast.check-status');
        Route::get('/steadfast/balance', [AdminSteadfastController::class, 'balance'])->name('steadfast.balance');

        // Orders
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::post('/orders/bulk-action', [AdminOrderController::class, 'bulkAction'])->name('orders.bulk-action');
        Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
        Route::patch('/orders/{order}/payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.payment-status');
        Route::patch('/orders/{order}/notes', [AdminOrderController::class, 'updateNotes'])->name('orders.notes');
        Route::delete('/orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('/orders/{order}/bdcourier-check', [AdminOrderController::class, 'bdcourierCheck'])->name('orders.bdcourier-check');

        // Customers
        Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
        Route::get('/customers/{customer}', [AdminCustomerController::class, 'show'])->name('customers.show');
        Route::put('/customers/{customer}', [AdminCustomerController::class, 'update'])->name('customers.update');
        Route::patch('/customers/{customer}/toggle-status', [AdminCustomerController::class, 'toggleStatus'])->name('customers.toggle-status');
        Route::delete('/customers/{customer}', [AdminCustomerController::class, 'destroy'])->name('customers.destroy');

        // Sliders
        Route::get('/sliders', [AdminSliderController::class, 'index'])->name('sliders.index');
        Route::get('/sliders/create', [AdminSliderController::class, 'create'])->name('sliders.create');
        Route::post('/sliders', [AdminSliderController::class, 'store'])->name('sliders.store');
        Route::get('/sliders/{slider}/edit', [AdminSliderController::class, 'edit'])->name('sliders.edit');
        Route::put('/sliders/{slider}', [AdminSliderController::class, 'update'])->name('sliders.update');
        Route::patch('/sliders/{slider}/toggle-status', [AdminSliderController::class, 'toggleStatus'])->name('sliders.toggle-status');
        Route::delete('/sliders/{slider}', [AdminSliderController::class, 'destroy'])->name('sliders.destroy');

        // Trust Bar
        Route::get('/trust-items', [AdminTrustItemController::class, 'index'])->name('trust-items.index');
        Route::post('/trust-items', [AdminTrustItemController::class, 'store'])->name('trust-items.store');
        Route::put('/trust-items/{trustItem}', [AdminTrustItemController::class, 'update'])->name('trust-items.update');
        Route::delete('/trust-items/{trustItem}', [AdminTrustItemController::class, 'destroy'])->name('trust-items.destroy');
        Route::patch('/trust-items/{trustItem}/toggle-status', [AdminTrustItemController::class, 'toggleStatus'])->name('trust-items.toggle-status');

        // Deals Banner
        Route::get('/deals-banner', [AdminDealsBannerController::class, 'edit'])->name('deals-banner.edit');
        Route::put('/deals-banner', [AdminDealsBannerController::class, 'update'])->name('deals-banner.update');

        // About Page
        Route::get('/about-page', [AdminAboutPageController::class, 'edit'])->name('about-page.edit');

        // Site Settings
        Route::resource('/roles', AdminRoleController::class)->names('roles');
        Route::resource('/admins', AdminUserController::class)->names('admins');

        Route::get('/site-settings', [AdminSiteSettingController::class, 'edit'])->name('site-settings.edit');
        Route::put('/site-settings', [AdminSiteSettingController::class, 'update'])->name('site-settings.update');
        Route::post('/site-settings/test-email', [AdminSiteSettingController::class, 'sendTestEmail'])->name('site-settings.test-email');

        // Pages (Privacy Policy, Terms, Refund Policy)
        Route::get('/pages', [AdminPageController::class, 'index'])->name('pages.index');
        Route::get('/pages/{page}/edit', [AdminPageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/{page}', [AdminPageController::class, 'update'])->name('pages.update');

        // Contact Messages
        Route::get('/contact-messages', [AdminContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::post('/contact-messages/bulk-action', [AdminContactMessageController::class, 'bulkAction'])->name('contact-messages.bulk-action');
        Route::get('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::patch('/contact-messages/{contactMessage}/status', [AdminContactMessageController::class, 'updateStatus'])->name('contact-messages.status');
        Route::delete('/contact-messages/{contactMessage}', [AdminContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

        // Abandoned Carts
        Route::get('/abandoned-carts', [AdminAbandonedCartController::class, 'index'])->name('abandoned-carts.index');
        Route::get('/abandoned-carts/{cart}', [AdminAbandonedCartController::class, 'show'])->name('abandoned-carts.show');
        Route::delete('/abandoned-carts/{cart}', [AdminAbandonedCartController::class, 'destroy'])->name('abandoned-carts.destroy');

        // Phone Blacklist
        Route::get('/phone-blacklist', [AdminPhoneBlacklistController::class, 'index'])->name('phone-blacklist.index');
        Route::post('/phone-blacklist', [AdminPhoneBlacklistController::class, 'store'])->name('phone-blacklist.store');
        Route::delete('/phone-blacklist/{phoneBlacklist}', [AdminPhoneBlacklistController::class, 'destroy'])->name('phone-blacklist.destroy');
        Route::post('/phone-blacklist/block-from-order', [AdminPhoneBlacklistController::class, 'blockFromOrder'])->name('phone-blacklist.block-from-order');

        // Coupons
        Route::get('/coupons', [AdminCouponController::class, 'index'])->name('coupons.index');
        Route::get('/coupons/create', [AdminCouponController::class, 'create'])->name('coupons.create');
        Route::get('/coupons/generate-code', [AdminCouponController::class, 'generateCode'])->name('coupons.generate-code');
        Route::post('/coupons', [AdminCouponController::class, 'store'])->name('coupons.store');
        Route::get('/coupons/{coupon}/edit', [AdminCouponController::class, 'edit'])->name('coupons.edit');
        Route::put('/coupons/{coupon}', [AdminCouponController::class, 'update'])->name('coupons.update');
        Route::patch('/coupons/{coupon}/toggle-status', [AdminCouponController::class, 'toggleStatus'])->name('coupons.toggle-status');
        Route::delete('/coupons/{coupon}', [AdminCouponController::class, 'destroy'])->name('coupons.destroy');
    });
});

Route::get('/run-migrations', function () {

    Artisan::call('migrate', ['--force' => true]);

    return '<pre>'.e(Artisan::output()).'</pre>';
});
