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
        Schema::create('mobil', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mobil');
            $table->string('merk')->nullable();
            $table->string('model')->nullable();
            $table->string('plat_nomor', 50)->unique();
            $table->integer('tahun')->nullable();
            $table->string('foto');
            $table->enum('transmisi', ['manual', 'automatic', 'cvt'])->default('manual');
            $table->enum('jenis_bahan_bakar', ['bensin', 'diesel', 'listrik', 'hybrid'])->default('bensin');
            $table->string('warna', 50)->nullable();
            $table->integer('kapasitas_penumpang')->nullable();
            $table->enum('status', ['tersedia', 'disewa', 'perawatan', 'nonaktif'])->default('tersedia');
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['status']);
            $table->index(['plat_nomor', 'status']);
            $table->index(['merk', 'model']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mobil');
    }
};
