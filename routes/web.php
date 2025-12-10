<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\MobilController;
use App\Http\Controllers\Admin\SopirController;
use App\Http\Controllers\Admin\HargaSewaController;
use App\Http\Controllers\Admin\JenisSewaController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\PembayaranController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Api\MobilController as ApiMobilController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // User Management
    Route::resource('users', UserController::class)->middleware('can:viewAny,App\Models\User');

    // Pelanggan Management
    Route::resource('pelanggan', PelangganController::class);

    // Mobil Management
    Route::resource('mobil', MobilController::class);
    Route::get('mobil-export/pdf', [MobilController::class, 'exportPdf'])->name('mobil.export.pdf');

    // Sopir Management
    Route::resource('sopir', SopirController::class);

    // Jenis Sewa Management
    Route::resource('jenis-sewa', JenisSewaController::class);

    // Harga Sewa Management
    Route::resource('harga-sewa', HargaSewaController::class);

    // Mobil Pricing Routes
    Route::prefix('mobil/{mobil}')->name('mobil.')->group(function () {
        Route::get('/pricing', [MobilController::class, 'pricing'])->name('pricing');
        Route::post('/pricing', [MobilController::class, 'updatePricing'])->name('pricing.update');
        Route::delete('/pricing/{hargaSewa}', [MobilController::class, 'deletePricing'])->name('pricing.delete');
    });

    // Jadwal & Ketersediaan Management
    Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('/jadwal/events', [JadwalController::class, 'events'])->name('jadwal.events');
    Route::get('/jadwal/transaksi/{id}', [JadwalController::class, 'show'])->name('jadwal.show');

    // Transaksi Management (All-in-One)
    // IMPORTANT: Specific routes MUST come before resource routes to avoid conflicts
    Route::get('/transaksi/search', [TransaksiController::class, 'searchForPayment'])->name('transaksi.search');
    Route::get('/transaksi/{transaksi}/export-pdf', [TransaksiController::class, 'exportDetailPdf'])->name('transaksi.export-pdf');
    Route::get('/transaksi/{transaksi}/payment', [TransaksiController::class, 'payment'])->name('transaksi.payment');
    Route::patch('/transaksi/{transaksi}/status', [TransaksiController::class, 'updateStatus'])->name('transaksi.update-status');
    Route::post('/transaksi/{transaksi}/biaya-tambahan', [TransaksiController::class, 'addBiayaTambahan'])->name('transaksi.add-biaya');
    Route::post('/transaksi/{transaksi}/denda', [TransaksiController::class, 'addDenda'])->name('transaksi.add-denda');
    Route::resource('transaksi', TransaksiController::class);

    // Pembayaran Management
    Route::get('pembayaran-export/pdf', [PembayaranController::class, 'exportPdf'])->name('pembayaran.export.pdf');
    Route::resource('pembayaran', PembayaranController::class)->except(['edit', 'update']);
    Route::get('/pembayaran/{pembayaran}/edit', [PembayaranController::class, 'edit'])->name('pembayaran.edit');
    Route::put('/pembayaran/{pembayaran}', [PembayaranController::class, 'update'])->name('pembayaran.update');
    Route::patch('/pembayaran/{pembayaran}/status', [PembayaranController::class, 'updateStatus'])->name('pembayaran.updateStatus');

    // Orders Management
    Route::resource('orders', OrderController::class);
});

// Redirect to dashboard for quick access
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
});

// API Routes
Route::prefix('api/v1')->name('api.')->group(function () {
    // Mobil endpoints
    Route::get('/mobil', [ApiMobilController::class, 'index'])->name('mobil.index');
});
