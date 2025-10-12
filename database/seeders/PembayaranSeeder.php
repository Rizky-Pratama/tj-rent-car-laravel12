<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pembayaran = [
            [
                'transaksi_id' => 1,
                'jumlah' => 1050000,
                'metode' => 'transfer',
                'status' => 'terkonfirmasi',
                'tanggal_bayar' => now()->subDays(30)->format('Y-m-d H:i:s'),
                'bukti_bayar' => 'bukti_transfer_001.jpg',
                'catatan' => 'Pembayaran lunas via transfer BCA',
                'dibuat_oleh' => 2, // Admin
                'created_at' => now()->subDays(31),
                'updated_at' => now()->subDays(25),
            ],
            [
                'transaksi_id' => 2,
                'jumlah' => 1200000,
                'metode' => 'tunai',
                'status' => 'terkonfirmasi',
                'tanggal_bayar' => now()->subDays(20)->format('Y-m-d H:i:s'),
                'bukti_bayar' => null,
                'catatan' => 'Pembayaran tunai langsung',
                'dibuat_oleh' => 2, // Admin
                'created_at' => now()->subDays(21),
                'updated_at' => now()->subDays(15),
            ],
            [
                'transaksi_id' => 3,
                'jumlah' => 1125000, // DP 50%
                'metode' => 'transfer',
                'status' => 'terkonfirmasi',
                'tanggal_bayar' => now()->format('Y-m-d H:i:s'),
                'bukti_bayar' => 'bukti_transfer_003.jpg',
                'catatan' => 'DP 50% via transfer Mandiri',
                'dibuat_oleh' => 2, // Admin
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pembayaran')->insert($pembayaran);
    }
}
