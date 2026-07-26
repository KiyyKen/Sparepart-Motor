<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PolishFeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_review_product_from_a_completed_order(): void
    {
        $customer = $this->user();
        $product = $this->product();
        $order = $this->completedOrder($customer, $product);

        $this->actingAs($customer)
            ->post(route('reviews.store', $product), [
                'rating' => 5,
                'comment' => 'Mantap, cepat sampai.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('reviews', [
            'product_id' => $product->id,
            'user_id' => $customer->id,
            'order_id' => $order->id,
            'rating' => 5,
        ]);
    }

    public function test_customer_cannot_review_product_without_completed_order(): void
    {
        $customer = $this->user();
        $product = $this->product();

        $this->actingAs($customer)
            ->post(route('reviews.store', $product), ['rating' => 4])
            ->assertForbidden();

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_customer_cannot_submit_duplicate_review_for_same_order(): void
    {
        $customer = $this->user();
        $product = $this->product();
        $order = $this->completedOrder($customer, $product);

        Review::create([
            'product_id' => $product->id,
            'user_id' => $customer->id,
            'order_id' => $order->id,
            'rating' => 4,
        ]);

        $this->actingAs($customer)
            ->post(route('reviews.store', $product), ['rating' => 5])
            ->assertForbidden();

        $this->assertDatabaseCount('reviews', 1);
    }

    public function test_customer_can_download_invoice_pdf_for_own_order(): void
    {
        $customer = $this->user();
        $product = $this->product();
        $order = $this->completedOrder($customer, $product);

        $this->actingAs($customer)
            ->get(route('orders.invoice', $order))
            ->assertOk()
            ->assertHeader('content-type', 'application/pdf');
    }

    public function test_customer_cannot_download_invoice_of_another_customer_order(): void
    {
        $owner = $this->user();
        $intruder = $this->user();
        $product = $this->product();
        $order = $this->completedOrder($owner, $product);

        $this->actingAs($intruder)
            ->get(route('orders.invoice', $order))
            ->assertForbidden();
    }

    public function test_payment_page_shows_notice_when_midtrans_is_not_configured(): void
    {
        config(['services.midtrans.server_key' => null, 'services.midtrans.client_key' => null]);

        $customer = $this->user();
        $product = $this->product();
        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-TEST-'.$customer->id,
            'status' => 'pending',
            'total_amount' => $product->price,
            'customer_name' => $customer->name,
            'phone' => '0812',
            'shipping_address' => 'Jl. Test',
        ]);

        $this->actingAs($customer)
            ->get(route('payment.show', $order))
            ->assertOk()
            ->assertSee('belum dikonfigurasi');
    }

    public function test_admin_status_update_notifies_customer_and_logs_history(): void
    {
        Notification::fake();

        $admin = $this->user(['role' => 'admin']);
        $customer = $this->user();
        $product = $this->product();
        $order = $this->completedOrder($customer, $product, 'paid');

        $this->actingAs($admin)
            ->patch(route('admin.orders.update', $order), ['status' => 'processing'])
            ->assertRedirect();

        $this->assertDatabaseHas('order_status_histories', [
            'order_id' => $order->id,
            'status' => 'processing',
        ]);

        Notification::assertSentTo($customer, \App\Notifications\OrderStatusUpdated::class);
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

    private function completedOrder(User $customer, Product $product, string $status = 'completed'): Order
    {
        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'ORD-'.fake()->unique()->numerify('######'),
            'status' => $status,
            'total_amount' => $product->price,
            'customer_name' => $customer->name,
            'phone' => '0812',
            'shipping_address' => 'Jl. Test',
        ]);

        $order->items()->create([
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'subtotal' => $product->price,
        ]);

        return $order;
    }
}
