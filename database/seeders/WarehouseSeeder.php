<?php

namespace Database\Seeders;

use App\Models\Warehouse;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $warehouses = [
            [
                'name' => 'Dhaka Central Warehouse',
                'email' => 'dhaka.central@nfshop24.com',
                'phone' => '+8801820834001',
                'address' => 'Plot 12, Tejgaon Industrial Area, Dhaka-1208, Bangladesh',
            ],
            [
                'name' => 'Dhaka Mirpur Hub',
                'email' => 'mirpur@nfshop24.com',
                'phone' => '+8801820834002',
                'address' => 'House 45, Road 7, Mirpur-12, Dhaka-1216, Bangladesh',
            ],
            [
                'name' => 'Dhaka Uttara Depot',
                'email' => 'uttara@nfshop24.com',
                'phone' => '+8801820834003',
                'address' => 'Sector 11, Uttara, Dhaka-1230, Bangladesh',
            ],
            [
                'name' => 'Chittagong Main Warehouse',
                'email' => 'chittagong@nfshop24.com',
                'phone' => '+8801820834004',
                'address' => 'Agrabad Commercial Area, Chittagong-4100, Bangladesh',
            ],
            [
                'name' => 'Chittagong Port Depot',
                'email' => 'ctg.port@nfshop24.com',
                'phone' => '+8801820834005',
                'address' => 'Port Road, EPZ Area, Chittagong-4223, Bangladesh',
            ],
            [
                'name' => 'Sylhet Regional Warehouse',
                'email' => 'sylhet@nfshop24.com',
                'phone' => '+8801820834006',
                'address' => 'Zindabazar, Sylhet-3100, Bangladesh',
            ],
            [
                'name' => 'Rajshahi Distribution Center',
                'email' => 'rajshahi@nfshop24.com',
                'phone' => '+8801820834007',
                'address' => 'Shaheb Bazar Road, Rajshahi-6000, Bangladesh',
            ],
            [
                'name' => 'Khulna Warehouse',
                'email' => 'khulna@nfshop24.com',
                'phone' => '+8801820834008',
                'address' => 'KDA Avenue, Khulna-9100, Bangladesh',
            ],
            [
                'name' => 'Barishal Storage Hub',
                'email' => 'barishal@nfshop24.com',
                'phone' => '+8801820834009',
                'address' => 'Sadar Road, Barishal-8200, Bangladesh',
            ],
            [
                'name' => 'Rangpur Depot',
                'email' => 'rangpur@nfshop24.com',
                'phone' => '+8801820834010',
                'address' => 'Station Road, Rangpur-5400, Bangladesh',
            ],
            [
                'name' => 'Mymensingh Warehouse',
                'email' => 'mymensingh@nfshop24.com',
                'phone' => '+8801820834011',
                'address' => 'Town Hall Road, Mymensingh-2200, Bangladesh',
            ],
            [
                'name' => 'Cumilla Distribution Point',
                'email' => 'cumilla@nfshop24.com',
                'phone' => '+8801820834012',
                'address' => 'Kandirpar, Cumilla-3500, Bangladesh',
            ],
            [
                'name' => 'Narayanganj Warehouse',
                'email' => 'narayanganj@nfshop24.com',
                'phone' => '+8801820834013',
                'address' => 'BSCIC Industrial Area, Narayanganj-1400, Bangladesh',
            ],
            [
                'name' => 'Gazipur Cold Storage',
                'email' => 'gazipur@nfshop24.com',
                'phone' => '+8801820834014',
                'address' => 'Tongi Industrial Area, Gazipur-1710, Bangladesh',
            ],
            [
                'name' => 'Bogura Regional Hub',
                'email' => 'bogura@nfshop24.com',
                'phone' => '+8801820834015',
                'address' => 'Sherpur Road, Bogura-5800, Bangladesh',
            ],
        ];

        foreach ($warehouses as $wh) {
            Warehouse::updateOrCreate(
                ['slug' => Str::slug($wh['name'])],
                [
                    'name' => $wh['name'],
                    'email' => $wh['email'],
                    'phone' => $wh['phone'],
                    'address' => $wh['address'],
                    'status' => true,
                ]
            );
        }

        $total = Warehouse::count();
        $this->command->info("Warehouses seeded successfully. Total: {$total}");
    }
}
