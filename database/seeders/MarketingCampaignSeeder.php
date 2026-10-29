<?php

namespace Database\Seeders;

use App\Models\MarketingCampaign;
use Illuminate\Database\Seeder;

class MarketingCampaignSeeder extends Seeder
{
    public function run(): void
    {
        $campaigns = [
            [
                'name' => 'Spring Apparel Refresh 2026',
                'channel' => 'Social Media',
                'target_audience' => 'Young Professionals (18-35)',
                'budget' => 3500.00,
                'spent' => 2840.50,
                'impressions' => 64500,
                'clicks' => 3420,
                'conversions' => 418,
                'status' => 'Active',
                'start_date' => now()->subDays(20),
                'end_date' => now()->addDays(10),
            ],
            [
                'name' => 'High-Fidelity Audio Retargeting',
                'channel' => 'Google Ads',
                'target_audience' => 'Audiophiles & Tech Enthusiasts',
                'budget' => 5000.00,
                'spent' => 4820.00,
                'impressions' => 112000,
                'clicks' => 6780,
                'conversions' => 742,
                'status' => 'Active',
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(15),
            ],
            [
                'name' => 'VIP Flash Sale Newsletter',
                'channel' => 'Email',
                'target_audience' => 'Existing Repeat Subscribers (15,000 users)',
                'budget' => 800.00,
                'spent' => 620.00,
                'impressions' => 14800,
                'clicks' => 2940,
                'conversions' => 512,
                'status' => 'Active',
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(2),
            ],
            [
                'name' => 'Home Décor SMS Alerts',
                'channel' => 'SMS',
                'target_audience' => 'Subscribers opted-in for seasonal deals',
                'budget' => 1200.00,
                'spent' => 1200.00,
                'impressions' => 8500,
                'clicks' => 1250,
                'conversions' => 195,
                'status' => 'Completed',
                'start_date' => now()->subDays(25),
                'end_date' => now()->subDays(5),
            ],
            [
                'name' => 'Winter Clearance Liquidation',
                'channel' => 'Google Ads',
                'target_audience' => 'Bargain Seekers',
                'budget' => 2000.00,
                'spent' => 450.00,
                'impressions' => 15000,
                'clicks' => 710,
                'conversions' => 64,
                'status' => 'Paused',
                'start_date' => now()->subDays(40),
                'end_date' => now()->addDays(5),
            ],
        ];

        foreach ($campaigns as $camp) {
            MarketingCampaign::updateOrCreate(['name' => $camp['name']], $camp);
        }
    }
}
