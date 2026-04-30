<?php

namespace Tests\Feature\Admin;

use App\Models\Account;
use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminArtikelTest extends TestCase
{
    use RefreshDatabase;

    private Account $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = Account::factory()->admin()->create();
    }

    public function test_index_returns_200(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/artikel');
        $response->assertStatus(200);
    }

    public function test_index_displays_artikels(): void
    {
        Artikel::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)->get('/admin/artikel');
        $response->assertStatus(200);
        $response->assertViewHas('data');
    }

    public function test_create_page_returns_200(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/artikel/create');
        $response->assertStatus(200);
    }

    public function test_can_store_new_artikel(): void
    {
        Kategori::factory()->create(['nama_kategori' => 'Kesehatan']);

        $response = $this->actingAs($this->admin)->post('/admin/artikel', [
            'judul'    => 'Artikel Test Baru',
            'isi'      => 'Isi artikel untuk testing.',
            'kategori' => 'Kesehatan',
            'penulis'  => 'Test Author',
        ]);

        $response->assertRedirect(route('admin.artikel.index'));
        $this->assertDatabaseHas('artikels', [
            'judul' => 'Artikel Test Baru',
        ]);
    }

    public function test_can_update_artikel(): void
    {
        Kategori::factory()->create(['nama_kategori' => 'Olahraga']);
        $artikel = Artikel::factory()->create();

        $response = $this->actingAs($this->admin)->put('/admin/artikel/' . $artikel->id, [
            'judul'    => 'Judul Updated',
            'isi'      => 'Isi sudah diupdate.',
            'kategori' => 'Olahraga',
        ]);

        $response->assertRedirect(route('admin.artikel.index'));
        $artikel->refresh();
        $this->assertEquals('Judul Updated', $artikel->judul);
    }

    public function test_can_delete_artikel(): void
    {
        $artikel = Artikel::factory()->create();

        $response = $this->actingAs($this->admin)->delete('/admin/artikel/' . $artikel->id);

        $response->assertRedirect(route('admin.artikel.index'));
        $this->assertDatabaseMissing('artikels', ['id' => $artikel->id]);
    }

    public function test_store_validation_requires_judul(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/artikel', [
            'isi' => 'Isi saja tanpa judul.',
        ]);

        $response->assertSessionHasErrors('judul');
    }

    public function test_guest_cannot_access_admin_artikel(): void
    {
        $response = $this->get('/admin/artikel');
        $response->assertRedirect(route('auth.login'));
    }
}
