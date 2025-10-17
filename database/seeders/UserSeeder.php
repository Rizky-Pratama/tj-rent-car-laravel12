<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $users = [
      [
        'nama' => 'Admin TJ Rent Car',
        'email' => 'admin@admin.com',
        'password' => Hash::make('password'),
        'telepon' => '08123456789',
        'alamat' => 'Jl. Merdeka No. 123, Jakarta',
        'role' => 'admin',
        'aktif' => true,
        'created_at' => now(),
        'updated_at' => now(),
      ],
      [
        'nama' => 'Staf Operasional',
        'email' => 'staf@tjrentcar.com',
        'password' => Hash::make('password'),
        'telepon' => '08987654321',
        'alamat' => 'Jl. Sudirman No. 456, Bandung',
        'role' => 'staf',
        'aktif' => true,
        'created_at' => now(),
        'updated_at' => now(),
      ],
    ];

    foreach ($users as $user) {
      User::create($user);
    }
  }
}
