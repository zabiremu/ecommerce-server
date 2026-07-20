<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\SiteSetting;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('Frontend.Layout.partials.header', function ($view) {
            $view->with('headerCategories', Category::where('status', true)
                ->whereNull('parent_id')
                ->withCount(['products' => fn ($q) => $q->where('publish_status', 'published')])
                ->orderBy('name')
                ->get(['id', 'name', 'slug', 'icon']));
        });

        View::composer('Frontend.Layout.partials.footer', function ($view) {
            $view->with('footerCategories', Category::where('status', true)
                ->whereNull('parent_id')
                ->withCount(['products' => fn ($q) => $q->where('publish_status', 'published')])
                ->orderByDesc('products_count')
                ->orderBy('name')
                ->limit(6)
                ->get(['id', 'name', 'slug', 'icon']));
        });

        if (Schema::hasTable('site_settings')) {
            View::share('siteSettings', SiteSetting::all_indexed());
        } else {
            View::share('siteSettings', []);
        }

        View::composer('Frontend.Layout.app', function ($view) {
            $today = Carbon::today();

            $coupon = Coupon::active()
                ->where(function ($q) use ($today) {
                    $q->whereNull('starts_at')->orWhere('starts_at', '<=', $today);
                })
                ->where(function ($q) use ($today) {
                    $q->whereNull('expires_at')->orWhere('expires_at', '>=', $today);
                })
                ->where(function ($q) {
                    $q->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit');
                })
                ->orderByDesc('amount')
                ->first();

            $view->with('popupCoupon', $coupon);
        });
    }
}
