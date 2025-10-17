<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HargaSewa extends Model
{
    use HasFactory;

    protected $table = 'harga_sewa';

    protected $fillable = [
        'mobil_id',
        'jenis_sewa_id',
        'harga_per_hari',
        'aktif',
        'catatan'
    ];

    protected $casts = [
        'aktif' => 'boolean'
    ];

    // Relationships
    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    public function jenisSewa()
    {
        return $this->belongsTo(JenisSewa::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    // Accessors
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga_per_hari, 0, ',', '.');
    }
}
