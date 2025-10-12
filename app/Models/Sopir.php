<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sopir extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sopir';

    protected $fillable = [
        'nama',
        'telepon',
        'no_sim',
        'status',
        'catatan',
    ];

    // Relationships
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Scopes
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }

    public function scopeDitugaskan($query)
    {
        return $query->where('status', 'ditugaskan');
    }
}
