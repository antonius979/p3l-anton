<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\JadwalPegawai;
use Illuminate\Support\Facades\DB;

class JadwalPegawaiController extends Controller
{
    public function index()
    {
        $jadwalPegawai = JadwalPegawai::all();

        if(count($jadwalPegawai) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $jadwalPegawai
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id_jadwal_pegawai)
    {
        $jadwalPegawai = JadwalPegawai::find($id_jadwal_pegawai);
        if(!is_null($jadwalPegawai)){
            return response([
                'message' => 'Retrieve Jadwal Pegawai Success',
                'data' => $jadwalPegawai
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
            'hari_kerja' => 'required',
            'shift' => 'required',
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 
        
        $jadwalPegawai = JadwalPegawai::create($storeData);
        return response([
            'message'=>'Add Jadwal Pegawai Success',
            'data'=>$jadwalPegawai
        ],200);
    }

    public function destroy($id_jadwal_pegawai)
    {
        $jadwalPegawai = JadwalPegawai::find($id_jadwal_pegawai);

        if(is_null($jadwalPegawai)){
            return response([
                'message' => 'Jadwal Pegawai Not Found',
                'data' => null
            ],404);
        }

        if($jadwalPegawai->delete()){
            return response([
                'message' => 'Delete Jadwal Pegawai Success',
                'data' => $jadwalPegawai
            ],200);
        }

        return response([
            'message'=>'Delete Jadwal Pegawai Success',
            'data'=> null
        ],400);
    }

    public function update(Request $request, $id_jadwal_pegawai)
    {
        $jadwalPegawai = JadwalPegawai::find($id_jadwal_pegawai);
        if(is_null($jadwalPegawai)) {
            return response([
                'message' => 'Jadwal Pegawai Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'hari_kerja' => 'required',
            'shift' => 'required'
            
        ]);

        if($validate->fails())
        return response(['message'=>$validate->errors()],400); 

        $jadwalPegawai->hari_kerja = $updateData['hari_kerja'];
        $jadwalPegawai->shift = $updateData['shift'];
       
        if($jadwalPegawai->save()) {
            return response([
                'message' => 'Update Jadwal Pegawai Success',
                'data' => $jadwalPegawai
            ],200);
        }

        return response([
            'message' => 'Update Jadwal Pegawai Failed',
            'data' => null
        ],400);

    }
}
