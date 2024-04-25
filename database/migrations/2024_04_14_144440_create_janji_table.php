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
        Schema::create('data_janji', function (Blueprint $table) {
            $table->id();
            $table->string('nokredit')->unique();
            $table->date('tanggal');
            $table->string('komitmen');
            $table->foreignId('petugas_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_janji');
    }
};
