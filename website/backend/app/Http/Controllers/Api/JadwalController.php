<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Jadwal;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jadwal = DB::table('jadwals')
        ->join('instrukturs', 'jadwals.id_instruktur', '=', 'instrukturs.id_instruktur')
        ->join('kelas', 'jadwals.id_kelas', '=', 'kelas.id_kelas')
        ->select('jadwals.*', 'instrukturs.nama_instruktur'
        , 'kelas.nama_kelas')
        ->get();

        if(count($jadwal) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $jadwal
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
            'id_instruktur' => 'required',
            'id_kelas' => 'required',
            'hari_kerja' => 'required',
            'jam' => 'required',
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 

        $jadwal = DB::table('jadwals')
        ->join('instrukturs', 'jadwals.id_instruktur', '=', 'instrukturs.id_instruktur')
        ->join('kelas', 'jadwals.id_kelas', '=', 'kelas.id_kelas')
        ->select('jadwals.*', 'instrukturs.nama_instruktur'
        , 'kelas.nama_kelas')
        ->where('jadwals.id_instruktur','=', $request->id_instruktur)
        ->get();

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 
        
        $jadwal = Jadwal::create($storeData);
        return response([
            'message'=>'Add Jadwal Success',
            'data'=>$jadwal
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);

        if(!is_null($jadwal)){
            return response([
                'message' => 'Retrieve Jadwal Success',
                'data' => $jadwal
            ], 200);
        }

        return response([
            'message' => 'Jadwal Not Found',
            'data' => null
        ]);
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
    public function update(Request $request, $id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);
        if(is_null($jadwal)) {
            return response([
                'message' => 'Jadwal Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_instruktur' => 'required',
            'id_kelas' => 'required',
            'hari_kerja' => 'required',
            'jam' => 'required',
            
        ]);

        if($validate->fails())
        return response(['message'=>$validate->errors()],400); 

        $jadwal->id_instruktur = $updateData['id_instruktur'];
        $jadwal->id_kelas = $updateData['id_kelas'];
        $jadwal->hari_kerja = $updateData['hari_kerja'];
        $jadwal->jam = $updateData['jam'];
       
        if($jadwal->save()) {
            return response([
                'message' => 'Update Jadwal Success',
                'data' => $jadwal
            ],200);
        }

        return response([
            'message' => 'Update Jadwal Failed',
            'data' => null
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);

        if(is_null($jadwal)){
            return response([
                'message' => 'Jadwal Not Found',
                'data' => null
            ],404);
        }

        if($jadwal->delete()){
            return response([
                'message' => 'Delete Jadwal Success',
                'data' => $jadwal
            ],200);
        }

        return response([
            'message'=>'Delete Jadwal Success',
            'data'=> null
        ],400);
    }
}
