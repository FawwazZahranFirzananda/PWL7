<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaMataKuliahTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa_matakuliah', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mahasiswa_id');
            $table->unsignedBigInteger('matakuliah_id');
            $table->string('nilai');
            $table->foreign('mahasiswa_id')->references('Nim')->on('mahasiswas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('matakuliah_id')->references('id')->on('matakuliah')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswa_matakuliah');
    }
};
