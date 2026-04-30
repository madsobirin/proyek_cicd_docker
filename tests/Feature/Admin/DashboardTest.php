<?php

namespace Tests\Feature\Admin;

use App\Models\Account;
use App\Models\Artikel;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_returns_200_for_admin(): void
    {
        $admin = Account::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);
    }

    public function test_admin_dashboard_shows_statistics(): void
    {
        $admin = Account::factory()->admin()->create();
        Account::factory()->count(3)->create();
        Menu::factory()->count(5)->create();
        Artikel::factory()->count(2)->create();

        $response = $this->actingAs($admin)->get('/admin');
        $response->assertStatus(200);

        // Hitung: 3 user + 1 admin = 4
        $response->assertViewHas('userCount', 4);
        $response->assertViewHas('menuCount', 5);
        $response->assertViewHas('artikelCount', 2);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_user_cannot_access_admin_dashboard(): void
    {
        $user = Account::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }
}
