<?php

namespace Tests\Feature\Admin;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase;

    private Account $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Account::factory()->admin()->create();
    }

    public function test_index_returns_200(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/users');
        $response->assertStatus(200);
    }

    public function test_index_displays_users(): void
    {
        Account::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/users');
        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    public function test_can_store_new_user(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => 'User Baru',
            'username'     => 'userbaru',
            'email'        => 'userbaru@example.com',
            'password'     => 'password123',
            'role'         => 'user',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('accounts', [
            'username' => 'userbaru',
            'email'    => 'userbaru@example.com',
        ]);
    }

    public function test_password_is_hashed_on_create(): void
    {
        $this->actingAs($this->admin)->post('/admin/users', [
            'nama_lengkap' => 'Hash Test',
            'username'     => 'hashtest',
            'email'        => 'hashtest@example.com',
            'password'     => 'password123',
            'role'         => 'user',
        ]);

        $user = Account::where('email', 'hashtest@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function test_can_update_user(): void
    {
        $user = Account::factory()->create();

        $response = $this->actingAs($this->admin)->put('/admin/users/' . $user->id, [
            'nama_lengkap' => 'Nama Updated',
            'username'     => $user->username,
            'email'        => $user->email,
            'role'         => 'user',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $user->refresh();
        $this->assertEquals('Nama Updated', $user->nama_lengkap);
    }

    public function test_can_delete_user(): void
    {
        $user = Account::factory()->create();

        $response = $this->actingAs($this->admin)->delete('/admin/users/' . $user->id);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('accounts', ['id' => $user->id]);
    }

    public function test_search_users(): void
    {
        Account::factory()->create(['nama_lengkap' => 'John Doe']);
        Account::factory()->create(['nama_lengkap' => 'Jane Smith']);

        $response = $this->actingAs($this->admin)->get('/admin/users?search=John');
        $response->assertStatus(200);
    }

    public function test_guest_cannot_access_admin_users(): void
    {
        $response = $this->get('/admin/users');
        $response->assertRedirect(route('auth.login'));
    }

    public function test_non_admin_cannot_access_admin_users(): void
    {
        $user = Account::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/users');
        $response->assertStatus(403);
    }
}
