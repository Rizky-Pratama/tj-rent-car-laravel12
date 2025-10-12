<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transaksi = [
            [
                'no_transaksi' => 'TXN-2024-001',
                'pelanggan_id' => 1, // John Doe
                'mobil_id' => 1, // Toyota Avanza
                'sopir_id' => 1, // Ahmad Wijaya
                'harga_sewa_id' => 1, // Harian Avanza
                'tanggal_sewa' => now()->subDays(30)->format('Y-m-d H:i:s'),
                'tanggal_kembali' => now()->subDays(27)->format('Y-m-d H:i:s'),
                'tanggal_dikembalikan' => now()->subDays(27)->format('Y-m-d H:i:s'),
                'durasi_hari' => 3,
                'subtotal' => 1050000, // 3 x 350000
                'biaya_tambahan' => 0,
                'denda' => 0,
                'denda_manual' => 0,
                'total' => 1050000,
                'status_pembayaran' => 'lunas',
                'status' => 'selesai',
                'catatan' => 'Perjalanan wisata keluarga ke Puncak',
                'dibuat_oleh' => 2, // Admin
                'created_at' => now()->subDays(30),
                'updated_at' => now()->subDays(25),
            ],
            [
                'no_transaksi' => 'TXN-2024-002',
                'pelanggan_id' => 2, // Siti Nurhaliza
                'mobil_id' => 2, // Honda Jazz
                'sopir_id' => null, // Tanpa sopir
                'harga_sewa_id' => 2, // Harian Jazz
                'tanggal_sewa' => now()->subDays(20)->format('Y-m-d H:i:s'),
                'tanggal_kembali' => now()->subDays(17)->format('Y-m-d H:i:s'),
                'tanggal_dikembalikan' => now()->subDays(17)->format('Y-m-d H:i:s'),
                'durasi_hari' => 3,
                'subtotal' => 1200000, // 3 x 400000
                'biaya_tambahan' => 0,
                'denda' => 0,
                'denda_manual' => 0,
                'total' => 1200000,
                'status_pembayaran' => 'lunas',
                'status' => 'selesai',
                'catatan' => 'Keperluan bisnis dalam kota',
                'dibuat_oleh' => 2, // Admin
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(15),
            ],
            [
                'no_transaksi' => 'TXN-2024-003',
                'pelanggan_id' => 3, // Budi Santoso
                'mobil_id' => 3, // Xpander
                'sopir_id' => 2, // Budi Santoso
                'harga_sewa_id' => 3, // Harian Xpander
                'tanggal_sewa' => now()->format('Y-m-d H:i:s'),
                'tanggal_kembali' => now()->addDays(5)->format('Y-m-d H:i:s'),
                'tanggal_dikembalikan' => null,
                'durasi_hari' => 5,
                'subtotal' => 2250000, // 5 x 450000
                'biaya_tambahan' => 0,
                'denda' => 0,
                'denda_manual' => 0,
                'total' => 2250000,
                'status_pembayaran' => 'sebagian',
                'status' => 'berjalan',
                'catatan' => 'Perjalanan dinas ke luar kota',
                'dibuat_oleh' => 2, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('transaksi')->insert($transaksi);
    }
}
