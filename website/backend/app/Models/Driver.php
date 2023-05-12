<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Driver extends Model
{

    protected $primaryKey = 'id_driver';
    public $incrementing = false;
    protected $table = 'drivers';

    protected $fillable = [
        'id_driver',
        'nama_driver',
        'alamat_driver',
        'tanggal_lahir_driver',
        'jenis_kelamin_driver',
        'no_telp_driver',
        'email',
        'password',

        'sim_driver',
        'surat_bebas_napza',
        'surat_kesehatan_jiwa',
        'surat_kesehatan_jasmani',
        'skck',
        'foto_driver',

        'bahasa_asing',
        'tarif_driver_perhari',
        'rerata_rating_driver', 
        'status_ketersediaan_driver',
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

}
