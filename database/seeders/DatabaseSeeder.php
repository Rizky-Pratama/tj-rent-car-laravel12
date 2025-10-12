<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Run seeders in order
        $this->call([
            UserSeeder::class,
            CarSeeder::class,
            PelangganSeeder::class,
            JenisSewaSeeder::class,
            HargaSewaSeeder::class,
            SopirSeeder::class,
            TransaksiSeeder::class,
            PembayaranSeeder::class,
        ]);
    }
}
