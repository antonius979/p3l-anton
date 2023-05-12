<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Instruktur extends Model
{
    protected $primaryKey ='id_instruktur';
    public $incrementing = false;
    protected $table = 'instrukturs';

    protected $fillable = [
        'id_instruktur',
        'nama_instruktur',
        'no_telp_instruktur',
        'alamat_instruktur',
        'tanggal_lahir_instruktur',
        'jenis_kelamin_instruktur',
        'email',
        'username',
        'password',
        'waktu_terlambat'
    ];
}
