<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCRUDTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_users_list_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($admin)
            ->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee($admin->name);
        $response->assertSee($user->name);
    }

    public function test_regular_user_cannot_view_users_list_page()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)
            ->get(route('admin.users.index'));

        $response->assertStatus(403);
    }

    public function test_admin_can_create_new_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'Budi User Baru',
                'email' => 'budi@eventapp.com',
                'role' => 'user',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Budi User Baru',
            'email' => 'budi@eventapp.com',
            'role' => 'user',
        ]);
    }

    public function test_admin_can_edit_existing_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['name' => 'Old Name', 'role' => 'user']);

        $response = $this->actingAs($admin)
            ->patch(route('admin.users.update', $user), [
                'name' => 'New Updated Name',
                'email' => $user->email,
                'role' => 'admin', // Promote to admin
            ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Updated Name',
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_delete_other_user()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_themselves()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)
            ->delete(route('admin.users.destroy', $admin));

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Anda tidak dapat menghapus akun Anda sendiri! ❌');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }
}
