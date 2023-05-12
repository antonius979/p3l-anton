<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pegawai extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pegawai';
    protected $table = 'pegawais';

    protected $fillable = [
        'id_pegawai',
        'id_role',
        'foto_pegawai',
        'nama_pegawai',
        'tanggal_lahir_pegawai',
        'jenis_kelamin_pegawai',
        'alamat_pegawai',
        'no_telp_pegawai',
        'email',
        'username',
        'password',
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