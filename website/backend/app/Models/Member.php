<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class Member extends Model
{
    use HasApiTokens, HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id_member';
    protected $table = 'members';

    protected $fillable = [
        'id_member',
        'nama_member',
        'alamat_member',
        'tanggal_lahir_member',
        'jenis_kelamin_member',
        'no_telp_member',
        'umur',
        'email',
        'username',
        'password',
        'sisa_deposit_uang',
        'sisa_deposit_kelas',
        'masa_berlaku',
        'paket',
        'status_member',
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
