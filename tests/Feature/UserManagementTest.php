<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_super_admin_can_view_user_list(): void
    {
        $superAdmin = User::factory()->create(['name' => 'Super Admin']);
        $user = User::factory()->create(['name' => 'Blocked Candidate']);

        Role::create(['name' => 'super_admin']);
        $superAdmin->assignRole('super_admin');

        $response = $this->actingAs($superAdmin)->get(route('users.index'));

        $response->assertOk();
        $response->assertSee('Blocked Candidate');
        $response->assertSee($user->email);
    }

    public function test_non_super_admin_can_not_view_user_list(): void
    {
        $admin = User::factory()->create();

        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('users.index'));

        $response->assertForbidden();
    }

    public function test_non_super_admin_can_not_block_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create(['is_blocked' => false]);

        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->patch(route('users.block', $user))
            ->assertForbidden();

        $this->assertFalse($user->fresh()->is_blocked);
    }

    public function test_non_super_admin_can_not_unblock_user(): void
    {
        $admin = User::factory()->create();
        $user = User::factory()->create(['is_blocked' => true]);

        Role::create(['name' => 'admin']);
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->patch(route('users.unblock', $user))
            ->assertForbidden();

        $this->assertTrue($user->fresh()->is_blocked);
    }

    public function test_super_admin_can_block_and_unblock_user(): void
    {
        $superAdmin = User::factory()->create();
        $user = User::factory()->create(['is_blocked' => false]);

        Role::create(['name' => 'super_admin']);
        $superAdmin->assignRole('super_admin');

        $this->actingAs($superAdmin)
            ->patch(route('users.block', $user))
            ->assertRedirect(route('users.index'));

        $this->assertTrue($user->fresh()->is_blocked);

        $this->actingAs($superAdmin)
            ->patch(route('users.unblock', $user))
            ->assertRedirect(route('users.index'));

        $this->assertFalse($user->fresh()->is_blocked);
    }
}
