<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelanggan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pelanggan';

    protected $fillable = [
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_ktp',
        'foto_ktp',
        'no_sim',
        'foto_sim',
        'pekerjaan',
        'catatan',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    // Relationships
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    // Accessors
    public function getFotoKtpUrlAttribute()
    {
        return $this->foto_ktp ? asset('storage/' . $this->foto_ktp) : null;
    }

    public function getFotoSimUrlAttribute()
    {
        return $this->foto_sim ? asset('storage/' . $this->foto_sim) : null;
    }

    public function getUmurAttribute()
    {
        return $this->tanggal_lahir ? $this->tanggal_lahir->age : null;
    }

    public function getNamaLengkapAttribute()
    {
        return $this->nama . ' (' . $this->no_ktp . ')';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Mutators
    public function setNamaAttribute($value)
    {
        $this->attributes['nama'] = ucwords(strtolower($value));
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    public function setNoKtpAttribute($value)
    {
        $this->attributes['no_ktp'] = preg_replace('/[^0-9]/', '', $value);
    }

    public function setTeleponAttribute($value)
    {
        $this->attributes['telepon'] = preg_replace('/[^0-9+]/', '', $value);
    }
}
