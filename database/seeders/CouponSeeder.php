<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    public function run(): void
    {
        $coupons = [
            [
                'code'             => 'WELCOME10',
                'description'      => 'New customer welcome discount — 10% off any order',
                'type'             => 'percentage',
                'amount'           => 10,
                'minimum_spend'    => 500,
                'maximum_discount' => 500,
                'usage_limit'      => null,
                'usage_limit_per_customer' => 1,
                'used_count'       => 47,
                'free_shipping'    => false,
                'starts_at'        => null,
                'expires_at'       => Carbon::now()->addYear(),
                'status'           => true,
            ],
            [
                'code'             => 'NFSHOP50',
                'description'      => '50 taka off on orders above 1000',
                'type'             => 'fixed',
                'amount'           => 50,
                'minimum_spend'    => 1000,
                'used_count'       => 23,
                'starts_at'        => null,
                'expires_at'       => Carbon::now()->addMonths(3),
                'status'           => true,
            ],
            [
                'code'             => 'FREESHIP',
                'description'      => 'Free shipping on orders above 2000',
                'type'             => 'fixed',
                'amount'           => 0,
                'minimum_spend'    => 2000,
                'free_shipping'    => true,
                'used_count'       => 89,
                'starts_at'        => null,
                'expires_at'       => null,
                'status'           => true,
            ],
            [
                'code'             => 'EID2026',
                'description'      => 'Eid special — 15% off, up to 1000 tk',
                'type'             => 'percentage',
                'amount'           => 15,
                'minimum_spend'    => 1500,
                'maximum_discount' => 1000,
                'usage_limit'      => 500,
                'usage_limit_per_customer' => 1,
                'used_count'       => 0,
                'starts_at'        => Carbon::now()->addDays(15),
                'expires_at'       => Carbon::now()->addDays(45),
                'status'           => true,
            ],
            [
                'code'             => 'FLASH20',
                'description'      => 'Flash sale — 20% off, limited use',
                'type'             => 'percentage',
                'amount'           => 20,
                'minimum_spend'    => 800,
                'maximum_discount' => 800,
                'usage_limit'      => 100,
                'used_count'       => 100,
                'starts_at'        => null,
                'expires_at'       => Carbon::now()->addDays(7),
                'status'           => true,
            ],
            [
                'code'             => 'BIGORDER200',
                'description'      => '200 taka off on orders above 3000',
                'type'             => 'fixed',
                'amount'           => 200,
                'minimum_spend'    => 3000,
                'used_count'       => 12,
                'starts_at'        => null,
                'expires_at'       => Carbon::now()->addMonths(6),
                'status'           => true,
            ],
            [
                'code'             => 'COMBO25',
                'description'      => '25% off — individual use only',
                'type'             => 'percentage',
                'amount'           => 25,
                'minimum_spend'    => 1200,
                'maximum_discount' => 1500,
                'individual_use_only' => true,
                'usage_limit_per_customer' => 2,
                'used_count'       => 8,
                'expires_at'       => Carbon::now()->addMonths(2),
                'status'           => true,
            ],
            [
                'code'             => 'BLACKFRIDAY24',
                'description'      => 'Black Friday 2024 — expired campaign',
                'type'             => 'percentage',
                'amount'           => 30,
                'minimum_spend'    => 1000,
                'used_count'       => 234,
                'starts_at'        => Carbon::create(2024, 11, 25),
                'expires_at'       => Carbon::create(2024, 11, 30),
                'status'           => true,
            ],
            [
                'code'             => 'NEWYEAR2025',
                'description'      => 'New Year 2025 launch coupon — expired',
                'type'             => 'fixed',
                'amount'           => 100,
                'minimum_spend'    => 500,
                'used_count'       => 156,
                'starts_at'        => Carbon::create(2024, 12, 31),
                'expires_at'       => Carbon::create(2025, 1, 7),
                'status'           => true,
            ],
            [
                'code'             => 'STAFFTEST',
                'description'      => 'Internal QA testing — currently disabled',
                'type'             => 'percentage',
                'amount'           => 90,
                'minimum_spend'    => null,
                'used_count'       => 3,
                'status'           => false,
            ],
            [
                'code'             => 'LOYAL5',
                'description'      => '5% loyalty discount for repeat customers',
                'type'             => 'percentage',
                'amount'           => 5,
                'minimum_spend'    => 300,
                'used_count'       => 412,
                'status'           => true,
            ],
            [
                'code'             => 'FIRST300',
                'description'      => '300 tk off — first order only',
                'type'             => 'fixed',
                'amount'           => 300,
                'minimum_spend'    => 1500,
                'usage_limit_per_customer' => 1,
                'used_count'       => 67,
                'expires_at'       => Carbon::now()->addMonths(12),
                'status'           => true,
            ],
        ];

        foreach ($coupons as $data) {
            Coupon::updateOrCreate(
                ['code' => $data['code']],
                array_merge([
                    'description'              => null,
                    'minimum_spend'            => null,
                    'maximum_discount'         => null,
                    'usage_limit'              => null,
                    'usage_limit_per_customer' => null,
                    'used_count'               => 0,
                    'free_shipping'            => false,
                    'individual_use_only'      => false,
                    'exclude_sale_items'       => false,
                    'starts_at'                => null,
                    'expires_at'               => null,
                    'status'                   => true,
                ], $data)
            );
        }

        $this->command->info('Coupons seeded successfully. Total: ' . Coupon::count());
    }
}
