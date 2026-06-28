<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            // Generic
            'Piece',
            'Pcs',
            'Pair',
            'Set',
            'Pack',
            'Box',
            'Bundle',
            'Dozen',
            'Unit',
            'Roll',
            'Bottle',
            'Jar',
            'Tube',
            'Sachet',
            'Carton',
            'Bag',

            // Weight
            'Gram',
            'Kilogram',
            'Milligram',
            'Pound',
            'Ounce',
            'Ton',

            // Volume
            'Milliliter',
            'Liter',
            'Gallon',

            // Length
            'Centimeter',
            'Meter',
            'Inch',
            'Foot',
            'Yard',
            'Feet',

            // Area
            'Square Meter',
            'Square Foot',

            // Bangla/Local common
            'Hali',
            'Kg',
            'Gm',
            'Ml',
            'Ltr',
        ];

        foreach ($units as $name) {
            Unit::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'status' => true,
                ]
            );
        }

        $total = Unit::count();
        $this->command->info("Units seeded successfully. Total: {$total}");
    }
}
