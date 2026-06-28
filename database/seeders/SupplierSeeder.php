<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Rahim Uddin',
                'email' => 'rahim@dhakaelectronics.com',
                'phone' => '+8801712345601',
                'company' => 'Dhaka Electronics Hub',
                'address' => 'Stadium Market, Motijheel, Dhaka-1000',
            ],
            [
                'name' => 'Karim Hossain',
                'email' => 'karim@bdmobile.com',
                'phone' => '+8801712345602',
                'company' => 'BD Mobile Bazar',
                'address' => 'Bashundhara City, Panthapath, Dhaka-1215',
            ],
            [
                'name' => 'Salma Akter',
                'email' => 'salma@trendyfashion.com',
                'phone' => '+8801712345603',
                'company' => 'Trendy Fashion House',
                'address' => 'New Market, Dhanmondi, Dhaka-1205',
            ],
            [
                'name' => 'Jamal Mia',
                'email' => 'jamal@homeessentials.com',
                'phone' => '+8801712345604',
                'company' => 'Home Essentials BD',
                'address' => 'Karwan Bazar, Dhaka-1215',
            ],
            [
                'name' => 'Farhana Yasmin',
                'email' => 'farhana@beautypalace.com',
                'phone' => '+8801712345605',
                'company' => 'Beauty Palace',
                'address' => 'Gulshan Avenue, Dhaka-1212',
            ],
            [
                'name' => 'Mizanur Rahman',
                'email' => 'mizan@chittagongtrade.com',
                'phone' => '+8801712345606',
                'company' => 'Chittagong Trade Center',
                'address' => 'Reazuddin Bazar, Chittagong-4000',
            ],
            [
                'name' => 'Nasrin Sultana',
                'email' => 'nasrin@kitchenworld.com',
                'phone' => '+8801712345607',
                'company' => 'Kitchen World',
                'address' => 'Mirpur-10, Dhaka-1216',
            ],
            [
                'name' => 'Abdul Halim',
                'email' => 'halim@bdgadgets.com',
                'phone' => '+8801712345608',
                'company' => 'BD Gadgets Wholesale',
                'address' => 'Multiplan Center, Elephant Road, Dhaka-1205',
            ],
            [
                'name' => 'Shahidul Islam',
                'email' => 'shahid@sylhetwholesale.com',
                'phone' => '+8801712345609',
                'company' => 'Sylhet Wholesale Mart',
                'address' => 'Bandarbazar, Sylhet-3100',
            ],
            [
                'name' => 'Tania Begum',
                'email' => 'tania@littlestar.com',
                'phone' => '+8801712345610',
                'company' => 'Little Star Baby Care',
                'address' => 'Uttara Sector-7, Dhaka-1230',
            ],
            [
                'name' => 'Mohammad Ali',
                'email' => 'ali@bdsports.com',
                'phone' => '+8801712345611',
                'company' => 'BD Sports & Fitness',
                'address' => 'Tikatuli, Dhaka-1203',
            ],
            [
                'name' => 'Rezaul Karim',
                'email' => 'rezaul@premierbrand.com',
                'phone' => '+8801712345612',
                'company' => 'Premier Brand Distributors',
                'address' => 'Banani, Block-C, Dhaka-1213',
            ],
            [
                'name' => 'Sumon Ahmed',
                'email' => 'sumon@bdimports.com',
                'phone' => '+8801712345613',
                'company' => 'BD Imports International',
                'address' => 'Agrabad C/A, Chittagong-4100',
            ],
            [
                'name' => 'Lutfun Nahar',
                'email' => 'lutfun@fragrancehouse.com',
                'phone' => '+8801712345614',
                'company' => 'Fragrance House BD',
                'address' => 'Baitul Mukarram Market, Dhaka-1000',
            ],
            [
                'name' => 'Iqbal Hossain',
                'email' => 'iqbal@autopartsbd.com',
                'phone' => '+8801712345615',
                'company' => 'Auto Parts BD',
                'address' => 'Bangshal, Old Dhaka-1100',
            ],
            [
                'name' => 'Shahana Akhter',
                'email' => 'shahana@bookstationery.com',
                'phone' => '+8801712345616',
                'company' => 'Books & Stationery Mart',
                'address' => 'Nilkhet Book Market, Dhaka-1205',
            ],
            [
                'name' => 'Tariqul Islam',
                'email' => 'tariq@cleaningsupplies.com',
                'phone' => '+8801712345617',
                'company' => 'Cleaning Supplies Bangladesh',
                'address' => 'Mohammadpur, Dhaka-1207',
            ],
            [
                'name' => 'Mehedi Hasan',
                'email' => 'mehedi@bdaccessories.com',
                'phone' => '+8801712345618',
                'company' => 'BD Accessories World',
                'address' => 'Eastern Plaza, Hatirpool, Dhaka-1205',
            ],
            [
                'name' => 'Nazma Khatun',
                'email' => 'nazma@ladiescorner.com',
                'phone' => '+8801712345619',
                'company' => 'Ladies Corner',
                'address' => 'Wari, Dhaka-1203',
            ],
            [
                'name' => 'Rashedul Alam',
                'email' => 'rashed@globaltradebd.com',
                'phone' => '+8801712345620',
                'company' => 'Global Trade BD',
                'address' => 'Tejgaon I/A, Dhaka-1208',
            ],
        ];

        foreach ($suppliers as $sup) {
            Supplier::updateOrCreate(
                ['slug' => Str::slug($sup['name'])],
                [
                    'name' => $sup['name'],
                    'email' => $sup['email'],
                    'phone' => $sup['phone'],
                    'company' => $sup['company'],
                    'address' => $sup['address'],
                    'status' => true,
                ]
            );
        }

        $total = Supplier::count();
        $this->command->info("Suppliers seeded successfully. Total: {$total}");
    }
}
