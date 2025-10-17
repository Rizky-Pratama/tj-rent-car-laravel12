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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->onDelete('cascade');
            $table->integer('jumlah'); // Changed to integer (no decimals)
            $table->enum('metode', ['transfer', 'tunai', 'qris', 'kartu', 'ewallet']);
            $table->enum('status', ['pending', 'terkonfirmasi', 'gagal', 'refund'])->default('pending');
            $table->dateTime('tanggal_bayar')->nullable();
            $table->string('bukti_bayar')->nullable();
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('dibuat_oleh')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['status']);
            $table->index(['metode']);
            $table->index(['tanggal_bayar']);

            $table->foreign('dibuat_oleh')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
