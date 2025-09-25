<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_logged_in_user_can_place_an_order_and_stock_is_decremented(): void
    {

        $user = User::factory()->create();

        $product = Product::factory()->create([
            'price' => 150.00,
            'stock' => 10,
        ]);

        // What frontend would send from the cart
        $cartData = [
            'cart' => [
                ['id' => $product->id, 'quantity' => 2]
            ]
        ];

        $response = $this->actingAs($user)->post(route('cart.store'), $cartData);

        $response->assertRedirect(route('welcome'));
        $response->assertSessionHas('success', 'Order placed successfully!');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'total_price' => 300.00, // (150.00 * 2)
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock' => 8, // (Initial 10 - 2)
        ]);
    }

    /** @test */
    public function a_guest_cannot_place_an_order(): void
    {
         $product = Product::factory()->create(['stock' => 10]);
         $cartData = ['cart' => [['id' => $product->id, 'quantity' => 1]]];

        $response = $this->post(route('cart.store'), $cartData);

        $response->assertRedirect(route('login'));
    }
}