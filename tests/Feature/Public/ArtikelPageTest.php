<?php

namespace Tests\Feature\Public;

use App\Models\Artikel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtikelPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_artikel_index_page_returns_200(): void
    {
        $response = $this->get('/artikel');
        $response->assertStatus(200);
    }

    public function test_artikel_index_displays_artikels(): void
    {
        Artikel::factory()->count(3)->create();

        $response = $this->get('/artikel');
        $response->assertStatus(200);
        $response->assertViewHas('artikels');

        $artikels = $response->viewData('artikels');
        $this->assertEquals(3, $artikels->count());
    }

    public function test_artikel_can_be_filtered_by_kategori(): void
    {
        Artikel::factory()->create(['kategori' => 'Kesehatan']);
        Artikel::factory()->create(['kategori' => 'Olahraga']);

        $response = $this->get('/artikel?kategori=Kesehatan');
        $response->assertStatus(200);

        $artikels = $response->viewData('artikels');
        foreach ($artikels as $artikel) {
            $this->assertStringContainsString('Kesehatan', $artikel->kategori);
        }
    }

    public function test_artikel_can_be_searched(): void
    {
        Artikel::factory()->create(['judul' => 'Tips Diet Sehat']);
        Artikel::factory()->create(['judul' => 'Olahraga Pagi']);

        $response = $this->get('/artikel?q=Diet');
        $response->assertStatus(200);

        $artikels = $response->viewData('artikels');
        $this->assertEquals(1, $artikels->count());
    }

    public function test_artikel_detail_page_returns_200(): void
    {
        $artikel = Artikel::factory()->create();

        $response = $this->get('/artikel/' . $artikel->slug);
        $response->assertStatus(200);
    }

    public function test_artikel_detail_increments_dibaca(): void
    {
        $artikel = Artikel::factory()->create(['dibaca' => 0]);

        $this->get('/artikel/' . $artikel->slug);

        $artikel->refresh();
        $this->assertEquals(1, $artikel->dibaca);
    }

    public function test_artikel_detail_nonexistent_slug_returns_404(): void
    {
        $response = $this->get('/artikel/slug-tidak-ada');
        $response->assertStatus(404);
    }
}
