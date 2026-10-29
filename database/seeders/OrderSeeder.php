<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $products = Product::all();
        if ($products->isEmpty()) {
            return;
        }

        $ordersData = [
            [
                'order_number' => 'ORD-2026-9001',
                'customer_name' => 'Alexander Hayes',
                'customer_email' => 'alex.hayes@example.com',
                'customer_phone' => '+1 (555) 234-5678',
                'source' => 'Online',
                'payment_method' => 'Credit Card',
                'payment_status' => 'Paid',
                'order_status' => 'Completed',
                'items_count' => 2,
            ],
            [
                'order_number' => 'ORD-2026-9002',
                'customer_name' => 'Sophia Ramirez',
                'customer_email' => 'sophia.r@example.com',
                'customer_phone' => '+1 (555) 345-6789',
                'source' => 'In-Store / POS',
                'payment_method' => 'Cash',
                'payment_status' => 'Paid',
                'order_status' => 'Completed',
                'items_count' => 1,
            ],
            [
                'order_number' => 'ORD-2026-9003',
                'customer_name' => 'Liam Chen',
                'customer_email' => 'liam.chen@example.com',
                'customer_phone' => '+1 (555) 456-7890',
                'source' => 'Marketplace',
                'payment_method' => 'PayPal',
                'payment_status' => 'Paid',
                'order_status' => 'Processing',
                'items_count' => 3,
            ],
            [
                'order_number' => 'ORD-2026-9004',
                'customer_name' => 'Emma Watson',
                'customer_email' => 'emma.w@example.com',
                'customer_phone' => '+1 (555) 567-8901',
                'source' => 'Online',
                'payment_method' => 'Credit Card',
                'payment_status' => 'Pending',
                'order_status' => 'Pending',
                'items_count' => 1,
            ],
            [
                'order_number' => 'ORD-2026-9005',
                'customer_name' => 'Noah Miller',
                'customer_email' => 'noah.miller@example.com',
                'customer_phone' => '+1 (555) 678-9012',
                'source' => 'In-Store / POS',
                'payment_method' => 'Credit Card',
                'payment_status' => 'Paid',
                'order_status' => 'Completed',
                'items_count' => 2,
            ],
            [
                'order_number' => 'ORD-2026-9006',
                'customer_name' => 'Olivia Taylor',
                'customer_email' => 'olivia.t@example.com',
                'customer_phone' => '+1 (555) 789-0123',
                'source' => 'Online',
                'payment_method' => 'Credit Card',
                'payment_status' => 'Refunded',
                'order_status' => 'Cancelled',
                'items_count' => 1,
            ],
            [
                'order_number' => 'ORD-2026-9007',
                'customer_name' => 'Ethan Walker',
                'customer_email' => 'ethan.w@example.com',
                'customer_phone' => '+1 (555) 890-1234',
                'source' => 'Online',
                'payment_method' => 'Credit Card',
                'payment_status' => 'Paid',
                'order_status' => 'Processing',
                'items_count' => 2,
            ],
            [
                'order_number' => 'ORD-2026-9008',
                'customer_name' => 'Mia Patel',
                'customer_email' => 'mia.patel@example.com',
                'customer_phone' => '+1 (555) 901-2345',
                'source' => 'In-Store / POS',
                'payment_method' => 'Cash',
                'payment_status' => 'Paid',
                'order_status' => 'Completed',
                'items_count' => 1,
            ],
        ];

        foreach ($ordersData as $i => $data) {
            $existing = Order::where('order_number', $data['order_number'])->first();
            if ($existing) {
                continue;
            }

            $order = Order::create([
                'order_number' => $data['order_number'],
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'],
                'customer_phone' => $data['customer_phone'],
                'source' => $data['source'],
                'payment_method' => $data['payment_method'],
                'payment_status' => $data['payment_status'],
                'order_status' => $data['order_status'],
                'subtotal' => 0,
                'tax_amount' => 0,
                'discount_amount' => 0,
                'total_amount' => 0,
                'created_at' => now()->subDays(count($ordersData) - $i),
                'updated_at' => now()->subDays(count($ordersData) - $i),
            ]);

            $subtotal = 0;
            // Pick slice of products
            $selectedProducts = $products->random(min($data['items_count'], $products->count()));
            foreach ($selectedProducts as $prod) {
                $qty = rand(1, 2);
                $linePrice = (float) $prod->price;
                $lineSubtotal = round($linePrice * $qty, 2);
                $subtotal += $lineSubtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $prod->id,
                    'product_name' => $prod->name,
                    'product_sku' => $prod->sku,
                    'unit_price' => $linePrice,
                    'quantity' => $qty,
                    'subtotal' => $lineSubtotal,
                ]);
            }

            $tax = round($subtotal * 0.08, 2); // 8% sales tax
            $discount = ($data['items_count'] > 1) ? 5.00 : 0.00;
            $total = max(0, $subtotal + $tax - $discount);

            $order->update([
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'discount_amount' => $discount,
                'total_amount' => $total,
            ]);
        }
    }
}
