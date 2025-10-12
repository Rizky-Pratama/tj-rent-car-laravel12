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
        // Create pelanggan table first (needed for transaksi foreign key)
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('email')->unique();
            $table->string('telepon', 15);
            $table->text('alamat');
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->string('no_ktp', 20)->unique();
            $table->string('foto_ktp')->nullable();
            $table->string('no_sim', 20)->nullable();
            $table->string('foto_sim')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();

            // Indexes for performance
            $table->index(['email', 'status']);
            $table->index(['no_ktp']);
            $table->index(['telepon']);
            $table->index(['status']);
        });

        // Create jenis_sewa table
        Schema::create('jenis_sewa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->integer('tarif_denda_per_hari')->nullable(); // Changed to integer (no decimals)
            $table->timestamps();

            $table->index(['slug']);
        });

        // Create harga_sewa table
        Schema::create('harga_sewa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mobil_id')->constrained('mobil')->onDelete('cascade');
            $table->foreignId('jenis_sewa_id')->constrained('jenis_sewa')->onDelete('cascade');
            $table->integer('harga_per_hari'); // Changed to integer (no decimals)
            $table->boolean('aktif')->default(true);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['mobil_id', 'jenis_sewa_id']);
            $table->index(['aktif']);
        });

        // Create sopir table
        Schema::create('sopir', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('telepon', 30);
            $table->string('no_sim', 50)->unique();
            $table->enum('status', ['tersedia', 'ditugaskan', 'libur'])->default('tersedia');
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['status']);
            $table->index(['no_sim']);
        });

        // Create transaksi table
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

        // Create pembayaran table
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
        Schema::dropIfExists('transaksi');
        Schema::dropIfExists('sopir');
        Schema::dropIfExists('harga_sewa');
        Schema::dropIfExists('jenis_sewa');
        Schema::dropIfExists('pelanggan');
    }
};
