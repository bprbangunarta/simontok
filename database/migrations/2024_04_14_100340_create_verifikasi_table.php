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
        Schema::create('data_verifikasi', function (Blueprint $table) {
            $table->id();
            $table->string('notugas')->unique();
            $table->string('pengguna_kredit')->nullable();
            $table->string('penggunaan_kredit')->nullable();
            $table->string('usaha_debitur')->nullable();
            $table->string('cara_pembayaran')->nullable();
            $table->string('alamat_rumah')->nullable();
            $table->string('karakter_debitur')->nullable();
            $table->string('nomor_debitur')->nullable();
            $table->string('nomor_pendamping')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_verifikasi');
    }
};
