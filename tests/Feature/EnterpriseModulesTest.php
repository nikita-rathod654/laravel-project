<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Store;
use App\Models\Vendor;
use App\Models\MarketingCampaign;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnterpriseModulesTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_page_loads_successfully(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Welcome to Ace360degree Suite');
        $response->assertSee('Total Sales Revenue');
    }

    public function test_store_crud_operations(): void
    {
        $response = $this->get(route('stores.index'));
        $response->assertStatus(200);

        // Create Store
        $postData = [
            'name' => 'Downtown Test Store',
            'code' => 'STR-TEST-01',
            'type' => 'Retail Outlet',
            'address' => '123 Main St',
            'city' => 'New York, NY',
            'phone' => '+1 (555) 123-4567',
            'manager_name' => 'Alice Test',
            'status' => 'Active',
        ];
        $postRes = $this->post(route('stores.store'), $postData);
        $postRes->assertRedirect(route('stores.index'));
        $this->assertDatabaseHas('stores', ['code' => 'STR-TEST-01']);

        // Update Store
        $store = Store::where('code', 'STR-TEST-01')->first();
        $putRes = $this->put(route('stores.update', $store), array_merge($postData, ['name' => 'Updated Store Name']));
        $putRes->assertRedirect(route('stores.index'));
        $this->assertDatabaseHas('stores', ['name' => 'Updated Store Name']);

        // Delete Store
        $delRes = $this->delete(route('stores.destroy', $store));
        $delRes->assertRedirect(route('stores.index'));
        $this->assertDatabaseMissing('stores', ['id' => $store->id]);
    }

    public function test_orders_page_and_status_update(): void
    {
        $order = Order::create([
            'order_number' => 'ORD-TEST-999',
            'customer_name' => 'John Tester',
            'customer_email' => 'john@test.com',
            'source' => 'Online',
            'subtotal' => 100.00,
            'tax_amount' => 8.00,
            'discount_amount' => 0.00,
            'total_amount' => 108.00,
            'payment_method' => 'Credit Card',
            'payment_status' => 'Paid',
            'order_status' => 'Pending',
        ]);

        $response = $this->get(route('orders.index'));
        $response->assertStatus(200);
        $response->assertSee('ORD-TEST-999');

        // Status update
        $patchRes = $this->patch(route('orders.status', $order), [
            'order_status' => 'Completed',
        ]);
        $patchRes->assertRedirect(route('orders.index'));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'order_status' => 'Completed',
        ]);
    }

    public function test_pos_checkout_flow_deducts_stock_and_creates_order(): void
    {
        $product = Product::create([
            'name' => 'POS Test Widget',
            'sku' => 'WGT-POS-001',
            'category' => 'Electronics',
            'price' => 50.00,
            'stock_quantity' => 20,
            'status' => 'Active',
        ]);

        $promo = Promotion::create([
            'code' => 'POSSAVE10',
            'title' => 'POS 10% Coupon',
            'discount_type' => 'percentage',
            'discount_value' => 10.00,
            'min_spend' => 0.00,
            'status' => 'Active',
        ]);

        $checkoutData = [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 2],
            ],
            'payment_method' => 'Cash',
            'customer_name' => 'Counter Customer',
            'coupon_code' => 'POSSAVE10',
            'amount_tendered' => 100.00,
        ];

        $response = $this->postJson(route('pos.checkout'), $checkoutData);
        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        // Product stock decreased by 2
        $product->refresh();
        $this->assertEquals(18, $product->stock_quantity);

        // Order created with source 'In-Store / POS'
        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Counter Customer',
            'source' => 'In-Store / POS',
            'payment_status' => 'Paid',
        ]);
    }
}
