<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\DepositKelas;
use Illuminate\Support\Facades\DB;

class DepositKelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depositKelas = DB::table('deposit_kelas')
        ->join('pegawais', 'deposit_kelas.id_pegawai', '=', 'members.id_pegawai')
        ->join('members', 'deposit_kelas.id_member', '=', 'members.id_member')
        ->join('kelas', 'deposit_kelas.id_kelas', '=', 'kelas.id_kelas')
        ->select('deposit_kelas.*', 'pegawais.nama_pegawai', 'members.nama_member'
        , 'kelas.nama_kelas')
        ->get();

        
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
    // public function store(Request $request) { 
    //     $storeData = $request -> all(); 
    //     $validate = Validator::make($storeData, [ 
    //         'id_kasir' => 'required', 
    //         'id_member' => 'required', 
    //         'id_promo' => 'required', 
    //         'deposit' => 'required', 
    //     ]); 
    //     if($validate->fails()) 
    //         return response(['message' => $validate->errors()],400);
         
    //         $member = Member::where('id_member', $storeData['id_member'])->first(); 
    //         $count = DB::table('transaksi_deposit_reguler')->count()+300; 
    //         $generate = sprintf("%d", $count); 
    //         $date = Carbon::now()->format('y.m'); 
    //         $storeData['no_struk'] = $date.'.'.$generate; 
    //         $storeData['tanggal_transaksi'] = date('Y-m-d H:i:s'); 
    //         $storeData['sisa_deposit'] = $member->deposit_member; 
    //         $storeData['bonus_deposit'] = 0; 
            
    //         if($storeData['id_promo'] == 2) 
    //         { if($storeData['deposit'] < 500000) {
    //             return response([ 'message' => 'Minimal Deposit 500.000', ], 400); 
    //         } else { 
    //             if($storeData['deposit'] >= 3000000) { 
    //                 $storeData['bonus_deposit'] = 300000; 
    //             } 
    //         } 
    //     } $storeData['total_deposit'] = $storeData['deposit'] + $storeData['bonus_deposit'] + $storeData['sisa_deposit']; 
    //     $member->deposit_member = $storeData['total_deposit']; 
    //     $member->save(); 
    //     $depositReguler = DepositReguler::create($storeData); 
    //     return response([ 'message' => 'Add Deposit Reguler Success', 'data' => $depositReguler, ], 200);
    
    
    
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            // 'id_instruktur'=> 'required',
            'id_member' => 'required',
            'id_pegawai' => 'required',
            'id_kelas' => 'required',
            'berlaku' => 'required',
            'deposit' => 'required',
            'total_deposit'=> 'required'
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 

        // GENERATE ID
        $get_data = DepositKelas::orderBy('id_deposit_kelas','DESC')->first();

        if(is_null($get_data)) {
            $id_deposit_kelas = date('y').'.'.date('m').'.'.sprintf('%03d', 1);
        } else {
            $find = explode('-', $get_data->id_deposit_kelas)[1];
            $increment = $find + 1;
            $id_deposit_kelas = date('y').'.'.date('m').'.'.sprintf('%03d', $increment);
        }

        $depositKelas = DB::table('deposit_kelas')
        ->join('pegawais', 'deposit_kelas.id_pegawai', '=', 'members.id_pegawai')
        ->join('members', 'deposit_kelas.id_member', '=', 'members.id_member')
        ->join('kelas', 'deposit_kelas.id_kelas', '=', 'kelas.id_kelas')
        ->select('deposit_kelas.*', 'pegawais.nama_pegawai', 'members.nama_member'
        , 'kelas.nama_kelas')
        ->get();

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 
        
        $depositKelas = DepositKelas::create($storeData);
        return response([
            'message'=>'Add Deposit Kelas Success',
            'data'=>$depositKelas
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
