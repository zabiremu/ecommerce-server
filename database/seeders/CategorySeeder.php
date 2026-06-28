<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Gadget & Electronics',
                'icon' => 'fa-microchip',
                'meta_title' => 'Gadget & Electronics — NF Shop 24',
                'meta_description' => 'Smartphones, accessories, smart watches, headphones and the latest gadgets at unbeatable prices.',
                'children' => [
                    ['name' => 'Mobile Accessories', 'icon' => 'fa-mobile-alt'],
                    ['name' => 'Smart Watches', 'icon' => 'fa-clock'],
                    ['name' => 'Headphones & Earbuds', 'icon' => 'fa-headphones'],
                    ['name' => 'Chargers & Cables', 'icon' => 'fa-plug'],
                    ['name' => 'Power Banks', 'icon' => 'fa-battery-full'],
                ],
            ],
            [
                'name' => 'Fashion & Lifestyle',
                'icon' => 'fa-tshirt',
                'meta_title' => 'Fashion & Lifestyle — NF Shop 24',
                'meta_description' => 'Trendy clothing, footwear, bags and lifestyle accessories for men, women and kids.',
                'children' => [
                    ['name' => "Men's Fashion", 'icon' => 'fa-male'],
                    ['name' => "Women's Fashion", 'icon' => 'fa-female'],
                    ['name' => 'Footwear', 'icon' => 'fa-shoe-prints'],
                    ['name' => 'Bags & Wallets', 'icon' => 'fa-shopping-bag'],
                    ['name' => 'Watches', 'icon' => 'fa-stopwatch'],
                ],
            ],
            [
                'name' => 'Health & Beauty',
                'icon' => 'fa-spa',
                'meta_title' => 'Health & Beauty — NF Shop 24',
                'meta_description' => 'Skin care, hair care, makeup, personal care, and wellness products for everyday beauty and health.',
                'children' => [
                    ['name' => 'Skin Care', 'icon' => 'fa-leaf'],
                    ['name' => 'Hair Care', 'icon' => 'fa-cut'],
                    ['name' => 'Makeup', 'icon' => 'fa-paint-brush'],
                    ['name' => 'Personal Care', 'icon' => 'fa-pump-soap'],
                    ['name' => 'Health Supplements', 'icon' => 'fa-pills'],
                ],
            ],
            [
                'name' => 'Toys, Kids & Baby',
                'icon' => 'fa-baby',
                'meta_title' => 'Toys, Kids & Baby — NF Shop 24',
                'meta_description' => 'Educational toys, baby essentials, kids clothing, diapers and feeding products.',
                'children' => [
                    ['name' => 'Educational Toys', 'icon' => 'fa-puzzle-piece'],
                    ['name' => 'Baby Care', 'icon' => 'fa-baby-carriage'],
                    ['name' => 'Kids Clothing', 'icon' => 'fa-tshirt'],
                    ['name' => 'Feeding & Nursing', 'icon' => 'fa-mug-hot'],
                ],
            ],
            [
                'name' => 'Kitchen',
                'icon' => 'fa-utensils',
                'meta_title' => 'Kitchen — NF Shop 24',
                'meta_description' => 'Cookware, storage containers, kitchen tools and appliances to make cooking easier and faster.',
                'children' => [
                    ['name' => 'Cookware', 'icon' => 'fa-fire'],
                    ['name' => 'Storage & Containers', 'icon' => 'fa-box'],
                    ['name' => 'Kitchen Tools', 'icon' => 'fa-blender'],
                    ['name' => 'Tableware', 'icon' => 'fa-wine-glass'],
                    ['name' => 'Small Appliances', 'icon' => 'fa-coffee'],
                ],
            ],
            [
                'name' => 'Accessories',
                'icon' => 'fa-glasses',
                'meta_title' => 'Accessories — NF Shop 24',
                'meta_description' => 'Sunglasses, jewelry, belts and everyday accessories to complete your look.',
                'children' => [
                    ['name' => 'Sunglasses', 'icon' => 'fa-glasses'],
                    ['name' => 'Jewelry', 'icon' => 'fa-gem'],
                    ['name' => 'Belts', 'icon' => 'fa-ellipsis-h'],
                    ['name' => 'Caps & Hats', 'icon' => 'fa-hat-cowboy'],
                ],
            ],
            [
                'name' => 'Attar & Fragrance',
                'icon' => 'fa-leaf',
                'meta_title' => 'Attar & Fragrance — NF Shop 24',
                'meta_description' => 'Premium attars, perfumes, body sprays and long-lasting fragrances.',
                'children' => [
                    ['name' => 'Attar', 'icon' => 'fa-leaf'],
                    ['name' => 'Perfume', 'icon' => 'fa-spray-can'],
                    ['name' => 'Body Spray', 'icon' => 'fa-wind'],
                ],
            ],
            [
                'name' => 'Cleaning Supplies',
                'icon' => 'fa-broom',
                'meta_title' => 'Cleaning Supplies — NF Shop 24',
                'meta_description' => 'Mops, brushes, detergents and cleaning tools for a spotless home.',
                'children' => [
                    ['name' => 'Mops & Brooms', 'icon' => 'fa-broom'],
                    ['name' => 'Detergents', 'icon' => 'fa-tint'],
                    ['name' => 'Brushes & Scrubbers', 'icon' => 'fa-hand-sparkles'],
                ],
            ],
            [
                'name' => 'Sports & Fitness',
                'icon' => 'fa-running',
                'meta_title' => 'Sports & Fitness — NF Shop 24',
                'meta_description' => 'Fitness equipment, sportswear, yoga mats and outdoor gear for an active lifestyle.',
                'children' => [
                    ['name' => 'Fitness Equipment', 'icon' => 'fa-dumbbell'],
                    ['name' => 'Sportswear', 'icon' => 'fa-tshirt'],
                    ['name' => 'Yoga & Pilates', 'icon' => 'fa-praying-hands'],
                ],
            ],
            [
                'name' => 'Home & Living',
                'icon' => 'fa-home',
                'meta_title' => 'Home & Living — NF Shop 24',
                'meta_description' => 'Home decor, bedding, storage and everything to upgrade your living space.',
                'children' => [
                    ['name' => 'Home Decor', 'icon' => 'fa-couch'],
                    ['name' => 'Bedding', 'icon' => 'fa-bed'],
                    ['name' => 'Lighting', 'icon' => 'fa-lightbulb'],
                    ['name' => 'Furniture', 'icon' => 'fa-chair'],
                ],
            ],
            [
                'name' => 'Books & Stationery',
                'icon' => 'fa-book',
                'meta_title' => 'Books & Stationery — NF Shop 24',
                'meta_description' => 'Best-selling books, notebooks, pens and office supplies.',
                'children' => [
                    ['name' => 'Novels', 'icon' => 'fa-book-open'],
                    ['name' => 'Notebooks & Diaries', 'icon' => 'fa-book'],
                    ['name' => 'Pens & Pencils', 'icon' => 'fa-pencil-alt'],
                ],
            ],
            [
                'name' => 'Automotive',
                'icon' => 'fa-car',
                'meta_title' => 'Automotive — NF Shop 24',
                'meta_description' => 'Car accessories, motorcycle parts, helmets and bike gear.',
                'children' => [
                    ['name' => 'Car Accessories', 'icon' => 'fa-car-side'],
                    ['name' => 'Motorcycle Parts', 'icon' => 'fa-motorcycle'],
                    ['name' => 'Helmets', 'icon' => 'fa-hard-hat'],
                ],
            ],
        ];

        foreach ($categories as $cat) {
            $parent = Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'icon' => $cat['icon'],
                    'meta_title' => $cat['meta_title'],
                    'meta_description' => $cat['meta_description'],
                    'parent_id' => null,
                    'status' => true,
                ]
            );

            foreach ($cat['children'] ?? [] as $child) {
                Category::updateOrCreate(
                    ['slug' => Str::slug($child['name'])],
                    [
                        'name' => $child['name'],
                        'icon' => $child['icon'],
                        'meta_title' => $child['name'] . ' — NF Shop 24',
                        'meta_description' => 'Browse a wide selection of ' . strtolower($child['name']) . ' at the best prices.',
                        'parent_id' => $parent->id,
                        'status' => true,
                    ]
                );
            }
        }

        $total = Category::count();
        $this->command->info("Categories seeded successfully. Total: {$total}");
    }
}
