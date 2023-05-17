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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id('Nim');
            $table->string('Nama',50);
            $table->string('Kelas',5);
            $table->string('Jurusan',35);
            $table->string('No_Handphone',12);
            $table->string('Email',35);
            $table->string('Tanggal_Lahir',12);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};