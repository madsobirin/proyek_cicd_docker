<?php

namespace Tests\Feature\Auth;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_returns_200(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_user_can_register_successfully(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('auth.login'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('accounts', [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'role'     => 'user',
        ]);
    }

    public function test_password_is_hashed_on_registration(): void
    {
        $this->post('/register', [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'password' => 'password123',
        ]);

        $account = Account::where('email', 'testuser@example.com')->first();
        $this->assertNotNull($account);
        $this->assertTrue(Hash::check('password123', $account->password));
        $this->assertNotEquals('password123', $account->password);
    }

    public function test_register_fails_with_duplicate_email(): void
    {
        Account::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->post('/register', [
            'username' => 'another',
            'email'    => 'duplicate@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_register_fails_with_short_password(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email'    => 'testuser@example.com',
            'password' => '123',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
