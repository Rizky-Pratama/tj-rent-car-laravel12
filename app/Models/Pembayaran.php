<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'transaksi_id',
        'jumlah',
        'metode',
        'status',
        'tanggal_bayar',
        'bukti_bayar',
        'catatan',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'jumlah' => 'integer',
            'tanggal_bayar' => 'datetime',
        ];
    }

    // Relationships
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    // Accessors
    public function getBuktiBayarUrlAttribute()
    {
        return $this->bukti_bayar ? asset('storage/' . $this->bukti_bayar) : null;
    }

    public function getFormattedJumlahAttribute()
    {
        return 'Rp ' . number_format($this->jumlah, 0, ',', '.');
    }

    // Scopes
    public function scopeTerkonfirmasi($query)
    {
        return $query->where('status', 'terkonfirmasi');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
