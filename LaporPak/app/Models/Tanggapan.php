<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanggapan extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'user_id',
        'isi_tanggapan',
    ];

    // Relasi: tanggapan milik satu pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    // Relasi: tanggapan dibuat oleh satu user (petugas)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
