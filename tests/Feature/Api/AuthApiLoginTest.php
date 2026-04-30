<?php

namespace Tests\Feature\Api;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthApiLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_login_success(): void
    {
        $account = Account::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => $account->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'user',
            'token',
        ]);
    }

    public function test_api_login_wrong_credentials(): void
    {
        $account = Account::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => $account->email,
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Login gagal',
        ]);
    }

    public function test_api_login_returns_user_data(): void
    {
        $account = Account::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => $account->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('user.email', $account->email);
    }

    public function test_api_login_returns_valid_sanctum_token(): void
    {
        $account = Account::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email'    => $account->email,
            'password' => 'password123',
        ]);

        $token = $response->json('token');
        $this->assertNotEmpty($token);
        $this->assertIsString($token);
    }
}
