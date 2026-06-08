<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Iso25010Test extends TestCase
{
    use RefreshDatabase;

    public function test_functional_suitability_customer_can_search_add_to_cart_and_checkout(): void
    {
        $customer = $this->user();
        $product = $this->product(['name' => 'Kampas Rem Racing', 'stock' => 5, 'price' => 50000]);

        $this->get('/?search=Kampas')
            ->assertOk()
            ->assertSee('Kampas Rem Racing');

        $this->actingAs($customer)
            ->post(route('cart.store', $product), ['quantity' => 2])
            ->assertRedirect(route('cart.index'));

        $this->actingAs($customer)
            ->post(route('checkout.store'), [
                'customer_name' => 'Rizky',
                'phone' => '08123456789',
                'shipping_address' => 'Jl. Bengkel No. 1',
                'notes' => 'Kirim sore',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('orders', ['user_id' => $customer->id, 'total_amount' => 100000]);
        $this->assertDatabaseHas('order_items', ['product_name' => 'Kampas Rem Racing', 'quantity' => 2]);
        $this->assertSame(3, $product->fresh()->stock);
    }

    public function test_usability_pages_show_clear_navigation_and_customer_actions(): void
    {
        $this->product(['name' => 'Oli Matic Premium']);

        $this->get('/')
            ->assertOk()
            ->assertSee('MotoPart Garage')
            ->assertSee('Cari sparepart')
            ->assertSee('Login')
            ->assertSee('Register')
            ->assertSee('Oli Matic Premium');
    }

    public function test_reliability_checkout_rejects_quantity_above_available_stock(): void
    {
        $customer = $this->user();
        $product = $this->product(['stock' => 1]);
        $cart = Cart::create(['user_id' => $customer->id]);
        $cart->items()->create(['product_id' => $product->id, 'quantity' => 2]);

        $this->actingAs($customer)
            ->post(route('checkout.store'), [
                'customer_name' => 'Rizky',
                'phone' => '08123456789',
                'shipping_address' => 'Jl. Bengkel No. 1',
            ])
            ->assertStatus(422);

        $this->assertDatabaseCount('orders', 0);
        $this->assertSame(1, $product->fresh()->stock);
    }

    public function test_security_customer_cannot_access_admin_dashboard_and_password_is_hashed(): void
    {
        $customer = $this->user(['password' => Hash::make('super-secret')]);

        $this->actingAs($customer)
            ->get(route('admin.dashboard'))
            ->assertForbidden();

        $this->assertTrue(Hash::check('super-secret', $customer->password));
        $this->assertNotSame('super-secret', $customer->password);
    }

    public function test_performance_efficiency_catalog_is_paginated_for_large_product_sets(): void
    {
        $category = Category::create(['name' => 'Oli', 'slug' => 'oli']);
        for ($i = 1; $i <= 40; $i++) {
            Product::create([
                'category_id' => $category->id,
                'name' => 'Sparepart '.$i,
                'slug' => 'sparepart-'.$i,
                'sku' => 'SKU-'.$i,
                'description' => 'Produk performa untuk pengujian pagination.',
                'price' => 10000 + $i,
                'stock' => 10,
                'is_active' => true,
            ]);
        }

        $startedAt = microtime(true);

        $this->get('/')
            ->assertOk()
            ->assertSee('Sparepart 1')
            ->assertDontSee('Sparepart 10');

        $this->assertLessThan(1.5, microtime(true) - $startedAt);
    }

    public function test_functional_suitability_admin_can_upload_product_image(): void
    {
        Storage::fake('public');

        $admin = $this->user(['role' => 'admin']);
        $category = Category::create(['name' => 'Kelistrikan', 'slug' => 'kelistrikan']);

        $this->actingAs($admin)
            ->post(route('admin.products.store'), [
                'category_id' => $category->id,
                'name' => 'Lampu LED Motor',
                'sku' => 'LED-001',
                'description' => 'Lampu LED terang untuk motor harian.',
                'price' => 95000,
                'stock' => 12,
                'brand' => 'BrightRide',
                'image' => UploadedFile::fake()->image('lampu-led.jpg'),
                'is_active' => '1',
            ])
            ->assertRedirect(route('admin.products.index'));

        $product = Product::where('sku', 'LED-001')->firstOrFail();

        $this->assertNotNull($product->image);
        Storage::disk('public')->assertExists($product->image);
    }

    private function user(array $attributes = []): User
    {
        return User::create(array_merge([
            'name' => 'Customer',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => 'customer',
        ], $attributes));
    }

    private function product(array $attributes = []): Product
    {
        $category = Category::create([
            'name' => fake()->unique()->word(),
            'slug' => fake()->unique()->slug(),
        ]);

        return Product::create(array_merge([
            'category_id' => $category->id,
            'name' => 'Busi Iridium',
            'slug' => fake()->unique()->slug(),
            'sku' => fake()->unique()->bothify('SKU-###'),
            'description' => 'Sparepart motor berkualitas.',
            'price' => 75000,
            'stock' => 10,
            'is_active' => true,
        ], $attributes));
    }
}
