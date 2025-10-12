<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksi';

    protected $fillable = [
        'no_transaksi',
        'pelanggan_id',
        'mobil_id',
        'harga_sewa_id',
        'sopir_id',
        'tanggal_sewa',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'durasi_hari',
        'subtotal',
        'biaya_tambahan',
        'denda',
        'denda_manual',
        'total',
        'status_pembayaran',
        'status',
        'catatan',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_sewa' => 'datetime',
            'tanggal_kembali' => 'datetime',
            'tanggal_dikembalikan' => 'datetime',
            'durasi_hari' => 'integer',
            'subtotal' => 'integer',
            'biaya_tambahan' => 'integer',
            'denda' => 'integer',
            'denda_manual' => 'integer',
            'total' => 'integer',
        ];
    }

    // Relationships
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function hargaSewa()
    {
        return $this->belongsTo(HargaSewa::class);
    }

    public function sopir()
    {
        return $this->belongsTo(Sopir::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function dibuatOleh()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    // Accessors
    public function getDurasiHariCalculatedAttribute()
    {
        return $this->tanggal_sewa->diffInDays($this->tanggal_kembali);
    }

    public function getIsOverdueAttribute()
    {
        return $this->status === 'berjalan' && Carbon::now() > $this->tanggal_kembali;
    }

    public function getTotalPembayaranAttribute()
    {
        return $this->pembayaran()->where('status', 'terkonfirmasi')->sum('jumlah');
    }

    public function getSisaPembayaranAttribute()
    {
        return $this->total - $this->total_pembayaran;
    }

    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'berjalan');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'selesai');
    }
}
