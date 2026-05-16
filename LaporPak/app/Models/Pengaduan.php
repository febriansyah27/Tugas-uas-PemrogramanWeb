<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'judul',
        'isi_laporan',
        'alamat',
        'foto',
        'status',
        'last_response_read_at',
        'deadline',
    ];

    // Relasi: pengaduan dimiliki satu user (warga)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: satu pengaduan bisa punya banyak tanggapan
    public function tanggapans()
    {
        return $this->hasMany(Tanggapan::class);
    }

    public function isUnread(): bool
    {
        if ($this->tanggapans->isEmpty()) {
            return false;
        }

        $lastResponse = $this->tanggapans->sortByDesc('created_at')->first();
        return $this->last_response_read_at === null ||
               $lastResponse->created_at > $this->last_response_read_at;
    }

    public function markResponseAsRead(): void
    {
        $this->update(['last_response_read_at' => now()]);
    }

    public function isOverdue(): bool
    {
        return $this->deadline && now()->isAfter($this->deadline) && $this->status !== 'selesai';
    }

    public function getDaysUntilDeadline(): ?int
    {
        if (!$this->deadline) return null;
        return now()->diffInDays($this->deadline, false);
    }
}
