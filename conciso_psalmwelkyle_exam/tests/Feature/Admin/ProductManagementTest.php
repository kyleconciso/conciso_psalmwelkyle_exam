<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_admin_can_create_a_product(): void
    {
        $adminUser = User::factory()->create(['role' => 'Admin']);

        $productData = [
            'name' => 'Gadget',
            'price' => 99.99,
            'stock' => 100,
        ];

        $response = $this->actingAs($adminUser)->post(route('admin.products.store'), $productData);

        $response->assertRedirect(route('admin.products.index'));
        
        $this->assertDatabaseHas('products', [
            'name' => 'Gadget',
            'price' => 99.99,
        ]);
    }
}