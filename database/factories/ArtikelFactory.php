<?php

namespace Database\Factories;

use App\Models\Artikel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ArtikelFactory extends Factory
{
    protected $model = Artikel::class;

    public function definition(): array
    {
        $judul = fake()->sentence(4);

        return [
            'kategori'    => fake()->randomElement(['Kesehatan', 'Olahraga', 'Nutrisi', 'Diet']),
            'judul'       => $judul,
            'slug'        => Str::slug($judul) . '-' . Str::random(5),
            'isi'         => fake()->paragraphs(3, true),
            'gambar'      => null,
            'penulis'     => fake()->name(),
            'is_featured' => false,
            'dibaca'      => 0,
        ];
    }

    /**
     * State: artikel featured
     */
    public function featured(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_featured' => true,
        ]);
    }
}
