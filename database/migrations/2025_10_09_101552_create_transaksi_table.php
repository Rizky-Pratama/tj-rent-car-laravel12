<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('no_transaksi', 50)->unique();
            $table->foreignId('pelanggan_id')->constrained('pelanggan')->onDelete('cascade');
            $table->foreignId('mobil_id')->constrained('mobil')->onDelete('cascade');
            $table->foreignId('harga_sewa_id')->constrained('harga_sewa')->onDelete('cascade');
            $table->foreignId('sopir_id')->nullable()->constrained('sopir')->onDelete('set null');

            $table->dateTime('tanggal_sewa');
            $table->dateTime('tanggal_kembali');
            $table->dateTime('tanggal_dikembalikan')->nullable();
            $table->integer('durasi_hari')->nullable();

            $table->integer('subtotal'); // Changed to integer (no decimals)
            $table->integer('biaya_tambahan')->nullable(); // Changed to integer (no decimals)
            $table->integer('denda')->default(0); // Changed to integer (no decimals)
            $table->integer('denda_manual')->default(0); // Changed to integer (no decimals)
            $table->integer('total'); // Changed to integer (no decimals)

            $table->enum('status_pembayaran', ['belum_bayar', 'sebagian', 'lunas', 'refund'])->default('belum_bayar');
            $table->enum('status', ['pending', 'dibayar', 'berjalan', 'telat', 'selesai', 'batal'])->default('pending');

            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['no_transaksi']);
            $table->index(['status', 'status_pembayaran']);
            $table->index(['pelanggan_id', 'status']);
            $table->index(['tanggal_sewa', 'tanggal_kembali']);

            $table->foreign('dibuat_oleh')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
