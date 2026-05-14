<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pengaduan; // <-- Tambahkan ini
use App\Models\User;      // <-- Tambahkan ini

class Tanggapan extends Model
{
    // Tambahkan $fillable agar nanti bisa insert data tanggapan dengan aman
    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'isi_tanggapan',
    ];

    // Relasi: 1 Tanggapan dimiliki oleh 1 Pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    // Relasi: 1 Tanggapan ditulis oleh 1 User (Petugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}