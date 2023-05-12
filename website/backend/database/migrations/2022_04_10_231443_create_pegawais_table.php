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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id('id_pegawai');
            $table->unsignedBigInteger('id_role');
            $table->foreign('id_role')
                  ->references('id_role')
                  ->on('roles')
                  ->onDelete('cascade');
            $table->string('foto_pegawai');
            $table->string('nama_pegawai');
            $table->date('tanggal_lahir_pegawai');
            $table->string('jenis_kelamin_pegawai');
            $table->string('alamat_pegawai');
            $table->string('no_telp_pegawai');
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('pegawais');
    }
};
