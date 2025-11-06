<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('transaksi:update-overdue')->dailyAt('00:01')->appendOutputTo(storage_path('logs/overdue-check.log'));

Artisan::command('make:user {nama} {email} {password}', function ($nama, $email, $password) {
    $user = new \App\Models\User();
    $user->nama = $nama;
    $user->email = $email;
    $user->password = bcrypt($password);
    $user->role = 'admin';
    $user->save();

    $this->info("User {$nama} created successfully.");
})->describe('Create a new user with specified name, email, and password.');
