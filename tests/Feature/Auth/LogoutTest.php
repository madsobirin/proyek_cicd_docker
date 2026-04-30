<?php

namespace Tests\Feature\Auth;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_logout(): void
    {
        $account = Account::factory()->create();
        $this->actingAs($account);

        $response = $this->post('/logout');

        $this->assertGuest();
    }

    public function test_logout_redirects_to_login_with_success(): void
    {
        $account = Account::factory()->create();
        $this->actingAs($account);

        $response = $this->post('/logout');

        $response->assertRedirect(route('login'));
        $response->assertSessionHas('success');
    }
}
