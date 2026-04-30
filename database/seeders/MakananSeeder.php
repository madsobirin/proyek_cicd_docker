<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MakananSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('makanan')->insert([
            [
                'nama_makanan' => 'Salad Buah',
                'kalori' => 150,
                'protein' => 2.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_makanan' => 'Jus Alpukat',
                'kalori' => 200,
                'protein' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_makanan' => 'Sayur Sop',
                'kalori' => 100,
                'protein' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
