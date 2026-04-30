<?php

namespace Tests\Unit\Models;

use App\Models\Kategori;
use App\Models\Artikel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KategoriTest extends TestCase
{
    use RefreshDatabase;

    public function test_fillable_attributes(): void
    {
        $kategori = new Kategori();
        $this->assertEquals(['nama_kategori'], $kategori->getFillable());
    }

    public function test_primary_key_is_id_kategori(): void
    {
        $kategori = new Kategori();
        $this->assertEquals('id_kategori', $kategori->getKeyName());
    }

    public function test_table_name(): void
    {
        $kategori = new Kategori();
        $this->assertEquals('kategori', $kategori->getTable());
    }

    public function test_incrementing_is_true(): void
    {
        $kategori = new Kategori();
        $this->assertTrue($kategori->getIncrementing());
    }

    public function test_key_type_is_int(): void
    {
        $kategori = new Kategori();
        $this->assertEquals('int', $kategori->getKeyType());
    }

    public function test_artikels_relationship(): void
    {
        $kategori = new Kategori();
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $kategori->artikels()
        );
    }
}
