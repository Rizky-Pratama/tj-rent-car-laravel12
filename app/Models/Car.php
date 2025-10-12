<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mobil extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'mobil';

    protected $fillable = [
        'nama_mobil',
        'merk',
        'model',
        'plat_nomor',
        'tahun',
        'foto',
        'transmisi',
        'jenis_bahan_bakar',
        'warna',
        'kapasitas_penumpang',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tahun' => 'integer',
            'kapasitas_penumpang' => 'integer',
        ];
    }

    // Relationships
    public function hargaSewa()
    {
        return $this->hasMany(HargaSewa::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Scopes
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeDisewa($query)
    {
        return $query->where('status', 'disewa');
    }

    // Accessors
    public function getFotoUrlAttribute()
    {
        return $this->foto ? asset('storage/' . $this->foto) : asset('images/no-car.png');
    }

    public function getNamaLengkapAttribute()
    {
        return trim($this->merk . ' ' . $this->model . ' ' . $this->nama_mobil);
    }
}
