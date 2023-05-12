<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\DepositUang;
use Illuminate\Support\Facades\DB;

class DepositUangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $depositUang = DB::table('deposit_uangs')
        ->join('pegawais', 'deposit_uangs.id_pegawai', '=', 'members.id_pegawai')
        ->join('members', 'deposit_uangs.id_member', '=', 'members.id_member')
        ->join('kelas', 'deposit_uangs.id_kelas', '=', 'kelas.id_kelas')
        ->select('deposit_uangs.*', 'pegawais.nama_pegawai', 'members.nama_member'
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
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            // 'id_instruktur'=> 'required',
            'id_member' => 'required',
            'id_pegawai' => 'required',
            'id_kelas' => 'required',
            'bonus_deposit' => 'required',
            'sisa_deposit' => 'required',
            'total_deposit'=> 'required'
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 

        // GENERATE ID
        $get_data = DepositUang::orderBy('id_deposit_uang','DESC')->first();

        if(is_null($get_data)) {
            // $id_customer = 'CUS'.date('ymd').'-'.sprintf('%03d', 1);
            $id_deposit_uang = date('y').'.'.date('m').'.'.sprintf('%03d', 1);
        } else {
            $find = explode('-', $get_data->id_deposit_uang)[1];
            $increment = $find + 1;
            // $id_customer = 'CUS'.date('ymd').'-'.sprintf('%03d', $increment);
            $id_deposit_uang = date('y').'.'.date('m').'.'.sprintf('%03d', $increment);
        }

        $depositUang = DB::table('deposit_uangs')
        ->join('pegawais', 'deposit_uangs.id_pegawai', '=', 'members.id_pegawai')
        ->join('members', 'deposit_uangs.id_member', '=', 'members.id_member')
        ->join('kelas', 'deposit_uangs.id_kelas', '=', 'kelas.id_kelas')
        ->select('deposit_uangs.*', 'pegawais.nama_pegawai', 'members.nama_member'
        , 'kelas.nama_kelas')
        ->get();

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 
        
        $depositUang = DepositUang::create($storeData);
        return response([
            'message'=>'Add Deposit Uang Success',
            'data'=>$depositUang
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
