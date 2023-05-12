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
        Schema::create('members', function (Blueprint $table) {
            // $table->id('id_member')->primary();
            $table->string('id_member')->primary();
            $table->string('nama_member'); 
            $table->string('alamat_member'); 
            $table->date('tanggal_lahir_member');
            $table->string('no_telp_member');
            $table->string('jenis_kelamin_member');
            $table->string('umur');
            $table->string('email');
            $table->string('username');
            $table->string('password');
            $table->string('sisa_deposit_uang');
            $table->string('sisa_deposit_kelas');
            $table->string('masa_berlaku');
            $table->string('paket');
            $table->string('status_member');
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
        Schema::dropIfExists('members');
    }
};
