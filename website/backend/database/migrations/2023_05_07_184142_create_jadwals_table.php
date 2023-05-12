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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->unsignedBigInteger('id_instruktur');
            $table->foreign('id_instruktur')
            ->references('id_instruktur')
            ->on('instrukturs');
            $table->unsignedBigInteger('id_kelas');
            $table->foreign('id_kelas')
            ->references('id_kelas')
            ->on('kelas');
            $table->string('hari_kerja');
            $table->string('jam');
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
        Schema::dropIfExists('jadwals');
    }
};
