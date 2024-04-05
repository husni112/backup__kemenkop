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
        Schema::create('item_pagus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('akun_id');
            $table->unsignedBigInteger('uraian_subkomponen_id')->nullable();
            $table->unsignedBigInteger('sub_komponen_id')->nullable();
            $table->unsignedBigInteger('komponen_id')->nullable();
            $table->unsignedBigInteger('sub_output_id')->nullable();
            $table->unsignedBigInteger('output_id')->nullable();
            $table->unsignedBigInteger('kegiatan_id')->nullable();
            $table->unsignedBigInteger('program_id')->nullable();
            $table->integer('cons_item');
            $table->string('uraian_item');
            $table->integer('volume');
            $table->bigInteger('harga_satuan');
            $table->bigInteger('total');
            $table->string('desc')->nullable();
            $table->timestamps();

            $table->foreign('akun_id')->references('id')->on('akuns');
            $table->foreign('uraian_subkomponen_id')->references('id')->on('uraian_subkomponens');
            $table->foreign('sub_komponen_id')->references('id')->on('sub_komponens');
            $table->foreign('komponen_id')->references('id')->on('komponens');
            $table->foreign('sub_output_id')->references('id')->on('sub_outputs');
            $table->foreign('output_id')->references('id')->on('outputs');
            $table->foreign('kegiatan_id')->references('id')->on('kegiatans');
            $table->foreign('program_id')->references('id')->on('programs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_pagus');
    }
};
