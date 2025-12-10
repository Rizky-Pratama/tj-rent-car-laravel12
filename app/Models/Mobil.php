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
        return $this->hasMany(HargaSewa::class, 'mobil_id');
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'mobil_id');
    }

    // Scopes
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', '!=', 'nonaktif');
    }

    /**
     * Scope untuk menerapkan semua filter sekaligus
     */
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['search'] ?? null, function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('nama_mobil', 'like', "%{$search}%")
                        ->orWhere('merk', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('plat_nomor', 'like', "%{$search}%")
                        ->orWhere('warna', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, fn($q, $status) => $q->where('status', $status))
            ->when($filters['brand'] ?? null, fn($q, $brand) => $q->where('merk', $brand))
            ->when($filters['transmisi'] ?? null, fn($q, $transmisi) => $q->where('transmisi', $transmisi));
    }

    // Mutators
    public function setNamaMobilAttribute($value)
    {
        $this->attributes['nama_mobil'] = ucfirst($value);
    }

    // Accessors
    public function getNamaLengkapAttribute()
    {
        return "{$this->merk} {$this->model} ({$this->tahun})";
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'tersedia' => 'success',
            'disewa' => 'warning',
            'perawatan' => 'info',
            'nonaktif' => 'danger'
        ];

        return $badges[$this->status] ?? 'secondary';
    }
}
