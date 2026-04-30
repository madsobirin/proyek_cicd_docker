<?php

namespace Tests\Feature\Public;

use App\Models\Artikel;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_returns_200(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function test_home_page_displays_featured_menus(): void
    {
        Menu::factory()->count(8)->create();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('featuredMenus');

        $menus = $response->viewData('featuredMenus');
        $this->assertLessThanOrEqual(6, $menus->count());
    }

    public function test_home_page_displays_latest_articles(): void
    {
        Artikel::factory()->count(6)->create();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewHas('latestArticles');

        $articles = $response->viewData('latestArticles');
        $this->assertLessThanOrEqual(4, $articles->count());
    }

    public function test_home_page_has_hero_highlight(): void
    {
        Artikel::factory()->create(['judul' => 'Artikel Pertama']);

        $response = $this->get('/');
        $response->assertViewHas('heroHighlight');
    }
}
