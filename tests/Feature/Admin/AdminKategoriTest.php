<?php

namespace Tests\Feature\Admin;

use App\Models\Account;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminKategoriTest extends TestCase
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
        $response = $this->actingAs($this->admin)->get('/admin/kategori');
        $response->assertStatus(200);
    }

    public function test_create_page_returns_200(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/kategori/create');
        $response->assertStatus(200);
    }

    public function test_can_store_new_kategori(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/kategori', [
            'nama_kategori' => 'Nutrisi',
        ]);

        $response->assertRedirect(route('admin.kategori.index'));
        $this->assertDatabaseHas('kategori', [
            'nama_kategori' => 'Nutrisi',
        ]);
    }

    public function test_can_update_kategori(): void
    {
        $kategori = Kategori::factory()->create();

        $response = $this->actingAs($this->admin)->put('/admin/kategori/' . $kategori->id_kategori, [
            'nama_kategori' => 'Kategori Updated',
        ]);

        $response->assertRedirect(route('admin.kategori.index'));
        $kategori->refresh();
        $this->assertEquals('Kategori Updated', $kategori->nama_kategori);
    }

    public function test_can_delete_kategori(): void
    {
        $kategori = Kategori::factory()->create();

        $response = $this->actingAs($this->admin)->delete('/admin/kategori/' . $kategori->id_kategori);
        $response->assertRedirect(route('admin.kategori.index'));
        $this->assertDatabaseMissing('kategori', ['id_kategori' => $kategori->id_kategori]);
    }

    public function test_duplicate_nama_kategori_fails(): void
    {
        Kategori::factory()->create(['nama_kategori' => 'Duplikat']);

        $response = $this->actingAs($this->admin)->post('/admin/kategori', [
            'nama_kategori' => 'Duplikat',
        ]);

        $response->assertSessionHasErrors('nama_kategori');
    }

    public function test_guest_cannot_access_admin_kategori(): void
    {
        $response = $this->get('/admin/kategori');
        $response->assertRedirect(route('login'));
    }
}
