<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;        // <-- Tambahkan ini
use App\Models\Tanggapan;   // <-- Tambahkan ini

class Pengaduan extends Model
{
    // Tambahkan $fillable untuk keamanan insert data
    protected $fillable = [
        'user_id',
        'judul',
        'isi_laporan',
        'alamat',
        'foto',
        'status',
    ];

    // Relasi: 1 Pengaduan dimiliki oleh 1 User (Warga yang melapor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: 1 Pengaduan bisa memiliki banyak Tanggapan
    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class);
    }
}