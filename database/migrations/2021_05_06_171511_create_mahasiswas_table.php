<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jurusan_id');
            $table->foreign('jurusan_id')->references('id')->on('jurusans');
            $table->foreignId('semester_id');
            $table->foreign('semester_id')->references('id')->on('semesters');
            $table->foreignId('kelas_id');
            $table->foreign('kelas_id')->references('id')->on('kelas');
            $table->string('nim');
            $table->string('nama');
            $table->string('email');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
}
