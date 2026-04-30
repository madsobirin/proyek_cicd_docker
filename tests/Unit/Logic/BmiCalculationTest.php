<?php

namespace Tests\Unit\Logic;

use Tests\TestCase;

class BmiCalculationTest extends TestCase
{
    /**
     * Helper: hitung BMI dan tentukan label sesuai logika di HomeController
     */
    private function calculateBmi(float $tinggi, float $berat): array
    {
        $bmi = $berat / pow(($tinggi / 100), 2);

        if ($bmi < 18.5) {
            $label = 'Kurus';
        } elseif ($bmi <= 24.9) {
            $label = 'Normal';
        } elseif ($bmi <= 29.9) {
            $label = 'Berlebih';
        } else {
            $label = 'Obesitas';
        }

        return ['bmi' => round($bmi, 1), 'label' => $label];
    }

    public function test_bmi_underweight(): void
    {
        $result = $this->calculateBmi(170, 45);
        $this->assertEquals('Kurus', $result['label']);
        $this->assertLessThan(18.5, $result['bmi']);
    }

    public function test_bmi_normal(): void
    {
        $result = $this->calculateBmi(170, 65);
        $this->assertEquals('Normal', $result['label']);
        $this->assertGreaterThanOrEqual(18.5, $result['bmi']);
        $this->assertLessThanOrEqual(24.9, $result['bmi']);
    }

    public function test_bmi_overweight(): void
    {
        $result = $this->calculateBmi(170, 80);
        $this->assertEquals('Berlebih', $result['label']);
        $this->assertGreaterThan(24.9, $result['bmi']);
        $this->assertLessThanOrEqual(29.9, $result['bmi']);
    }

    public function test_bmi_obese(): void
    {
        $result = $this->calculateBmi(170, 100);
        $this->assertEquals('Obesitas', $result['label']);
        $this->assertGreaterThan(29.9, $result['bmi']);
    }

    public function test_bmi_boundary_18_5(): void
    {
        // Tinggi 170, Berat ~53.5 → BMI ≈ 18.5
        $result = $this->calculateBmi(170, 53.5);
        // BMI = 53.5 / (1.7^2) = 53.5 / 2.89 = 18.51 → Normal
        $this->assertEquals('Normal', $result['label']);
    }

    public function test_bmi_boundary_25(): void
    {
        // Tinggi 170, Berat ~72.2 → BMI ≈ 24.98
        $result = $this->calculateBmi(170, 72.2);
        $this->assertEquals('Normal', $result['label']);
    }

    public function test_bmi_boundary_30(): void
    {
        // Tinggi 170, Berat ~86.7 → BMI ≈ 30.0
        $result = $this->calculateBmi(170, 86.7);
        $this->assertEquals('Obesitas', $result['label']);
    }
}
