<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jadwal extends Model
{
    protected $primaryKey ='id_jadwal';
    protected $table = 'jadwals';
    public $incrementing = false;
    
    protected $fillable = [
        'id_kelas',
        'id_instruktur',
        'hari_kerja',
        'jam',
    ];
}
