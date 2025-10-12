<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SopirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sopir = [
            [
                'nama' => 'Ahmad Wijaya',
                'telepon' => '08123456789',
                'no_sim' => 'A123456789',
                'status' => 'tersedia',
                'catatan' => 'Sopir berpengalaman 10 tahun, menguasai rute Jakarta-Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'telepon' => '08234567890',
                'no_sim' => 'B987654321',
                'status' => 'tersedia',
                'catatan' => 'Sopir ramah, ahli rute wisata Jawa Barat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Cecep Suryana',
                'telepon' => '08345678901',
                'no_sim' => 'C147258369',
                'status' => 'ditugaskan',
                'catatan' => 'Sedang bertugas hingga akhir bulan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Dedi Kurniawan',
                'telepon' => '08456789012',
                'no_sim' => 'D369258147',
                'status' => 'tersedia',
                'catatan' => 'Sopir muda, energik, cocok untuk perjalanan jauh',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Eko Prasetyo',
                'telepon' => '08567890123',
                'no_sim' => 'E258147369',
                'status' => 'tersedia',
                'catatan' => 'Sopir senior, sangat berpengalaman di berbagai medan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('sopir')->insert($sopir);
    }
}
