<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        // Top-level apparel categories (shown on homepage "Shop by Category")
        $apparel = [
            ['T-Shirt',           'fas fa-shirt'],
            ['Polo T-Shirt',      'fas fa-shirt'],
            ['Shirt',             'fas fa-shirt'],
            ['Boxy Shirt',        'fas fa-shirt'],
            ['Jeans',             'fas fa-vest'],
            ['Baggy Jeans',       'fas fa-vest'],
            ['Semi Baggy Jeans',  'fas fa-vest'],
            ['Cargo Pant',        'fas fa-vest'],
            ['Formal Pant',       'fas fa-vest'],
            ['Chino Pant',        'fas fa-vest'],
            ['Shorts',            'fas fa-vest'],
        ];

        // Footwear (parent, shown on homepage) + its sub-categories (not shown on homepage)
        $footwearChildren = [
            ['Sneakers',      'fas fa-shoe-prints'],
            ['Formal Shoes',  'fas fa-shoe-prints'],
            ['Boots',         'fas fa-shoe-prints'],
            ['Slides',        'fas fa-shoe-prints'],
            ['Slippers',      'fas fa-shoe-prints'],
            ['Running Shoes', 'fas fa-person-running'],
            ['Sports Shoes',  'fas fa-dumbbell'],
            ['Loafers',       'fas fa-shoe-prints'],
        ];

        // Special Sections (parent, shown on homepage) + its sub-categories (not shown on homepage)
        $specialChildren = [
            ['New Arrival',        'fas fa-fire-flame-curved'],
            ['Best Seller',        'fas fa-star'],
            ['Premium Collection', 'fas fa-gem'],
            ['Flash Sale',         'fas fa-bolt'],
            ['Combo Offer',        'fas fa-gift'],
            ['Restock',            'fas fa-rotate-left'],
            ['Clearance',          'fas fa-tags'],
        ];

        $order = 0;
        $now = now();
        $insertTopLevel = function (string $name, string $icon, bool $homeVisible) use (&$order, $now) {
            $slug = Str::slug($name);
            DB::table('categories')->insert([
                'name'         => $name,
                'slug'         => $slug,
                'icon'         => $icon,
                'parent_id'    => null,
                'status'       => true,
                'home_visible' => $homeVisible,
                'home_order'   => $order++,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]);
            return DB::table('categories')->where('slug', $slug)->value('id');
        };

        foreach ($apparel as [$name, $icon]) {
            $insertTopLevel($name, $icon, true);
        }

        $footwearId = $insertTopLevel('Footwear', 'fas fa-shoe-prints', true);
        foreach ($footwearChildren as [$name, $icon]) {
            $slug = Str::slug($name);
            DB::table('categories')->insert([
                'name'         => $name,
                'slug'         => $slug,
                'icon'         => $icon,
                'parent_id'    => $footwearId,
                'status'       => true,
                'home_visible' => false,
                'home_order'   => 0,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]);
        }

        $specialId = $insertTopLevel('Special Sections', 'fas fa-star', true);
        foreach ($specialChildren as [$name, $icon]) {
            $slug = Str::slug($name);
            DB::table('categories')->insert([
                'name'         => $name,
                'slug'         => $slug,
                'icon'         => $icon,
                'parent_id'    => $specialId,
                'status'       => true,
                'home_visible' => false,
                'home_order'   => 0,
                'created_at'   => $now,
                'updated_at'   => $now,
            ]);
        }

        // The old placeholder categories ("What is Lorem Ipsum?", "Easy Mart",
        // "Malcolm Mcintosh", "Sierra Moran") are leftover demo data. A handful
        // of leftover demo products still reference them and category_id cascade-
        // deletes on the products table, so re-point those products at the new
        // "T-Shirt" category first (not a real fit for all of them, but keeps
        // the products — and the real orders referencing them — intact) before
        // removing the old categories.
        $fallbackCategoryId = DB::table('categories')->where('slug', 't-shirt')->value('id');

        DB::table('products')
            ->whereIn('category_id', function ($q) {
                $q->select('id')->from('categories')
                    ->whereIn('name', ['What is Lorem Ipsum?', 'Easy Mart', 'Malcolm Mcintosh', 'Sierra Moran']);
            })
            ->update(['category_id' => $fallbackCategoryId]);

        DB::table('categories')
            ->whereIn('name', ['What is Lorem Ipsum?', 'Easy Mart', 'Malcolm Mcintosh', 'Sierra Moran'])
            ->delete();
    }

    public function down(): void
    {
        $names = [
            'T-Shirt', 'Polo T-Shirt', 'Shirt', 'Boxy Shirt', 'Jeans', 'Baggy Jeans',
            'Semi Baggy Jeans', 'Cargo Pant', 'Formal Pant', 'Chino Pant', 'Shorts',
            'Footwear', 'Sneakers', 'Formal Shoes', 'Boots', 'Slides', 'Slippers',
            'Running Shoes', 'Sports Shoes', 'Loafers',
            'Special Sections', 'New Arrival', 'Best Seller', 'Premium Collection',
            'Flash Sale', 'Combo Offer', 'Restock', 'Clearance',
        ];

        DB::table('categories')->whereIn('name', $names)->delete();
    }
};
