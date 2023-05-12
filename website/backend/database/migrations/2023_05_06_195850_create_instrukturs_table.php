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
        Schema::create('instrukturs', function (Blueprint $table) {
            $table->id('id_instruktur');
            $table->string('nama_instruktur'); 
            $table->string('no_telp_instruktur');
            $table->string('alamat_instruktur');
            $table->string('jenis_kelamin_instruktur');
            $table->date('tanggal_lahir_instruktur');
            $table->string('waktu_terlambat');
            $table->string('email');
            $table->string('username');
            $table->string('password');
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
        Schema::dropIfExists('instrukturs');
    }
};
