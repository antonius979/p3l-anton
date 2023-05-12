<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class JadwalHarian extends Model
{
    protected $primaryKey ='id_jadwal_harian';
    protected $table = 'jadwal_Harians';
    public $incrementing = false;
    
    protected $fillable = [
        'id_kelas',
        'id_instruktur',
        'hari_kerja',
        'jam',
        'tanggal',
        'keterangan',
    ];
}
