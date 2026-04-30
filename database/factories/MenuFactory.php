<?php

namespace Database\Factories;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\Factory;

class MenuFactory extends Factory
{
    protected $model = Menu::class;

    public function definition(): array
    {
        return [
            'nama_menu'     => fake()->words(3, true),
            'deskripsi'     => fake()->paragraph(),
            'kalori'        => fake()->numberBetween(100, 800),
            'target_status' => fake()->randomElement(['Kurus', 'Normal', 'Berlebih', 'Obesitas']),
            'waktu_memasak' => fake()->numberBetween(10, 120),
            'gambar'        => null,
            'dibaca'        => 0,
        ];
    }
}
