<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            // Electronics & Mobile
            'Samsung',
            'Apple',
            'Xiaomi',
            'Realme',
            'Oppo',
            'Vivo',
            'OnePlus',
            'Huawei',
            'Nokia',
            'Sony',
            'LG',
            'Lenovo',
            'HP',
            'Dell',
            'Asus',
            'Acer',

            // Audio / Accessories
            'JBL',
            'Boat',
            'Anker',
            'Baseus',
            'Remax',
            'Havit',
            'Logitech',

            // Beauty & Personal Care
            'Lakme',
            'Maybelline',
            'Loreal',
            'Nivea',
            'Pond\'s',
            'Olay',
            'Garnier',
            'Himalaya',
            'Dove',
            'Sunsilk',
            'Pantene',
            'Head & Shoulders',

            // Home Appliances
            'Panasonic',
            'Philips',
            'Walton',
            'Vision',
            'Singer',
            'Miyako',
            'Sharp',
            'Whirlpool',

            // Fashion / Lifestyle
            'Nike',
            'Adidas',
            'Puma',
            'Reebok',
            'Bata',
            'Apex',
            'Lotto',
            'Lee Cooper',
            'Levi\'s',
            'H&M',
            'Zara',

            // Watches & Accessories
            'Casio',
            'Titan',
            'Fossil',
            'Rolex',
            'Ray-Ban',

            // Local / Bangladeshi
            'Pran',
            'Aarong',
            'Yellow',
            'Kay Kraft',
            'Sailor',
            'Ecstasy',
            'Le Reve',

            // Fragrance
            'Al Rehab',
            'Ajmal',
            'Lattafa',
            'Oudh Al Anfar',
            'Surrati',

            // Others
            'Tupperware',
            'IKEA',
            'Prestige',
            'Hawkins',
        ];

        foreach ($brands as $name) {
            Brand::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'status' => true,
                ]
            );
        }

        $total = Brand::count();
        $this->command->info("Brands seeded successfully. Total: {$total}");
    }
}
