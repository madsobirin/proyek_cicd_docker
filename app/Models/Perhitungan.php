<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perhitungan extends Model
{
    use HasFactory;

    // Nama tabel di database Anda
    protected $table = 'perhitungan';

    // Kolom yang boleh diisi (Mass Assignable)
    protected $fillable = [
        'user_id',
        'tinggi_badan',
        'berat_badan',
        'bmi',
        'status',
    ];

    /**
     * Relasi ke model Account (User)
     */
    public function account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'id');
    }
}
