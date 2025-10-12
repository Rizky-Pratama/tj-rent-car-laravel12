<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSewa extends Model
{
    use HasFactory;

    protected $table = 'jenis_sewa';

    protected $fillable = [
        'nama_jenis',
        'slug',
        'deskripsi',
        'tarif_denda_per_hari',
    ];

    protected function casts(): array
    {
        return [
            'tarif_denda_per_hari' => 'integer',
        ];
    }

    // Relationships
    public function hargaSewa()
    {
        return $this->hasMany(HargaSewa::class);
    }

    // Route Model Binding
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
