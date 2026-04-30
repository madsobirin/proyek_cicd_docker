<?php

namespace Tests\Feature\Public;

use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_menu_index_page_returns_200(): void
    {
        $response = $this->get('/menu');
        $response->assertStatus(200);
    }

    public function test_menu_index_displays_menus(): void
    {
        Menu::factory()->count(5)->create();

        $response = $this->get('/menu');
        $response->assertStatus(200);
        $response->assertViewHas('menus');

        $menus = $response->viewData('menus');
        $this->assertEquals(5, $menus->count());
    }

    public function test_menu_can_be_searched(): void
    {
        Menu::factory()->create(['nama_menu' => 'Salad Buah Segar']);
        Menu::factory()->create(['nama_menu' => 'Nasi Goreng']);

        $response = $this->get('/menu?search=Salad');
        $response->assertStatus(200);

        $menus = $response->viewData('menus');
        $this->assertEquals(1, $menus->count());
    }

    public function test_menu_can_be_filtered_by_status(): void
    {
        Menu::factory()->create(['target_status' => 'Normal']);
        Menu::factory()->create(['target_status' => 'Kurus']);

        $response = $this->get('/menu?status=Normal');
        $response->assertStatus(200);

        $menus = $response->viewData('menus');
        foreach ($menus as $menu) {
            $this->assertEquals('Normal', $menu->target_status);
        }
    }

    public function test_menu_detail_page_returns_200(): void
    {
        $menu = Menu::factory()->create();

        $response = $this->get('/menu/' . $menu->id);
        $response->assertStatus(200);
    }

    public function test_menu_detail_increments_dibaca(): void
    {
        $menu = Menu::factory()->create(['dibaca' => 0]);

        $this->get('/menu/' . $menu->id);

        $menu->refresh();
        $this->assertEquals(1, $menu->dibaca);
    }

    public function test_menu_detail_nonexistent_returns_404(): void
    {
        $response = $this->get('/menu/99999');
        $response->assertStatus(404);
    }
}
