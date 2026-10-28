<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test products dashboard loads successfully with metrics.
     */
    public function test_products_index_page_loads_with_data_and_metrics(): void
    {
        Product::factory()->create([
            'name' => 'Test Cotton Tee',
            'sku' => 'APP-TSH-999',
            'category' => 'Apparel',
            'price' => 25.00,
            'stock_quantity' => 50,
            'status' => 'Active',
        ]);

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Cotton Tee');
        $response->assertSee('APP-TSH-999');
        $response->assertSee('Total Products');
        $response->assertSee('Active Products');
    }

    /**
     * Test searching by name or SKU.
     */
    public function test_search_by_partial_name_and_sku(): void
    {
        Product::create([
            'name' => 'Ergonomic Keyboard',
            'sku' => 'ELE-KEY-001',
            'category' => 'Electronics',
            'price' => 99.00,
            'stock_quantity' => 100,
            'status' => 'Active',
        ]);

        Product::create([
            'name' => 'Denim Jacket',
            'sku' => 'APP-JKT-002',
            'category' => 'Apparel',
            'price' => 79.00,
            'stock_quantity' => 100,
            'status' => 'Active',
        ]);

        // Search by partial name
        $response = $this->get(route('products.index', ['search' => 'Keyboard']));
        $response->assertSee('Ergonomic Keyboard');
        $response->assertDontSee('Denim Jacket');

        // Search by SKU
        $responseSku = $this->get(route('products.index', ['search' => 'JKT-002']));
        $responseSku->assertSee('Denim Jacket');
        $responseSku->assertDontSee('Ergonomic Keyboard');
    }

    /**
     * Test category and status filters combined.
     */
    public function test_combined_category_and_status_filters(): void
    {
        Product::create([
            'name' => 'Silk Scarf',
            'sku' => 'APP-SCF-001',
            'category' => 'Apparel',
            'price' => 30.00,
            'stock_quantity' => 100,
            'status' => 'Active',
        ]);

        Product::create([
            'name' => 'Draft Shirt',
            'sku' => 'APP-SHT-002',
            'category' => 'Apparel',
            'price' => 45.00,
            'stock_quantity' => 100,
            'status' => 'Draft',
        ]);

        Product::create([
            'name' => 'Active Mouse',
            'sku' => 'ELE-MOU-003',
            'category' => 'Electronics',
            'price' => 20.00,
            'stock_quantity' => 100,
            'status' => 'Active',
        ]);

        // Filter: Category Apparel AND Status Active
        $response = $this->get(route('products.index', [
            'category' => 'Apparel',
            'status' => 'Active',
        ]));

        $response->assertSee('Silk Scarf');
        $response->assertDontSee('Draft Shirt');
        $response->assertDontSee('Active Mouse');
    }

    /**
     * Test creating a product persists in database and redirects with flash message.
     */
    public function test_can_create_product_with_valid_data(): void
    {
        $payload = [
            'name' => 'Wireless Gaming Headset',
            'sku' => 'ELE-HDT-777',
            'category' => 'Electronics',
            'price' => 129.99,
            'sale_price' => 99.99,
            'stock_quantity' => 40,
            'low_stock_threshold' => 10,
            'status' => 'Active',
            'description' => 'Surround sound spatial audio with noise cancelling mic.',
        ];

        $response = $this->post(route('products.store'), $payload);

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('products', [
            'sku' => 'ELE-HDT-777',
            'name' => 'Wireless Gaming Headset',
            'price' => 129.99,
        ]);
    }

    /**
     * Test duplicate SKU is rejected.
     */
    public function test_duplicate_sku_is_rejected(): void
    {
        Product::create([
            'name' => 'Original Product',
            'sku' => 'DUP-SKU-001',
            'category' => 'Apparel',
            'price' => 50.00,
            'stock_quantity' => 10,
            'status' => 'Active',
        ]);

        $duplicatePayload = [
            'name' => 'Second Product Same SKU',
            'sku' => 'DUP-SKU-001',
            'category' => 'Electronics',
            'price' => 60.00,
            'stock_quantity' => 5,
            'status' => 'Active',
        ];

        $response = $this->post(route('products.store'), $duplicatePayload);

        $response->assertSessionHasErrors(['sku']);
        $this->assertDatabaseCount('products', 1);
    }

    /**
     * Test negative price and negative stock are rejected.
     */
    public function test_negative_values_are_rejected(): void
    {
        $invalidPayload = [
            'name' => 'Invalid Product',
            'sku' => 'INV-001',
            'category' => 'Electronics',
            'price' => -10.00,
            'stock_quantity' => -5,
            'status' => 'Active',
        ];

        $response = $this->post(route('products.store'), $invalidPayload);

        $response->assertSessionHasErrors(['price', 'stock_quantity']);
    }

    /**
     * Test updating a product updates database.
     */
    public function test_can_update_product(): void
    {
        $product = Product::create([
            'name' => 'Old Name',
            'sku' => 'UPD-SKU-001',
            'category' => 'Apparel',
            'price' => 50.00,
            'stock_quantity' => 10,
            'status' => 'Active',
        ]);

        $updatePayload = [
            'name' => 'Updated Product Name',
            'sku' => 'UPD-SKU-001', // same SKU should be allowed for same product
            'category' => 'Apparel',
            'price' => 65.00,
            'stock_quantity' => 25,
            'status' => 'Active',
        ];

        $response = $this->put(route('products.update', $product), $updatePayload);

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product Name',
            'price' => 65.00,
            'stock_quantity' => 25,
        ]);
    }

    /**
     * Test deleting a product removes it from database.
     */
    public function test_can_delete_product(): void
    {
        $product = Product::create([
            'name' => 'To Be Deleted',
            'sku' => 'DEL-SKU-001',
            'category' => 'Home & Living',
            'price' => 15.00,
            'stock_quantity' => 3,
            'status' => 'Inactive',
        ]);

        $response = $this->delete(route('products.destroy', $product));

        $response->assertRedirect(route('products.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /**
     * Test SKU generator endpoint returns valid JSON.
     */
    public function test_generate_sku_endpoint(): void
    {
        $response = $this->postJson(route('products.generate-sku'), [
            'category' => 'Electronics',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['success', 'sku']);
        $this->assertStringStartsWith('ELE-', $response->json('sku'));
    }

    /**
     * Test CSV export endpoint.
     */
    public function test_csv_export_endpoint(): void
    {
        Product::create([
            'name' => 'Export Item',
            'sku' => 'EXP-001',
            'category' => 'Apparel',
            'price' => 29.99,
            'stock_quantity' => 10,
            'status' => 'Active',
        ]);

        $response = $this->get(route('products.export'));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('EXP-001', $response->streamedContent());
    }
}
