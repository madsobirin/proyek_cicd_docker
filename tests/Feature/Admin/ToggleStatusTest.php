<?php

namespace Tests\Feature\Admin;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToggleStatusTest extends TestCase
{
    use RefreshDatabase;

    private Account $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Account::factory()->admin()->create();
    }

    public function test_can_toggle_user_status_active_to_inactive(): void
    {
        $user = Account::factory()->create(['is_active' => true, 'role' => 'user']);

        $response = $this->actingAs($this->admin)
            ->post('/admin/users/' . $user->id . '/toggle-status');

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertFalse($user->is_active);
    }

    public function test_can_toggle_user_status_inactive_to_active(): void
    {
        $user = Account::factory()->inactive()->create(['role' => 'user']);

        $response = $this->actingAs($this->admin)
            ->post('/admin/users/' . $user->id . '/toggle-status');

        $user->refresh();
        $this->assertTrue($user->is_active);
    }

    public function test_cannot_toggle_admin_status(): void
    {
        $otherAdmin = Account::factory()->admin()->create();

        $response = $this->actingAs($this->admin)
            ->post('/admin/users/' . $otherAdmin->id . '/toggle-status');

        $response->assertSessionHas('error');
    }

    public function test_toggle_nonexistent_user_returns_404(): void
    {
        $response = $this->actingAs($this->admin)
            ->post('/admin/users/99999/toggle-status');

        $response->assertStatus(404);
    }

    public function test_guest_cannot_toggle_status(): void
    {
        $user = Account::factory()->create();

        $response = $this->post('/admin/users/' . $user->id . '/toggle-status');
        $response->assertRedirect(route('login'));
    }
}
