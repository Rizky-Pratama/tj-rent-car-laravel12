<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mobil = [
            [
                'nama_mobil' => 'Toyota Avanza G',
                'merk' => 'Toyota',
                'model' => 'Avanza 1.3 G MT',
                'tahun' => 2022,
                'plat_nomor' => 'B 1234 ABC',
                'foto' => 'avanza.jpg',
                'warna' => 'Putih',
                'kapasitas_penumpang' => 7,
                'transmisi' => 'manual',
                'jenis_bahan_bakar' => 'bensin',
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mobil' => 'Honda Jazz RS',
                'merk' => 'Honda',
                'model' => 'Jazz 1.5 RS CVT',
                'tahun' => 2021,
                'plat_nomor' => 'B 5678 DEF',
                'foto' => 'jazz.jpg',
                'warna' => 'Merah',
                'kapasitas_penumpang' => 5,
                'transmisi' => 'automatic',
                'jenis_bahan_bakar' => 'bensin',
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mobil' => 'Mitsubishi Xpander Ultimate',
                'merk' => 'Mitsubishi',
                'model' => 'Xpander Ultimate CVT',
                'tahun' => 2023,
                'plat_nomor' => 'B 9012 GHI',
                'foto' => 'xpander.jpg',
                'warna' => 'Hitam',
                'kapasitas_penumpang' => 7,
                'transmisi' => 'automatic',
                'jenis_bahan_bakar' => 'bensin',
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mobil' => 'Daihatsu Terios X',
                'merk' => 'Daihatsu',
                'model' => 'Terios 1.5 X MT',
                'tahun' => 2020,
                'plat_nomor' => 'B 3456 JKL',
                'foto' => 'terios.jpg',
                'warna' => 'Silver',
                'kapasitas_penumpang' => 7,
                'transmisi' => 'manual',
                'jenis_bahan_bakar' => 'bensin',
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_mobil' => 'Suzuki Ertiga GX',
                'merk' => 'Suzuki',
                'model' => 'Ertiga 1.5 GX AT',
                'tahun' => 2022,
                'plat_nomor' => 'B 7890 MNO',
                'foto' => 'ertiga.jpg',
                'warna' => 'Biru',
                'kapasitas_penumpang' => 7,
                'transmisi' => 'automatic',
                'jenis_bahan_bakar' => 'bensin',
                'status' => 'tersedia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('mobil')->insert($mobil);
    }
}
