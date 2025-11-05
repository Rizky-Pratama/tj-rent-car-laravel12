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

    /**
     * Cek apakah transaksi telat dan hitung berapa hari keterlambatan
     * Return: ['is_telat' => bool, 'hari_telat' => int, 'denda_per_hari' => int]
     */
    public function getSelisihTelatAttribute()
    {
        // Jika transaksi sudah selesai atau dibatalkan, gunakan tanggal_dikembalikan
        // Jika masih berjalan, gunakan tanggal sekarang
        $tanggalPengecekan = $this->tanggal_dikembalikan
            ? Carbon::parse($this->tanggal_dikembalikan)
            : Carbon::now();

        $tanggalKembali = Carbon::parse($this->tanggal_kembali);

        // Hitung selisih hari (positif = telat, negatif/0 = tidak telat)
        $hariTelat = $tanggalPengecekan->diffInDays($tanggalKembali, false);

        // Jika negatif berarti telat (tanggal pengecekan > tanggal kembali)
        $isTelat = $hariTelat < 0;
        $jumlahHariTelat = $isTelat ? abs(floor($hariTelat)) : 0;

        // Hitung denda per hari jika ada denda
        $dendaPerHari = 0;
        if ($jumlahHariTelat > 0 && $this->denda > 0) {
            $dendaPerHari = ceil($this->denda / $jumlahHariTelat);
        }

        return [
            'is_telat' => $isTelat,
            'hari_telat' => $jumlahHariTelat,
            'denda_per_hari' => $this->hargaSewa->jenissewa->tarif_denda_per_hari,
            'tanggal_seharusnya_kembali' => $tanggalKembali->format('d/m/Y H:i'),
            'tanggal_pengecekan' => $tanggalPengecekan->format('d/m/Y H:i'),
        ];
    }

    /**
     * Shortcut untuk cek apakah telat
     */
    public function getIsTelatAttribute()
    {
        return $this->selisih_telat['is_telat'];
    }

    /**
     * Shortcut untuk get jumlah hari telat
     */
    public function getHariTelatAttribute()
    {
        return $this->selisih_telat['hari_telat'];
    }

    /**
     * Shortcut untuk get denda per hari
     */
    public function getDendaPerHariAttribute()
    {
        return $this->selisih_telat['denda_per_hari'];
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

    public function scopeFilter($query, $filters = [])
    {
        // Filter berdasarkan periode waktu
        if (isset($filters['period']) && $filters['period']) {
            switch ($filters['period']) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'this_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->subWeek()->startOfWeek(),
                        Carbon::now()->subWeek()->endOfWeek()
                    ]);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                          ->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                          ->whereYear('created_at', Carbon::now()->subMonth()->year);
                    break;
                case 'this_year':
                    $query->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'custom':
                    if (isset($filters['date_from']) && $filters['date_from']) {
                        $query->whereDate('created_at', '>=', $filters['date_from']);
                    }
                    if (isset($filters['date_to']) && $filters['date_to']) {
                        $query->whereDate('created_at', '<=', $filters['date_to']);
                    }
                    break;
            }
        } else {
            // Fallback ke date range manual jika tidak ada period
            if (isset($filters['date_from']) && $filters['date_from']) {
                $query->whereDate('created_at', '>=', $filters['date_from']);
            }
            if (isset($filters['date_to']) && $filters['date_to']) {
                $query->whereDate('created_at', '<=', $filters['date_to']);
            }
        }

        // Filter berdasarkan status
        if (isset($filters['status']) && $filters['status'] && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        // Filter berdasarkan status pembayaran
        if (isset($filters['payment_status']) && $filters['payment_status'] && $filters['payment_status'] !== 'all') {
            if ($filters['payment_status'] === 'lunas') {
                $query->whereRaw('total <= (SELECT COALESCE(SUM(jumlah), 0) FROM pembayaran WHERE transaksi_id = transaksi.id AND status = "terkonfirmasi")');
            } elseif ($filters['payment_status'] === 'belum_lunas') {
                $query->whereRaw('total > (SELECT COALESCE(SUM(jumlah), 0) FROM pembayaran WHERE transaksi_id = transaksi.id AND status = "terkonfirmasi")');
            }
        }

        // Filter berdasarkan mobil
        if (isset($filters['mobil_id']) && $filters['mobil_id'] && $filters['mobil_id'] !== 'all') {
            $query->where('mobil_id', $filters['mobil_id']);
        }

        // Filter berdasarkan sopir
        if (isset($filters['sopir_id']) && $filters['sopir_id'] && $filters['sopir_id'] !== 'all') {
            $query->where('sopir_id', $filters['sopir_id']);
        }

        // Filter berdasarkan jenis sewa
        if (isset($filters['jenis_sewa']) && $filters['jenis_sewa'] && $filters['jenis_sewa'] !== 'all') {
            $query->whereHas('hargaSewa.jenisSewa', function ($q) use ($filters) {
                $q->where('id', $filters['jenis_sewa']);
            });
        }

        // Filter berdasarkan rentang total
        if (isset($filters['min_total']) && $filters['min_total']) {
            $query->where('total', '>=', $filters['min_total']);
        }
        if (isset($filters['max_total']) && $filters['max_total']) {
            $query->where('total', '<=', $filters['max_total']);
        }

        // Pencarian global
        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('no_transaksi', 'like', "%{$search}%")
                  ->orWhereHas('pelanggan', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('telepon', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('mobil', function ($q) use ($search) {
                      $q->where('merek', 'like', "%{$search}%")
                        ->orWhere('model', 'like', "%{$search}%")
                        ->orWhere('no_plat', 'like', "%{$search}%");
                  });
            });
        }

        return $query;
    }

    // Calendar status methods
    public function getCalendarStatusAttribute()
    {
        $today = now()->toDateString();

        return match($this->status) {
            'dibayar' => [
                'status' => 'dibayar',
                'color' => 'bg-blue-500',
                'text' => 'Dibayar - Siap Diambil',
                'text_color' => 'text-white'
            ],
            'berjalan' => [
                'status' => 'berjalan',
                'color' => 'bg-yellow-500',
                'text' => 'Sedang Disewa',
                'text_color' => 'text-white'
            ],
            'telat' => [
                'status' => 'telat',
                'color' => 'bg-red-500',
                'text' => 'Telat Kembali',
                'text_color' => 'text-white'
            ],
            'selesai' => [
                'status' => 'selesai',
                'color' => 'bg-green-500',
                'text' => 'Selesai',
                'text_color' => 'text-white'
            ],
            default => [
                'status' => 'pending',
                'color' => 'bg-gray-500',
                'text' => 'Pending',
                'text_color' => 'text-white'
            ]
        };
    }

    public function isActiveRental()
    {
        return in_array($this->status, ['dibayar', 'berjalan', 'telat']);
    }

    public function isOverdue()
    {
        return $this->status === 'telat' ||
               ($this->status === 'berjalan' && $this->tanggal_kembali->isPast());
    }

    // Scope untuk kalender
    public function scopeForCalendar($query)
    {
        return $query->whereIn('status', ['dibayar', 'berjalan', 'telat'])
                    ->with(['mobil', 'pelanggan', 'hargaSewa.jenisSewa']);
    }
}
