<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DetailJadwal extends Model
{
    protected $primaryKey = 'id_detail_jadwal';
    protected $table = 'detail_jadwals';

    protected $fillable = [
        'id_detail_jadwal',
        'id_pegawai',
        'id_jadwal_pegawai',
    ];

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute(){
        if(!is_null($this->attributes['updated_at'])){
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
    
    public function Pegawai() {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
    
    public function JadwalPegawai() {
        return $this->belongsTo(JadwalPegawai::class, 'id_jadwal_pegawai', 'id_jadwal_pegawai');
    }
}
