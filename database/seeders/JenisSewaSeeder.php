<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisSewaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisSewa = [
            [
                'nama_jenis' => 'Harian',
                'slug' => 'harian',
                'deskripsi' => 'Sewa mobil per hari',
                'tarif_denda_per_hari' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jenis' => 'Mingguan',
                'slug' => 'mingguan',
                'deskripsi' => 'Sewa mobil per minggu',
                'tarif_denda_per_hari' => 45000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jenis' => 'Bulanan',
                'slug' => 'bulanan',
                'deskripsi' => 'Sewa mobil per bulan',
                'tarif_denda_per_hari' => 40000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jenis' => 'Tahunan',
                'slug' => 'tahunan',
                'deskripsi' => 'Sewa mobil per tahun',
                'tarif_denda_per_hari' => 35000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('jenis_sewa')->insert($jenisSewa);
    }
}
