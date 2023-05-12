<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\AktivasiTahunan;
use App\Models\Member;
use App\Models\Pegawai;
use Illuminate\Support\Facades\DB;
use DateTime;
use PDF;

class AktivasiTahunanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $aktivasiTahunan = AktivasiTahunan::with(['Member', 'Pegawai'])->orderBy('created_at', 'ASC')->get();

        if(count($aktivasiTahunan) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $aktivasiTahunan
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();

        $validate = Validator::make($storeData, [
            'id_aktivasi_tahunan' => 'nullable',
            'id_member' => 'required', 
            'id_pegawai' => 'nullable', 
            'tanggal_transaksi' => 'required',
            'aktivasi_tahunan' => 'nullable',
            'masa_aktif' => 'nullable'
        ]); 

        if($validate->fails()){
            return response(['message' => $validate->errors()], 400);
        }

        // Generate ID Transaksi
        $database = DB::table('aktivasi_tahunans')->count();
        $member = Member::where('id_member', $request->id_member)->first();

        // if($database == 0) {
        //     if(strcmp($request->jenis_peminjaman, 'Mobil + Driver') == 0){
        //         $id_transaksi = 'TRN'.date('ymd').'01-'.sprintf('%03d', 1);
        //     } else{
        //         $id_transaksi = 'TRN'.date('ymd').'00-'.sprintf('%03d', 1);
        //     }
        // } else {
        //     $get_data = Transaksi::select(DB::raw('GROUP_CONCAT(distinct SUBSTRING(id_transaksi,-3)) as new_id_transaksi'))->get();

        //     foreach($get_data as $new_value){
        //         $find = substr($new_value['new_id_transaksi'], -3);
        //     }

        //     $increment = $find + 1;

        //     if(strcmp($request->jenis_peminjaman, 'Mobil + Driver') == 0){
        //         $id_transaksi = 'TRN'.date('ymd').'01-'.sprintf('%03d', $increment);
        //     } else{
        //         $id_transaksi = 'TRN'.date('ymd').'00-'.sprintf('%03d', $increment);
        //     }
        // }

        // if($request->hasFile('bukti_transfer')){    
        //     $foto1 = $request->file('bukti_transfer');
        //     $foto_bukti_transfer = $foto1->getClientOriginalName();
        //     $foto1->move(public_path("source_buktiTransfer/"), $foto_bukti_transfer);
        // } else {
        //     $foto_bukti_transfer = null;
            
        // }

        // $mobil = Mobil::where('id_mobil', $request->id_mobil)->first();
        // $tarifMobil = $mobil->harga_sewa_mobil_perhari;

        // if(is_null($request->id_promo)){
        //     $tarifPromo = 0;
        // }
        // else{
        //     $promo = Promo::where('id_promo', $request->id_promo)->first();
        //     $tarifPromo = $promo->diskon_promo;
        // }
        
        $aktivasiTahunan = AktivasiTahunan::create([
            'id_aktivasi_tahunan ' => $id_aktivasi_tahunan,
            'id_member ' => $request->id_member ,
            'id_pegawai' => $request->id_pegawai,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'masa_aktif' => $request->masa_aktif,
            'aktivasi_tahunan' => $request->aktivasi_tahunan,
        ]);

        return response([
            'message' => 'Add Transaksi Success',
            'data' => $aktivasiTahunan
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_aktivasi_tahunan)
    {
        $aktivasiTahunan = AktivasiTahunan::with(['Member', 'Pegawai'])->orderBy('created_at', 'ASC')->get();
     
        if(!is_null($transaksi)){
            return response([
                'message' => 'Retrieve Transaksi Aktivasi Tahunan Success',
                'data' => $aktivasiTahunan
            ], 200);
        }

        return response([
            'message' => 'Transaksi  Aktivasi Tahunan Not Found',
            'data' => null
        ], 400);
    }

    public function showTransaksi($id_member){
        $aktivasiTahunan = AktivasiTahunan::with(['Member', 'Pegawai'])->where('id_member','=',$id_member)->where('status_transaksi', 'Belum Terverifikasi')->orderBy('created_at', 'ASC')->get();

    if(count($transaksi)>0){
           return response ([
               'message' => 'Retrieve All Transaksi Pelanggan Success',
               'data' => $aktivasiTahunan
           ], 200);
       }

       return response([
           'message' => 'Empty',
           'data' => null
       ], 400);
   }


   public function showTransaksiBayar($id_member){
    $aktivasiTahunan = AktivasiTahunan::with(['Member', 'Pegawai'])->where('id_member','=',$id_member)->where('status_pembayaran', 'Belum Bayar')->where('status_transaksi', 'Sudah Terverifikasi')->orderBy('created_at', 'ASC')->get();

        if(count($transaksi)>0){
            return response ([
                'message' => 'Retrieve All Transaksi Pelanggan Success',
                'data' => $aktivasiTahunan
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function showTransaksiAll($id_member){
        $aktivasiTahunan = AktivasiTahunan::with(['Member', 'Pegawai'])->where('id_member','=',$id_member)->where('status_pembayaran', 'Sudah Bayar')->where('status_transaksi', 'Sudah Terverifikasi')->orderBy('created_at', 'ASC')->get();

    if(count($aktivasiTahunan)>0){
           return response ([
               'message' => 'Retrieve All Transaksi Pelanggan Success',
               'data' => $aktivasiTahunan
           ], 200);
       }

       return response([
           'message' => 'Empty',
           'data' => null
       ], 400);
   }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
