<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pelanggan = [
            [
                'nama' => 'John Doe',
                'email' => 'john.doe@gmail.com',
                'telepon' => '08123456789',
                'alamat' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'tanggal_lahir' => '1990-05-15',
                'jenis_kelamin' => 'laki-laki',
                'no_ktp' => '3171051505900001',
                'no_sim' => 'A12345678901234',
                'pekerjaan' => 'Karyawan Swasta',
                'catatan' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@yahoo.com',
                'telepon' => '08234567890',
                'alamat' => 'Jl. Kebon Jeruk No. 56, Jakarta Barat',
                'tanggal_lahir' => '1985-12-20',
                'jenis_kelamin' => 'perempuan',
                'no_ktp' => '3175062012850002',
                'no_sim' => 'A98765432109876',
                'pekerjaan' => 'Wiraswasta',
                'catatan' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@hotmail.com',
                'telepon' => '08345678901',
                'alamat' => 'Jl. Cikini Raya No. 78, Jakarta Pusat',
                'tanggal_lahir' => '1992-03-10',
                'jenis_kelamin' => 'laki-laki',
                'no_ktp' => '3171031003920003',
                'no_sim' => 'A11223344556677',
                'pekerjaan' => 'Guru',
                'catatan' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Maya Sari',
                'email' => 'maya.sari@gmail.com',
                'telepon' => '08456789012',
                'alamat' => 'Jl. Kebayoran Baru No. 90, Jakarta Selatan',
                'tanggal_lahir' => '1988-07-25',
                'jenis_kelamin' => 'perempuan',
                'no_ktp' => '3174072507880004',
                'no_sim' => 'A55667788990011',
                'pekerjaan' => 'Dokter',
                'catatan' => null,
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rizki Ramadan',
                'email' => 'rizki.ramadan@outlook.com',
                'telepon' => '08567890123',
                'alamat' => 'Jl. Kelapa Gading No. 111, Jakarta Utara',
                'tanggal_lahir' => '1995-11-08',
                'jenis_kelamin' => 'laki-laki',
                'no_ktp' => '3172050811950005',
                'no_sim' => 'A99887766554433',
                'pekerjaan' => 'IT Consultant',
                'catatan' => 'Pelanggan VIP - sering rental untuk perjalanan bisnis',
                'status' => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pelanggan')->insert($pelanggan);
    }
}
