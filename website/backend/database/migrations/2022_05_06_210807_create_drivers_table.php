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
        Schema::create('drivers', function (Blueprint $table) {
            $table->string('id_driver')->primary();
            $table->string('nama_driver');
            $table->string('alamat_driver');
            $table->date('tanggal_lahir_driver');
            $table->string('jenis_kelamin_driver');
            $table->string('no_telp_driver');
            $table->string('email');
            $table->string('password');

            $table->string('sim_driver');
            $table->string('surat_bebas_napza');
            $table->string('surat_kesehatan_jiwa');
            $table->string('surat_kesehatan_jasmani');
            $table->string('skck');
            $table->string('foto_driver');

            $table->string('bahasa_asing');
            $table->float('tarif_driver_perhari');
            $table->float('rerata_rating_driver');
            $table->string('status_ketersediaan_driver');
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
        Schema::dropIfExists('drivers');
    }
};
