<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_a_regular_user(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $user = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.deleteUser', $user));

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
        ]);
    }

    public function test_admin_cannot_delete_another_admin(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $protectedUser = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.deleteUser', $protectedUser));

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $protectedUser->id,
        ]);
    }

    public function test_admin_cannot_delete_an_owner(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $protectedUser = User::factory()->create(['is_owner' => true]);

        $response = $this->actingAs($admin)->post(route('admin.deleteUser', $protectedUser));

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $protectedUser->id,
        ]);
    }

    public function test_admin_cannot_delete_self(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->post(route('admin.deleteUser', $admin));

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }
}
