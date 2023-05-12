<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaksi extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $primaryKey = 'id_transaksi';
    protected $fillable = [
        'id_transaksi',
        'id_customer',
        'id_mobil',
        'id_driver',
        'id_pegawai',
        'tanggal_transaksi',
        'tanggal_mulai_sewa',
        'tanggal_selesai_sewa',
        'status_transaksi',
        'id_promo',
        'metode_pembayaran',
        'bukti_transfer',
        'tanggal_pengembalian',
        'total_denda',
        'total_promo',
        'subtotal_pembayaran',
        'total_pembayaran',
        'status_pembayaran',
        'total_tarif_driver',
        'jenis_peminjaman',
        'rating_driver_transaksi'
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

    public function Customer(){
        return $this->belongsTo(Customer::class, 'id_customer', 'id_customer');
    }

    public function Mobil(){
        return $this->belongsTo(Mobil::class, 'id_mobil', 'id_mobil');
    }

    public function Driver(){
        return $this->belongsTo(Driver::class, 'id_driver', 'id_driver');
    }

    public function Pegawai(){
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');
    }

    public function Promo(){
        return $this->belongsTo(Promo::class, 'id_promo', 'id_promo');
    }
}
