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
        Schema::create('aktivasi_tahunans', function (Blueprint $table) {
            $table->string('id_aktivasi_tahunan')->primary();
            $table->string('id_member');
            $table->unsignedBigInteger('id_pegawai')->index();
            $table->foreign('id_pegawai')
            ->references('id_pegawai')
            ->on('pegawais');
            $table->date('masa_aktif');
            $table->string('aktivasi_tahunan', 50)->nullable();;
            $table->foreign('id_member')->references('id_member')->on('members');
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
        Schema::dropIfExists('aktivasi_tahunans');
    }
};
