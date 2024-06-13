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
        Schema::create('data_tugas', function (Blueprint $table) {
            $table->id();
            $table->string('notugas')->unique();
            $table->string('nokredit');
            $table->date('tanggal');
            $table->string('jenis');
            $table->string('pelaksanaan')->nullable();
            $table->text('ket_pelaksanaan')->nullable();
            $table->string('hasil')->nullable();
            $table->text('ket_hasil')->nullable();
            $table->text('catatan_leader')->nullable();
            $table->string('foto_pelaksanaan')->nullable();
            $table->integer('tunggakan_pokok')->nullable();
            $table->integer('tunggakan_bunga')->nullable();
            $table->integer('tunggakan_denda')->nullable();
            $table->string('status')->default('Proses');
            $table->foreignId('leader_id')->constrained('users');
            $table->foreignId('petugas_id')->constrained('users');
            $table->string('klasifikasi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_tugas');
    }
};
