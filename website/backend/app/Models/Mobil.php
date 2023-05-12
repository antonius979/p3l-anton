<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Mobil extends Model
{
    protected $primaryKey = 'id_mobil';
    public $incrementing = false;
    protected $table = 'mobils';

    protected $fillable = [
        'id_mobil',
        'id_pemilik_mobil',
        'plat_nomor',
        'nomor_stnk',
        'gambar_mobil',
        'nama_mobil',
        'tipe_mobil',
        'jenis_transmisi',
        'jenis_bahan_bakar',
        'warna_mobil',
        'kapasitas_penumpang',
        'volume_bagasi', 
        'fasilitas',
        'kategori_aset',
        'tanggal_kontrak_mulai_mobil',
        'tanggal_kontrak_selesai_mobil',
        'tanggal_terakhir_servis_mobil',
        'harga_sewa_mobil_perhari',
        'status_ketersediaan_mobil',
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

    public function PemilikMobil(){
        return $this->belongsTo(PemilikMobil::class, 'id_pemilik_mobil', 'id_pemilik_mobil');
    }
}
