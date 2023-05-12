<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\DetailJadwal;
use Illuminate\Support\Facades\DB;

class DetailJadwalController extends Controller
{
    public function indexAdmin()
    {
        
        $detailJadwal = DB::table('detail_jadwals')
                        ->join('jadwal_pegawais', 'detail_jadwals.id_jadwal_pegawai', '=', 'jadwal_pegawais.id_jadwal_pegawai')
                        ->join('pegawais', 'detail_jadwals.id_pegawai', '=', 'pegawais.id_pegawai')
                        ->join('roles', 'pegawais.id_role', '=', 'roles.id_role')
                        ->select('detail_jadwals.*', 'jadwal_pegawais.hari_kerja', 'jadwal_pegawais.shift'
                        , 'pegawais.nama_pegawai', 'pegawais.id_role', 'roles.nama_role')->where('roles.id_role', '=', 2)
                        ->orderBy('pegawais.nama_pegawai')
                        ->get();

        

        if(count($detailJadwal) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function indexCS()
    {
        $detailJadwal = DB::table('detail_jadwals')
                        ->join('jadwal_pegawais', 'detail_jadwals.id_jadwal_pegawai', '=', 'jadwal_pegawais.id_jadwal_pegawai')
                        ->join('pegawais', 'detail_jadwals.id_pegawai', '=', 'pegawais.id_pegawai')
                        ->join('roles', 'pegawais.id_role', '=', 'roles.id_role')
                        ->select('detail_jadwals.*', 'jadwal_pegawais.hari_kerja', 'jadwal_pegawais.shift'
                        , 'pegawais.nama_pegawai', 'pegawais.id_role', 'roles.nama_role')->where('roles.id_role', '=', 3)
                        ->orderBy('pegawais.nama_pegawai')
                        ->get();

        if(count($detailJadwal) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }



    public function show($id_detail_jadwal)
    {
        $detailJadwal = DetailJadwal::find($id_detail_jadwal);

        if(!is_null($detailJadwal)){
            return response([
                'message' => 'Retrieve Jadwal Pegawai Success',
                'data' => $detailJadwal
            ], 200);
        }

        return response([
            'message' => 'Jadwal Pegawai Not Found',
            'data' => null
        ]);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_pegawai' => 'required',
            'id_jadwal_pegawai' => 'required',
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 

        $jadwal = DB::table('detail_jadwals')
        ->join('jadwal_pegawais', 'detail_jadwals.id_jadwal_pegawai', '=', 'jadwal_pegawais.id_jadwal_pegawai')
        ->join('pegawais', 'detail_jadwals.id_pegawai', '=', 'pegawais.id_pegawai')
        ->join('roles', 'pegawais.id_role', '=', 'roles.id_role')
        ->select('detail_jadwals.id_pegawai','pegawais.nama_pegawai')
        ->where('detail_jadwals.id_pegawai','=', $request->id_pegawai)
        ->get();

        if(count($jadwal)<6){
        
            $detailJadwal = DetailJadwal::create($storeData);
            return response([
                'message'=>'Add Jadwal Pegawai Success',
                'data'=>$detailJadwal
            ],200);
        }else{
            return response([
                'message'=>'Jadwal Setiap Pegawai Max 6',
                'data'=>null,
            ],400);
        }

       
    }


    public function destroy($id_detail_jadwal)
    {
        $detailJadwal = DetailJadwal::find($id_detail_jadwal);

        if(is_null($detailJadwal)){
            return response([
                'message' => 'Jadwal Pegawai Not Found',
                'data' => null
            ],404);
        }

        if($detailJadwal->delete()){
            return response([
                'message' => 'Delete Jadwal Pegawai Success',
                'data' => $detailJadwal
            ],200);
        }

        return response([
            'message'=>'Delete Jadwal Pegawai Success',
            'data'=> null
        ],400);
    }

    public function update(Request $request, $id_detail_jadwal)
    {
        $detailJadwal = DetailJadwal::find($id_detail_jadwal);
        if(is_null($detailJadwal)) {
            return response([
                'message' => 'Jadwal Pegawai Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_pegawai' => 'required',
            'id_jadwal_pegawai' => 'required'
            
        ]);

        if($validate->fails())
        return response(['message'=>$validate->errors()],400); 

        $detailJadwal->id_pegawai = $updateData['id_pegawai'];
        $detailJadwal->id_jadwal_pegawai = $updateData['id_jadwal_pegawai'];
       
        if($detailJadwal->save()) {
            return response([
                'message' => 'Update Jadwal Pegawai Success',
                'data' => $detailJadwal
            ],200);
        }

        return response([
            'message' => 'Update Jadwal Pegawai Failed',
            'data' => null
        ],400);

    }
}
