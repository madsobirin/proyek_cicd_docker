<?php

namespace Tests\Feature\Public;

use App\Models\Account;
use App\Models\Artikel;
use App\Models\Menu;
use App\Models\Perhitungan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KalkulatorTest extends TestCase
{
    use RefreshDatabase;

    public function test_kalkulator_page_returns_200(): void
    {
        $response = $this->get('/kalkulator');
        $response->assertStatus(200);
    }

    public function test_kalkulator_post_returns_redirect_with_hasil(): void
    {
        $response = $this->post('/kalkulator', [
            'gender' => 'male',
            'tinggi' => 170,
            'berat'  => 65,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('hasil');
        $response->assertSessionHas('status_bmi');
    }

    public function test_bmi_saves_to_database_when_authenticated(): void
    {
        $account = Account::factory()->create();

        $this->actingAs($account)->post('/kalkulator', [
            'gender' => 'male',
            'tinggi' => 170,
            'berat'  => 65,
        ]);

        $this->assertDatabaseHas('perhitungan', [
            'user_id'      => $account->id,
            'tinggi_badan' => 170,
            'berat_badan'  => 65,
        ]);
    }

    public function test_bmi_does_not_save_when_guest(): void
    {
        $this->post('/kalkulator', [
            'gender' => 'male',
            'tinggi' => 170,
            'berat'  => 65,
        ]);

        $this->assertDatabaseCount('perhitungan', 0);
    }

    public function test_kalkulator_validation_requires_fields(): void
    {
        $response = $this->post('/kalkulator', []);

        $response->assertSessionHasErrors(['gender', 'tinggi', 'berat']);
    }

    public function test_bmi_result_includes_rekomendasi(): void
    {
        // Buat menu dengan status Normal
        Menu::factory()->create(['target_status' => 'Normal']);

        $response = $this->post('/kalkulator', [
            'gender' => 'male',
            'tinggi' => 170,
            'berat'  => 65,
        ]);

        $response->assertSessionHas('rekomendasi_menu');
        $response->assertSessionHas('artikel_terkait');
    }
}
