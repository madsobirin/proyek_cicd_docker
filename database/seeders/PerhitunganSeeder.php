<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PerhitunganSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('perhitungan')->insert([
            [
                'user_id' => null, // kalau belum pakai auth user, bisa null
                'tinggi_badan' => 170,
                'berat_badan' => 60,
                'bmi' => round(60 / ((170/100) * (170/100)), 2), // hasil: 20.76
                'status' => 'Normal / Ideal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => null,
                'tinggi_badan' => 165,
                'berat_badan' => 45,
                'bmi' => round(45 / ((165/100) * (165/100)), 2), // hasil: 16.53
                'status' => 'Kurus',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => null,
                'tinggi_badan' => 175,
                'berat_badan' => 90,
                'bmi' => round(90 / ((175/100) * (175/100)), 2), // hasil: 29.39
                'status' => 'Gemuk (Overweight)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
