<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\JadwalHarian;
use Illuminate\Support\Facades\DB;

class JadwalHarianController extends Controller
{
    public function index()
    {
        $jadwalHarian = DB::table('jadwal_harians')
        ->join('jadwals', 'jadwal_harians.id_jadwal', '=', 'jadwals.id_jadwal')
        ->join('instrukturs', 'jadwal_harians.id_instruktur', '=', 'instrukturs.id_instruktur')
        ->join('kelas', 'jadwal_harians.id_kelas', '=', 'kelas.id_kelas')
        ->select('jadwal_harians.*', 'jadwals.hari_kerja', 'jadwals.jam', 'instrukturs.nama_instruktur'
        , 'kelas.nama_kelas')
        ->orderBy('instrukturs.nama_instruktur')
        ->get();

        if(count($jadwalHarian) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $jadwalHarian
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
            'id_jadwal' => 'required',
            'id_instruktur' => 'required',
            'id_kelas' => 'required',
            'hari_kerja' => 'required',
            'jam' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 

        $jadwalHarian = DB::table('jadwal_harians')
        ->join('jadwals', 'jadwal_harians.id_jadwal', '=', 'jadwals.id_jadwal')
        ->join('instrukturs', 'jadwal_harians.id_instruktur', '=', 'instrukturs.id_instruktur')
        ->join('kelas', 'jadwal_harians.id_kelas', '=', 'kelas.id_kelas')
        ->select('jadwal_harians.*', 'jadwals.hari_kerja', 'jadwals.jam', 'instrukturs.nama_instruktur'
        , 'kelas.nama_kelas')
        ->orderBy('instrukturs.nama_instruktur')
        ->get();
        // $jadwal = DB::table('jadwals')
        // ->join('instrukturs', 'jadwals.id_instruktur', '=', 'instrukturs.id_instruktur')
        // ->join('kelas', 'jadwals.id_kelas', '=', 'kelas.id_kelas')
        // ->select('jadwals.*', 'instrukturs.nama_instruktur'
        // , 'kelas.nama_kelas')
        // ->where('jadwals.id_instruktur','=', $request->id_instruktur)
        // ->get();

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 
        
        $jadwalHarian = JadwalHarian::create($storeData);
        return response([
            'message'=>'Add Jadwal Harian Success',
            'data'=>$jadwalHarian
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_jadwal_harian)
    {
        $jadwalHarian = JadwalHarian::find($id_jadwal_harian);

        if(!is_null($jadwalHarian)){
            return response([
                'message' => 'Retrieve Jadwal Harian Success',
                'data' => $jadwalHarian
            ], 200);
        }

        return response([
            'message' => 'Jadwal Harian Not Found',
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
    public function update(Request $request, $id_jadwal_harian)
    {
        $jadwalHarian = JadwalHarian::find($id_jadwal_harian);
        if(is_null($jadwalHarian)) {
            return response([
                'message' => ' Jadwal Harian Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'id_jadwal' => 'required',
            'id_instruktur' => 'required',
            'id_kelas' => 'required',
            'hari_kerja' => 'required',
            'jam' => 'required',
            'tanggal' => 'required',
            'keterangan' => 'required',
        ]);

        if($validate->fails())
        return response(['message'=>$validate->errors()],400); 

        $jadwalHarian->id_jadwal = $updateData['id_jadwal'];
        $jadwalHarian->id_instruktur = $updateData['id_instruktur'];
        $jadwalHarian->id_kelas = $updateData['id_kelas'];
        $jadwalHarian->hari_kerja = $updateData['hari_kerja'];
        $jadwalHarian->tanggal = $updateData['tanggal'];
        $jadwalHarian->keterangan = $updateData['keterangan'];
        $jadwalHarian->jam = $updateData['jam'];
       
        if($jadwalHarian->save()) {
            return response([
                'message' => 'Update Jadwal Harian Success',
                'data' => $jadwalHarian
            ],200);
        }

        return response([
            'message' => 'Update Jadwal Harian Failed',
            'data' => null
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_jadwal_harian)
    {
        $jadwalHarian = JadwalHarian::find($id_jadwal_harian);

        if(is_null($jadwalHarian)){
            return response([
                'message' => 'Jadwal Harian Not Found',
                'data' => null
            ],404);
        }

        if($jadwal->delete()){
            return response([
                'message' => 'Delete Jadwal Harian Success',
                'data' => $jadwalHarian
            ],200);
        }

        return response([
            'message'=>'Delete Jadwal Harian Success',
            'data'=> null
        ],400);
    }
}

