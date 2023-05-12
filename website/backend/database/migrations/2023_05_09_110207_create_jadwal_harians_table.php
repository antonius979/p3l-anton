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
        Schema::create('jadwal_harians', function (Blueprint $table) {
            $table->id('id_jadwal_harian');
            $table->unsignedBigInteger('id_jadwal')->index();
            $table->foreign('id_jadwal')
            ->references('id_jadwal')
            ->on('jadwals');
            $table->unsignedBigInteger('id_instruktur')->index();
            $table->foreign('id_instruktur')
            ->references('id_instruktur')
            ->on('instrukturs');
            $table->unsignedBigInteger('id_kelas')->index();
            $table->foreign('id_kelas')
            ->references('id_kelas')
            ->on('kelas');
            // $table->string('hari_kerja');
            $table->date('tanggal');
            // $table->string('jam');
            $table->string('keterangan');
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
        Schema::dropIfExists('jadwal_harians');
    }
};
