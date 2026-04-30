<?php

namespace Database\Factories;

use App\Models\Account;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountFactory extends Factory
{
    protected $model = Account::class;

    protected static ?string $password;

    public function definition(): array
    {
        return [
            'nama_lengkap' => fake()->name(),
            'username'      => fake()->unique()->userName(),
            'email'         => fake()->unique()->safeEmail(),
            'password'      => static::$password ??= Hash::make('password'),
            'role'          => 'user',
            'is_active'     => true,
        ];
    }

    /**
     * State: akun admin
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * State: akun nonaktif
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
