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
        Schema::create('data_prospek', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petugas_id')->constrained('users');
            $table->date('tanggal')->default(now());
            $table->string('jenis');
            $table->string('calon_debitur');
            $table->string('nohp')->unique()->nullable();
            $table->text('keterangan');
            $table->string('foto_pelaksanaan')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_prospek');
    }
};
