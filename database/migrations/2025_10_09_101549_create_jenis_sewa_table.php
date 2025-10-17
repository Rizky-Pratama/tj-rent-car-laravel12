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
        Schema::create('jenis_sewa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->integer('tarif_denda_per_hari')->nullable(); // Changed to integer (no decimals)
            $table->timestamps();

            $table->index(['slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_sewa');
    }
};
