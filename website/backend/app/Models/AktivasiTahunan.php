<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class AktivasiTahunan extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'id_aktivasi_tahunan ';
    protected $fillable = [
        'id_aktivasi_tahunan ',
        'id_member',
        'id_pegawai',
        'tanggal_transaksi',
        'aktivasi_tahunan',
        'tanggal_selesai_sewa',
        'status_transaksi'
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

    public function Member(){
        return $this->belongsTo(Customer::class, 'id_member', 'id_member');
    }

    public function Pegawai(){
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }
}
