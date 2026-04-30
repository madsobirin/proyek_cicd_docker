<?php

namespace Tests\Unit\Models;

use App\Models\Menu;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MenuTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $menu = new Menu();

        $expected = [
            'nama_menu', 'deskripsi', 'kalori',
            'target_status', 'waktu_memasak', 'gambar', 'dibaca',
        ];

        $this->assertEquals($expected, $menu->getFillable());
    }

    public function test_table_name(): void
    {
        $menu = new Menu();
        $this->assertEquals('menus', $menu->getTable());
    }

    public function test_uses_has_factory_trait(): void
    {
        $this->assertContains(
            \Illuminate\Database\Eloquent\Factories\HasFactory::class,
            class_uses_recursive(Menu::class)
        );
    }

    public function test_can_create_menu_via_factory(): void
    {
        $menu = Menu::factory()->create();

        $this->assertDatabaseHas('menus', [
            'id'        => $menu->id,
            'nama_menu' => $menu->nama_menu,
        ]);
    }
}
