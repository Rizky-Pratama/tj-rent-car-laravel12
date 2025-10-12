<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HargaSewaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hargaSewa = [
            // Toyota Avanza - ID 1 - Harian
            [
                'mobil_id' => 1,
                'jenis_sewa_id' => 1,
                'harga_per_hari' => 350000,
                'aktif' => true,
                'catatan' => 'Harga standar Toyota Avanza per hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Honda Jazz - ID 2 - Harian
            [
                'mobil_id' => 2,
                'jenis_sewa_id' => 1,
                'harga_per_hari' => 400000,
                'aktif' => true,
                'catatan' => 'Harga standar Honda Jazz per hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Xpander - ID 3 - Harian
            [
                'mobil_id' => 3,
                'jenis_sewa_id' => 1,
                'harga_per_hari' => 450000,
                'aktif' => true,
                'catatan' => 'Harga standar Mitsubishi Xpander per hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Terios - ID 4 - Harian
            [
                'mobil_id' => 4,
                'jenis_sewa_id' => 1,
                'harga_per_hari' => 380000,
                'aktif' => true,
                'catatan' => 'Harga standar Daihatsu Terios per hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Ertiga - ID 5 - Harian
            [
                'mobil_id' => 5,
                'jenis_sewa_id' => 1,
                'harga_per_hari' => 370000,
                'aktif' => true,
                'catatan' => 'Harga standar Suzuki Ertiga per hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('harga_sewa')->insert($hargaSewa);
    }
}
