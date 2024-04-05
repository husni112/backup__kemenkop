<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perjalanan_dinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('berkas_id');
            $table->string('nama_pengirim_berkas');
            $table->string('bidang_pengirim_berkas');
            $table->string('jenis_penyedia');
            $table->bigInteger('npwp')->nullable();
            $table->bigInteger('nik')->nullable();
            $table->string('nama');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('jenis_kegiatan');
            $table->string('kode_mak');
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
        Schema::dropIfExists('perjalanan_dinas');
    }
};
