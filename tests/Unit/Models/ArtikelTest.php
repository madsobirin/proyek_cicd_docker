<?php

namespace Tests\Unit\Models;

use App\Models\Artikel;
use App\Models\Kategori;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArtikelTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $artikel = new Artikel();

        $expected = [
            'kategori', 'judul', 'slug', 'isi',
            'gambar', 'penulis', 'is_featured', 'dibaca',
        ];

        $this->assertEquals($expected, $artikel->getFillable());
    }

    public function test_table_name(): void
    {
        $artikel = new Artikel();
        $this->assertEquals('artikels', $artikel->getTable());
    }

    public function test_uses_has_factory_trait(): void
    {
        $this->assertContains(
            \Illuminate\Database\Eloquent\Factories\HasFactory::class,
            class_uses_recursive(Artikel::class)
        );
    }

    public function test_kategori_relationship(): void
    {
        $artikel = new Artikel();
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $artikel->kategori()
        );
    }

    public function test_can_create_artikel_via_factory(): void
    {
        $artikel = Artikel::factory()->create();

        $this->assertDatabaseHas('artikels', [
            'id'    => $artikel->id,
            'judul' => $artikel->judul,
        ]);
    }

    public function test_featured_state(): void
    {
        $artikel = Artikel::factory()->featured()->create();
        $this->assertTrue((bool) $artikel->is_featured);
    }
}
