<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;
use Carbon\Carbon;

class Customer extends Model
{
    use HasApiTokens, HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id_customer';
    protected $table = 'customers';

    protected $fillable = [
        'id_customer',
        'nama_customer',
        'alamat_customer',
        'tanggal_lahir',
        'jenis_kelamin_customer',
        'no_telp_customer',
        'foto_customer',
        'ktp_customer',
        'sim_customer',
        'email',
        'password',
        'status_customer',
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
