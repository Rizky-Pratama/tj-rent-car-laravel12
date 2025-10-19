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
                'deskripsi' => 'Sewa mobil per hari dalam kota',
                'tarif_denda_per_hari' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jenis' => 'Harian + Driver',
                'slug' => 'harian-driver',
                'deskripsi' => 'Sewa mobil per hari dalam kota dengan sopir',
                'tarif_denda_per_hari' => 50000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jenis' => 'Luar Kota',
                'slug' => 'luar-kota',
                'deskripsi' => 'Sewa mobil untuk perjalanan luar kota',
                'tarif_denda_per_hari' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_jenis' => 'Luar Kota + Driver',
                'slug' => 'luar-kota-driver',
                'deskripsi' => 'Sewa mobil untuk perjalanan luar kota dengan sopir',
                'tarif_denda_per_hari' => 75000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('jenis_sewa')->insert($jenisSewa);
    }
}
