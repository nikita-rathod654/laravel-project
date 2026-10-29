<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $stores = [
            [
                'name' => 'Metro Flagship Downtown',
                'code' => 'STR-NYC-01',
                'type' => 'Flagship Store',
                'address' => '742 Broadway Ave, Manhattan',
                'city' => 'New York, NY',
                'phone' => '+1 (212) 555-0198',
                'manager_name' => 'Sarah Jenkins',
                'status' => 'Active',
            ],
            [
                'name' => 'Westfield Central Mall',
                'code' => 'STR-LA-02',
                'type' => 'Retail Outlet',
                'address' => '10250 Santa Monica Blvd',
                'city' => 'Los Angeles, CA',
                'phone' => '+1 (310) 555-0142',
                'manager_name' => 'Marcus Vance',
                'status' => 'Active',
            ],
            [
                'name' => 'Midwest Logistics Hub',
                'code' => 'WH-CHI-01',
                'type' => 'Fulfillment Center',
                'address' => '4500 W 47th St, Industrial Park',
                'city' => 'Chicago, IL',
                'phone' => '+1 (312) 555-0187',
                'manager_name' => 'David Morales',
                'status' => 'Active',
            ],
            [
                'name' => 'Northwest Boutique Outlet',
                'code' => 'STR-SEA-03',
                'type' => 'Retail Outlet',
                'address' => '2601 4th Ave, Belltown',
                'city' => 'Seattle, WA',
                'phone' => '+1 (206) 555-0177',
                'manager_name' => 'Elena Rostova',
                'status' => 'Maintenance',
            ],
            [
                'name' => 'Southwest Express Store',
                'code' => 'STR-AUS-04',
                'type' => 'Express Kiosk',
                'address' => '11410 Century Oaks Terrace',
                'city' => 'Austin, TX',
                'phone' => '+1 (512) 555-0133',
                'manager_name' => 'Jason Cole',
                'status' => 'Active',
            ],
        ];

        $admin = User::firstOrCreate(
            ['email' => 'admin@ace360degree.com'],
            ['name' => 'Alex Admin', 'password' => bcrypt('password123')]
        );

        foreach ($stores as $store) {
            $store['user_id'] = $admin->id;
            Store::updateOrCreate(['code' => $store['code']], $store);
        }
    }
}
