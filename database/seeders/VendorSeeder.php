<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'Apex Tech Solutions Ltd.',
                'company_name' => 'Apex Technologies Group',
                'email' => 'procurement@apextech.com',
                'phone' => '+1 (415) 880-2341',
                'address' => '500 Howard St, San Francisco, CA',
                'category' => 'Electronics',
                'payment_terms' => 'Net 30',
                'status' => 'Active',
                'rating' => 4.9,
            ],
            [
                'name' => 'UrbanThreads Textile Co.',
                'company_name' => 'UrbanThreads Global',
                'email' => 'sales@urbanthreads.io',
                'phone' => '+1 (213) 441-9920',
                'address' => '120 E 8th St, Los Angeles, CA',
                'category' => 'Apparel',
                'payment_terms' => 'Net 15',
                'status' => 'Active',
                'rating' => 4.7,
            ],
            [
                'name' => 'Nordic Living Craftworks',
                'company_name' => 'Nordic Design Collective',
                'email' => 'orders@nordicliving.de',
                'phone' => '+49 30 901820',
                'address' => 'Friedrichstraße 44, Berlin, Germany',
                'category' => 'Home & Living',
                'payment_terms' => 'Net 30',
                'status' => 'Active',
                'rating' => 4.8,
            ],
            [
                'name' => 'SoundWave Acoustic Labs',
                'company_name' => 'SoundWave Audio Inc.',
                'email' => 'contact@soundwaveaudio.com',
                'phone' => '+1 (512) 690-3321',
                'address' => '100 Congress Ave, Austin, TX',
                'category' => 'Electronics',
                'payment_terms' => 'COD',
                'status' => 'Active',
                'rating' => 4.6,
            ],
            [
                'name' => 'PrimeWear Logistics LLC',
                'company_name' => 'PrimeWear International',
                'email' => 'help@primewear.com',
                'phone' => '+1 (312) 778-1029',
                'address' => '200 N Michigan Ave, Chicago, IL',
                'category' => 'Apparel',
                'payment_terms' => 'Net 30',
                'status' => 'On-Hold',
                'rating' => 3.8,
            ],
        ];

        foreach ($vendors as $vendor) {
            Vendor::updateOrCreate(['email' => $vendor['email']], $vendor);
        }
    }
}
