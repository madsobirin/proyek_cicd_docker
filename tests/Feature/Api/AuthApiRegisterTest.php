<?php

namespace Tests\Feature\Api;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiRegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_register_success(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'     => 'Test User',
            'email'    => 'newuser@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'user',
            'token',
        ]);

        $this->assertDatabaseHas('accounts', [
            'email' => 'newuser@example.com',
        ]);
    }

    public function test_api_register_duplicate_email(): void
    {
        Account::factory()->create(['email' => 'existing@example.com']);

        $response = $this->postJson('/api/auth/register', [
            'name'     => 'Another User',
            'email'    => 'existing@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('email');
    }

    public function test_api_register_validation_required_fields(): void
    {
        $response = $this->postJson('/api/auth/register', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['name', 'email', 'password']);
    }

    public function test_api_register_returns_user_and_token(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'name'     => 'Token User',
            'email'    => 'tokenuser@example.com',
            'password' => 'password123',
        ]);

        $response->assertStatus(201);

        $data = $response->json();
        $this->assertArrayHasKey('user', $data);
        $this->assertArrayHasKey('token', $data);
        $this->assertEquals('tokenuser@example.com', $data['user']['email']);
        $this->assertNotEmpty($data['token']);
    }
}
