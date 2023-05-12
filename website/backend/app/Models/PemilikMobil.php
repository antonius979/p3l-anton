<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PemilikMobil extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pemilik_mobil';
    public $incrementing = false;
    protected $table = 'pemilik_mobils';

    protected $fillable = [
        'id_pemilik_mobil',
        'nama_pemilik_mobil',
        'no_ktp',
        'alamat_pemilik_mobil',
        'no_telp_pemilik_mobil'  
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
