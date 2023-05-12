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
        Schema::create('deposit_kelas', function (Blueprint $table) {
            $table->string('id_deposit_kelas')->primary();
            $table->string('id_member');
            $table->unsignedBigInteger('id_pegawai')->index();
            $table->foreign('id_pegawai')
            ->references('id_pegawai')
            ->on('pegawais');
            $table->unsignedBigInteger('id_kelas')->index();
            $table->foreign('id_kelas')
            ->references('id_kelas')
            ->on('kelas');
            $table->date('berlaku');
            $table->string('total_deposit');
            $table->timestamps();
            
            $table->foreign('id_member')->references('id_member')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deposit_kelas');
    }
};
