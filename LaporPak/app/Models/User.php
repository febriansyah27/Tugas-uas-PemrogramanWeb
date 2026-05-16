<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: satu user punya banyak pengaduan
    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }

    // Relasi: satu user (petugas) bisa banyak tanggapan
    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class);
    }

    // Helper: cek apakah user adalah petugas
    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }
}
