<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lokasi_id');
            $table->foreign('lokasi_id')->references('id')->on('lokasis');
            $table->string('kode');
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->string('tahun');
            $table->string('isbn');
            $table->integer('jumlah');
            $table->string('gambar');
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
        Schema::dropIfExists('bukus');
    }
}
