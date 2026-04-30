<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Account extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $table = 'accounts';

    protected $fillable = [
        'nama_lengkap',
        'username',
        'email',
        'password',
        'role',
        'is_active',
        'last_login_at',
        'phone',
        'birthdate',
        'weight',
        'height',
        'photo',
        'google_id',
        'google_avatar',
    ];

    public $timestamps = true;

    protected $casts = [
        'is_active'     => 'boolean',
        'last_login_at' => 'datetime',
        'birthdate'     => 'date'
    ];

    public function getNameAttribute()
    {
        return $this->nama_lengkap ?? $this->username;
    }

    public function getBirthdateAttribute($value)
    {
        return $value;
    }
    public function perhitungans()
    {
        return $this->hasMany(Perhitungan::class, 'user_id');
    }
}
