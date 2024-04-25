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
        Schema::create('data_writeoff', function (Blueprint $table) {
            $table->id();
            $table->string('nocif');
            $table->string('nokredit')->unique();
            $table->string('nospk')->unique();
            $table->string('nama_debitur');
            $table->string('alamat');
            $table->string('wilayah');
            $table->integer('plafon');
            $table->integer('baki_debet');
            $table->integer('kolektibilitas');
            $table->string('metode_rps');
            $table->integer('jangka_waktu');
            $table->integer('rate_bunga');
            $table->date('tgl_realisasi');
            $table->date('tgl_jatuh_tempo');
            $table->string('kode_petugas');
            $table->integer('tunggakan_bunga');
            $table->integer('tunggakan_denda');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_writeoff');
    }
};
