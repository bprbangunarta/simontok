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
        Schema::create('data_verifikasi_agunan', function (Blueprint $table) {
            $table->id();
            $table->string('notugas');
            $table->string('noreg')->unique();
            $table->string('agunan');
            $table->string('kondisi')->nullable();
            $table->string('penguasaan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_verifikasi_agunan');
    }
};
