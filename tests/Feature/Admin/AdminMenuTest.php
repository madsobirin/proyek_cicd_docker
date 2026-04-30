<?php

namespace Tests\Feature\Admin;

use App\Models\Account;
use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminMenuTest extends TestCase
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
        $response = $this->actingAs($this->admin)->get('/admin/menu');
        $response->assertStatus(200);
    }

    public function test_create_page_returns_200(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/menu/create');
        $response->assertStatus(200);
    }

    public function test_can_store_new_menu(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/menu', [
            'nama_menu'     => 'Salad Buah',
            'target_status' => 'Normal',
            'deskripsi'     => 'Salad buah segar dan sehat.',
            'kalori'        => 150,
            'waktu_memasak' => 15,
        ]);

        $response->assertRedirect(route('admin.menu.index'));
        $this->assertDatabaseHas('menus', [
            'nama_menu' => 'Salad Buah',
        ]);
    }

    public function test_can_update_menu(): void
    {
        $menu = Menu::factory()->create();

        $response = $this->actingAs($this->admin)->put('/admin/menu/' . $menu->id, [
            'nama_menu'     => 'Salad Updated',
            'target_status' => 'Kurus',
            'deskripsi'     => 'Deskripsi baru.',
        ]);

        $response->assertRedirect(route('admin.menu.index'));
        $menu->refresh();
        $this->assertEquals('Salad Updated', $menu->nama_menu);
    }

    public function test_can_delete_menu(): void
    {
        $menu = Menu::factory()->create();

        $response = $this->actingAs($this->admin)->delete('/admin/menu/' . $menu->id);
        $this->assertDatabaseMissing('menus', ['id' => $menu->id]);
    }

    public function test_store_validation_requires_nama_menu(): void
    {
        $response = $this->actingAs($this->admin)->post('/admin/menu', [
            'target_status' => 'Normal',
        ]);

        $response->assertSessionHasErrors('nama_menu');
    }

    public function test_guest_cannot_access_admin_menu(): void
    {
        $response = $this->get('/admin/menu');
        $response->assertRedirect(route('login'));
    }

    public function test_non_admin_cannot_access_admin_menu(): void
    {
        $user = Account::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/menu');
        $response->assertStatus(403);
    }
}
