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
        Schema::create('data_tunggakan', function (Blueprint $table) {
            $table->id();
            $table->string('nokredit')->unique();
            $table->integer('tunggakan_pokok')->nullable();
            $table->integer('tunggakan_bunga')->nullable();
            $table->integer('tunggakan_denda')->nullable();
            $table->integer('hari_tunggakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_tunggakan');
    }
};
