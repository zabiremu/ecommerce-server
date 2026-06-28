<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\NewContactMessage;
use App\Services\MailConfigService;
use App\Models\Category;
use App\Models\ContactMessage;
use App\Models\Customer;
use App\Models\DealsBanner;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Page;
use App\Models\SiteSetting;
use App\Models\Slider;
use App\Models\TrustItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class HomePageController extends Controller
{
    public function index()
    {
        $sliders = Slider::active()->orderBy('sort_order')->orderByDesc('id')->get();
        $trustItems = TrustItem::active()->orderBy('sort_order')->orderByDesc('id')->get();
        $homeCategories = Category::where('status', true)
            ->where('home_visible', true)
            ->withCount(['products' => fn ($q) => $q->where('publish_status', 'published')])
            ->orderBy('home_order')
            ->orderBy('name')
            ->get();
        $latestProducts = Product::published()->orderByDesc('id')->limit(8)->get();
        $allProducts = Product::published()->orderByDesc('id')->limit(8)->get();
        $dealsBanner = DealsBanner::where('status', true)->first();
        return view('Frontend.home', compact('sliders', 'trustItems', 'homeCategories', 'latestProducts', 'allProducts', 'dealsBanner'));
    }

    public function about()
    {
        $page = Page::findBySlug('about');

        return view('Frontend.about', compact('page'));
    }

    public function allProducts()
    {
        $products = $this->publishedProductsForJs();

        $filterCategories = Category::where('status', true)
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return view('Frontend.all-products', compact('products', 'filterCategories'));
    }

    protected function publishedProductsForJs()
    {
        return Product::published()
            ->with('category:id,slug')
            ->orderByDesc('id')
            ->get()
            ->map(function (Product $p) {
                $hasSale = $p->sale_price && $p->sale_price < $p->selling_price;
                return [
                    'id'    => $p->id,
                    'slug'  => $p->slug,
                    'img'   => $p->thumbnail ? Storage::url($p->thumbnail) : '',
                    'title' => $p->name,
                    'cur'   => (float) ($hasSale ? $p->sale_price : $p->selling_price),
                    'old'   => (float) $p->selling_price,
                    'stock' => (int) ($p->stock ?? 0),
                    'cat'   => $p->category?->slug ?? '',
                    'url'   => route('product-details') . '?slug=' . $p->slug,
                ];
            });
    }

    public function cart()
    {
        $products = $this->publishedProductsForJs();
        $today = \Carbon\Carbon::today();
        $coupons = \App\Models\Coupon::active()
            ->where(function ($q) use ($today) { $q->whereNull('starts_at')->orWhere('starts_at', '<=', $today); })
            ->where(function ($q) use ($today) { $q->whereNull('expires_at')->orWhere('expires_at', '>=', $today); })
            ->get()
            ->map(fn ($c) => [
                'code'              => $c->code,
                'type'              => $c->type,
                'amount'            => (float) $c->amount,
                'minimum_spend'     => $c->minimum_spend ? (float) $c->minimum_spend : 0,
                'maximum_discount'  => $c->maximum_discount ? (float) $c->maximum_discount : 0,
                'free_shipping'     => (bool) $c->free_shipping,
            ]);
        return view('Frontend.cart', compact('products', 'coupons'));
    }

    public function categoryProducts()
    {
        $products = $this->publishedProductsForJs();
        $categories = Category::where('status', true)
            ->get(['id', 'name', 'slug', 'icon'])
            ->map(fn ($c) => [
                'slug' => $c->slug,
                'name' => $c->name,
                'icon' => $c->icon ?: 'fa-tag',
            ]);

        return view('Frontend.category-products', compact('products', 'categories'));
    }

    public function checkout()
    {
        $products = $this->publishedProductsForJs();
        $today = \Carbon\Carbon::today();
        $coupons = \App\Models\Coupon::active()
            ->where(function ($q) use ($today) { $q->whereNull('starts_at')->orWhere('starts_at', '<=', $today); })
            ->where(function ($q) use ($today) { $q->whereNull('expires_at')->orWhere('expires_at', '>=', $today); })
            ->get()
            ->map(fn ($c) => [
                'code'              => $c->code,
                'type'              => $c->type,
                'amount'            => (float) $c->amount,
                'minimum_spend'     => $c->minimum_spend ? (float) $c->minimum_spend : 0,
                'maximum_discount'  => $c->maximum_discount ? (float) $c->maximum_discount : 0,
                'free_shipping'     => (bool) $c->free_shipping,
            ]);
        return view('Frontend.checkout', compact('products', 'coupons'));
    }

    public function contact()
    {
        return view('Frontend.contact');
    }

    public function contactStore(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        $msg = ContactMessage::create([
            'name'       => $data['name'],
            'email'      => $data['email'],
            'phone'      => $data['phone'] ?? null,
            'subject'    => $data['subject'] ?? null,
            'message'    => $data['message'],
            'status'     => 'new',
            'ip'         => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        $notifyEmail = SiteSetting::get('admin_notify_email') ?: SiteSetting::get('contact_email');
        if ($notifyEmail) {
            try {
                MailConfigService::apply();
                Mail::to($notifyEmail)->send(new NewContactMessage($msg));
            } catch (\Throwable $e) {
                Log::warning('Contact mail failed: ' . $e->getMessage());
            }
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Thanks! Your message has been received. We will get back to you shortly.',
            ]);
        }

        return back()->with('success', 'Your message has been sent.');
    }

    public function dashboard()
    {
        $products = $this->publishedProductsForJs();
        $authUser = Auth::guard('web')->user();
        return view('Frontend.dashboard', compact('products', 'authUser'));
    }

    public function dashboardData(Request $request)
    {
        $email = trim((string) $request->query('email', ''));
        $phone = trim((string) $request->query('phone', ''));

        $customer = null;
        if ($email !== '' || $phone !== '') {
            $customer = Customer::query()
                ->when($phone !== '', fn ($q) => $q->orWhere('phone', $phone))
                ->when($email !== '', fn ($q) => $q->orWhere('email', $email))
                ->first();
        }

        $ordersQuery = Order::with(['items'])->orderByDesc('placed_at')->orderByDesc('id');

        if ($customer) {
            $ordersQuery->where(function ($q) use ($customer, $email, $phone) {
                $q->where('customer_id', $customer->id);
                if ($email !== '') $q->orWhere('shipping_email', $email);
                if ($phone !== '') $q->orWhere('shipping_phone', $phone);
            });
        } elseif ($email !== '' || $phone !== '') {
            $ordersQuery->where(function ($q) use ($email, $phone) {
                if ($email !== '') $q->orWhere('shipping_email', $email);
                if ($phone !== '') $q->orWhere('shipping_phone', $phone);
            });
        } else {
            $ordersQuery->whereRaw('1 = 0');
        }

        $orders = $ordersQuery->get();

        $totalOrders = $orders->count();
        $totalSpent = $orders->filter(fn ($o) => $o->status !== 'cancelled')->sum('total');

        return response()->json([
            'success'  => true,
            'customer' => $customer ? [
                'id'            => $customer->id,
                'name'          => $customer->name,
                'email'         => $customer->email,
                'phone'         => $customer->phone,
                'address'       => $customer->address,
                'city'          => $customer->city,
                'area'          => $customer->area,
                'total_orders'  => (int) $customer->total_orders,
                'total_spent'   => (float) $customer->total_spent,
                'last_order_at' => optional($customer->last_order_at)->toDateTimeString(),
            ] : null,
            'orders' => $orders->map(function (Order $o) {
                return [
                    'id'             => $o->order_no,
                    'order_no'       => $o->order_no,
                    'date'           => optional($o->placed_at ?? $o->created_at)->format('M j, Y'),
                    'placed_at'      => optional($o->placed_at ?? $o->created_at)->toDateTimeString(),
                    'status'         => $o->status,
                    'payment_method' => $o->payment_method,
                    'payment_status' => $o->payment_status,
                    'subtotal'       => (float) $o->subtotal,
                    'shipping'       => (float) $o->shipping_charge,
                    'discount'       => (float) $o->discount,
                    'total'          => (float) $o->total,
                    'items'          => $o->items->map(fn ($i) => [
                        'product_id' => $i->product_id,
                        'name'       => $i->product_name,
                        'sku'        => $i->product_sku,
                        'qty'        => (float) $i->quantity,
                        'price'      => (float) $i->unit_price,
                        'total'      => (float) $i->total,
                        'thumbnail'  => $i->thumbnail ? Storage::url($i->thumbnail) : null,
                    ])->values(),
                ];
            })->values(),
            'stats' => [
                'total_orders' => $totalOrders,
                'total_spent'  => (float) $totalSpent,
            ],
        ]);
    }

    public function dashboardUpdateProfile(Request $request)
    {
        $data = $request->validate([
            'identifier_email' => 'nullable|email|max:255',
            'identifier_phone' => 'nullable|string|max:30',
            'name'             => 'required|string|max:255',
            'email'            => 'nullable|email|max:255',
            'phone'            => 'nullable|string|max:30',
        ]);

        if (empty($data['identifier_email']) && empty($data['identifier_phone'])) {
            return response()->json(['success' => false, 'message' => 'No identifier provided.'], 422);
        }

        $customer = Customer::query()
            ->when(!empty($data['identifier_phone']), fn ($q) => $q->orWhere('phone', $data['identifier_phone']))
            ->when(!empty($data['identifier_email']), fn ($q) => $q->orWhere('email', $data['identifier_email']))
            ->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'No customer record found yet. Place an order first to create one.',
            ], 404);
        }

        $customer->update([
            'name'  => $data['name'],
            'email' => $data['email'] ?? $customer->email,
            'phone' => $data['phone'] ?? $customer->phone,
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Profile updated.',
            'customer' => [
                'id'    => $customer->id,
                'name'  => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
            ],
        ]);
    }

    public function forgotPassword()
    {
        return view('Frontend.forgot-password');
    }

    public function login()
    {
        return view('Frontend.login');
    }

    /**
     * Single login form for both admins and customers.
     * Admins are sent to the admin dashboard; customers to their account dashboard.
     */
    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        if (Auth::guard('web')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ])->redirectTo(route('login'));
    }

    public function logoutCustomer(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function orderComplete(Request $request)
    {
        $id = trim((string) $request->query('id', ''));
        $order = null;
        if ($id !== '') {
            $order = Order::with('items')->where('order_no', $id)->first();
        }
        return view('Frontend.order-complete', compact('order'));
    }

    public function privacyPolicy()
    {
        $page = Page::findBySlug('privacy-policy');
        return view('Frontend.privacy-policy', compact('page'));
    }

    public function productDetails(\Illuminate\Http\Request $request)
    {
        $query = Product::published()->with('category:id,name,slug', 'brand:id,name', 'variants');

        if ($slug = $request->query('slug')) {
            $product = $query->where('slug', $slug)->firstOrFail();
        } else {
            $product = $query->findOrFail((int) $request->query('id'));
        }

        $related = Product::published()
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->orderByDesc('id')
            ->limit(4)
            ->get();

        $reviews = ProductReview::approved()
            ->where('product_id', $product->id)
            ->latest()
            ->get();

        $avgRating  = $reviews->isNotEmpty() ? round($reviews->avg('rating'), 1) : 0;
        $totalReviews = $reviews->count();

        return view('Frontend.product-details', compact('product', 'related', 'reviews', 'avgRating', 'totalReviews'));
    }

    public function refundPolicy()
    {
        $page = Page::findBySlug('refund-policy');
        return view('Frontend.refund-policy', compact('page'));
    }

    public function register()
    {
        return view('Frontend.register');
    }

    public function registerSubmit(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|string|max:20',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => trim($data['first_name'].' '.$data['last_name']),
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => $data['password'],
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function resetPassword()
    {
        return view('Frontend.reset-password');
    }

    public function termsConditions()
    {
        $page = Page::findBySlug('terms-conditions');
        return view('Frontend.terms-conditions', compact('page'));
    }

    public function trackOrder()
    {
        return view('Frontend.track-order');
    }

    public function trackOrderLookup(Request $request)
    {
        $id = strtoupper(trim((string) $request->query('id', '')));
        if ($id === '') {
            return response()->json(['success' => false, 'message' => 'Order ID is required.'], 422);
        }

        $order = Order::with('items')->where('order_no', $id)->first();
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'No order found with that ID.'], 404);
        }

        $placedAt = $order->placed_at ?? $order->created_at;
        $updatedAt = $order->updated_at;

        $statusOrder = ['pending', 'confirmed', 'processing', 'shipped', 'delivered'];
        $isCancelled = in_array($order->status, ['cancelled', 'returned'], true);
        $currentIdx = $isCancelled ? -1 : array_search($order->status, $statusOrder, true);
        if ($currentIdx === false) $currentIdx = 0;

        $timelineSteps = [
            ['key' => 'pending',    'label' => 'Order Placed',      'icon' => 'fa-clipboard-check'],
            ['key' => 'confirmed',  'label' => 'Payment Confirmed', 'icon' => 'fa-credit-card'],
            ['key' => 'processing', 'label' => 'Processing',        'icon' => 'fa-box'],
            ['key' => 'shipped',    'label' => 'Shipped',           'icon' => 'fa-shipping-fast'],
            ['key' => 'delivered',  'label' => 'Out for Delivery',  'icon' => 'fa-truck'],
            ['key' => 'delivered',  'label' => 'Delivered',         'icon' => 'fa-home'],
        ];

        $timeline = [];
        foreach ($timelineSteps as $i => $step) {
            $done = false;
            $date = 'Pending';
            if ($isCancelled) {
                $done = ($i === 0);
                $date = $i === 0 ? optional($placedAt)->format('M j, Y, g:i A') : 'Cancelled';
            } else {
                $stepIdx = array_search($step['key'], $statusOrder, true);
                if ($stepIdx !== false && $stepIdx < $currentIdx) {
                    $done = true;
                    $date = $i === 0
                        ? optional($placedAt)->format('M j, Y, g:i A')
                        : optional($updatedAt)->format('M j, Y, g:i A');
                } elseif ($stepIdx === $currentIdx) {
                    if ($order->status === 'delivered' && $i === count($timelineSteps) - 1) {
                        $done = true;
                        $date = optional($updatedAt)->format('M j, Y, g:i A');
                    } elseif ($order->status === 'delivered' && $i === count($timelineSteps) - 2) {
                        $done = true;
                        $date = optional($updatedAt)->format('M j, Y, g:i A');
                    } else {
                        $done = ($i === 0);
                        $date = $i === 0 ? optional($placedAt)->format('M j, Y, g:i A') : 'In progress';
                    }
                }
            }
            $timeline[] = [
                'label' => $step['label'],
                'icon'  => $step['icon'],
                'done'  => $done,
                'date'  => $date,
            ];
        }

        $estimated = $placedAt
            ? $placedAt->copy()->addDays(in_array($order->status, ['delivered'], true) ? 0 : 5)->format('M j, Y')
            : null;

        $paymentLabels = [
            'cod'    => 'Cash on Delivery',
            'bkash'  => 'bKash',
            'nagad'  => 'Nagad',
            'rocket' => 'Rocket',
            'bank'   => 'Bank Transfer',
        ];

        return response()->json([
            'success' => true,
            'order' => [
                'id'             => $order->order_no,
                'date'           => optional($placedAt)->format('M j, Y'),
                'placed_at'      => optional($placedAt)->toDateTimeString(),
                'status'         => $order->status,
                'est'            => $estimated,
                'payment'        => $paymentLabels[$order->payment_method] ?? $order->payment_method,
                'payment_status' => $order->payment_status,
                'subtotal'       => (float) $order->subtotal,
                'shipping'       => (float) $order->shipping_charge,
                'discount'       => (float) $order->discount,
                'total'          => (float) $order->total,
                'address' => [
                    'name'  => $order->shipping_name,
                    'phone' => $order->shipping_phone,
                    'addr'  => $order->shipping_address,
                    'city'  => trim(($order->shipping_area ? $order->shipping_area . ', ' : '') . ($order->shipping_city ?? ''), ', '),
                ],
                'items' => $order->items->map(fn ($i) => [
                    'id'        => $i->product_id,
                    'title'     => $i->product_name,
                    'qty'       => (float) $i->quantity,
                    'price'     => (float) $i->unit_price,
                    'total'     => (float) $i->total,
                    'thumbnail' => $i->thumbnail ? Storage::url($i->thumbnail) : null,
                ])->values(),
                'timeline' => $timeline,
            ],
        ]);
    }

    public function wishlist()
    {
        $products = $this->publishedProductsForJs();
        return view('Frontend.wishlist', compact('products'));
    }
}
