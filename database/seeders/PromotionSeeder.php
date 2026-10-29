<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Seeder;

class PromotionSeeder extends Seeder
{
    public function run(): void
    {
        $promotions = [
            [
                'code' => 'WELCOME15',
                'title' => 'New Customer Welcome Coupon',
                'discount_type' => 'percentage',
                'discount_value' => 15.00,
                'min_spend' => 30.00,
                'usage_limit' => 500,
                'used_count' => 142,
                'starts_at' => now()->subDays(30),
                'expires_at' => now()->addDays(90),
                'status' => 'Active',
            ],
            [
                'code' => 'TECHSAVE20',
                'title' => 'Electronics Weekend Bonanza',
                'discount_type' => 'percentage',
                'discount_value' => 20.00,
                'min_spend' => 80.00,
                'usage_limit' => 200,
                'used_count' => 89,
                'starts_at' => now()->subDays(10),
                'expires_at' => now()->addDays(20),
                'status' => 'Active',
            ],
            [
                'code' => 'SUMMERFLAT10',
                'title' => 'Seasonal Flat Discount on Home & Apparel',
                'discount_type' => 'fixed',
                'discount_value' => 10.00,
                'min_spend' => 50.00,
                'usage_limit' => 300,
                'used_count' => 210,
                'starts_at' => now()->subDays(15),
                'expires_at' => now()->addDays(15),
                'status' => 'Active',
            ],
            [
                'code' => 'FLASH50',
                'title' => 'Midnight Flash Deal 50% Off',
                'discount_type' => 'percentage',
                'discount_value' => 50.00,
                'min_spend' => 100.00,
                'usage_limit' => 50,
                'used_count' => 50,
                'starts_at' => now()->subDays(2),
                'expires_at' => now()->subDay(),
                'status' => 'Expired',
            ],
            [
                'code' => 'VIPCLUB25',
                'title' => 'Exclusive VIP Member Reward',
                'discount_type' => 'percentage',
                'discount_value' => 25.00,
                'min_spend' => 150.00,
                'usage_limit' => 100,
                'used_count' => 18,
                'starts_at' => now()->subDays(5),
                'expires_at' => now()->addDays(45),
                'status' => 'Active',
            ],
        ];

        foreach ($promotions as $promo) {
            Promotion::updateOrCreate(['code' => $promo['code']], $promo);
        }
    }
}
