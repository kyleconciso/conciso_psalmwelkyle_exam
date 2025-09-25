<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    // Reset database after test
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_view_the_user_management_page(): void
    {
        $guestUser = User::factory()->create([
            'role' => 'Guest',
        ]);

        $response = $this->actingAs($guestUser)->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    /** @test */
    public function an_admin_can_view_the_user_management_page(): void
    {
        $adminUser = User::factory()->create([
            'role' => 'Admin',
        ]);

        $response = $this->actingAs($adminUser)->get(route('admin.users.index'));

        $response->assertStatus(200);

        $response->assertInertia(fn ($page) => $page->component('Admin/Users/Index'));
    }
}