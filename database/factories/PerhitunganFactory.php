<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Perhitungan;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerhitunganFactory extends Factory
{
    protected $model = Perhitungan::class;

    public function definition(): array
    {
        $tinggi = fake()->numberBetween(150, 190);
        $berat  = fake()->numberBetween(40, 120);
        $bmi    = $berat / pow(($tinggi / 100), 2);

        if ($bmi < 18.5) {
            $status = 'Kurus';
        } elseif ($bmi <= 24.9) {
            $status = 'Normal';
        } elseif ($bmi <= 29.9) {
            $status = 'Berlebih';
        } else {
            $status = 'Obesitas';
        }

        return [
            'user_id'      => Account::factory(),
            'tinggi_badan' => $tinggi,
            'berat_badan'  => $berat,
            'bmi'          => round($bmi, 1),
            'status'       => $status,
        ];
    }
}
