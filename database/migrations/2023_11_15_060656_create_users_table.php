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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('tipe_user_id')->nullable();
            $table->unsignedBigInteger('bidang_id')->nullable();
            $table->string('nik', 16)->unique()->nullable();
            $table->string('npwp', 16)->unique()->nullable();
            $table->string('nama', 100)->required();
            $table->string('jabatan', 100)->nullable();
            $table->string('password', 100)->nullable();
            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('tipe_user_id')->references('id')->on('tipe_users');
            $table->foreign('bidang_id')->references('id')->on('bidangs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
