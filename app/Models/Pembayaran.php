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

    public function scopeFilter($query, $filters = [])
    {
        // Filter berdasarkan periode waktu
        if (isset($filters['period']) && $filters['period']) {
            switch ($filters['period']) {
                case 'today':
                    $query->whereDate('created_at', \Carbon\Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', \Carbon\Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [
                        \Carbon\Carbon::now()->startOfWeek(),
                        \Carbon\Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', \Carbon\Carbon::now()->month)
                          ->whereYear('created_at', \Carbon\Carbon::now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', \Carbon\Carbon::now()->subMonth()->month)
                          ->whereYear('created_at', \Carbon\Carbon::now()->subMonth()->year);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', \Carbon\Carbon::now()->year);
                    break;
                case 'custom':
                    if (isset($filters['date_from']) && isset($filters['date_to'])) {
                        $query->whereBetween('created_at', [
                            \Carbon\Carbon::parse($filters['date_from'])->startOfDay(),
                            \Carbon\Carbon::parse($filters['date_to'])->endOfDay()
                        ]);
                    }
                    break;
            }
        }

        // Filter berdasarkan status
        if (isset($filters['status']) && $filters['status'] !== 'all' && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        // Filter berdasarkan metode pembayaran
        if (isset($filters['metode']) && $filters['metode'] !== 'all' && $filters['metode']) {
            $query->where('metode', $filters['metode']);
        }

        // Filter berdasarkan pencarian
        if (isset($filters['search']) && $filters['search']) {
            $search = '%' . $filters['search'] . '%';
            $query->whereHas('transaksi', function($q) use ($search) {
                $q->where('no_transaksi', 'like', $search)
                  ->orWhereHas('pelanggan', function($q2) use ($search) {
                      $q2->where('nama', 'like', $search)
                         ->orWhere('telepon', 'like', $search);
                  });
            });
        }

        return $query;
    }
}
