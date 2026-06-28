<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\SiteSetting;
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
    }
}
