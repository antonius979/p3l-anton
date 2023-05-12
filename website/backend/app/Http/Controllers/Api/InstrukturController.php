<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Instruktur;
use Illuminate\Support\Facades\DB;

class InstrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $instruktur = Instruktur::all();

        if(count($instruktur) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $instruktur
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
            // 'id_instruktur'=> 'required',
            'nama_instruktur' => 'required',
            'alamat_instruktur' => 'required',
            'tanggal_lahir_instruktur' => 'required|date',
            'jenis_kelamin_instruktur' => 'required',
            'no_telp_instruktur' => 'required|numeric|digits_between:10,13|starts_with:08',
            'email'=> 'required|email:rfc,dns',
            'username'=> 'required',
            'password'=> 'required',
            'waktu_terlambat'=> 'required'
        ]);


        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 

        // //untuk gambar
        // if($request->hasFile('gambar_mobil')){  

        //     $image = $request->file('gambar_mobil');
        //     $img_name = $image->getClientOriginalName();
        //     $image->move(public_path("source_imageMobil/"), $img_name);

        // }
        
    
        // $storeData['gambar_mobil']= $img_name;
       
        $instruktur = Instruktur::create([
            // 'id_instruktur' => $request->id_instruktur,
            'nama_instruktur' => $request->nama_instruktur,
            'alamat_instruktur' => $request->alamat_instruktur,
            'tanggal_lahir_instruktur' => $request->tanggal_lahir_instruktur,
            'jenis_kelamin_instruktur' => $request->jenis_kelamin_instruktur,
            'no_telp_instruktur' => $request->no_telp_instruktur,
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'waktu_terlambat' => $request->waktu_terlambat, 
        ]);


        return response([
            'message'=>'Add Instruktur Success',
            'data'=>$instruktur
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_instruktur)
    {
        $instruktur = Instruktur::find($id_instruktur);

        if(!is_null($instruktur)){
            return response([
                'message' => 'Retrieve Instruktur Success',
                'data' => $instruktur
            ], 200);
        }

        return response([
            'message' => 'Instruktur Not Found',
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
    public function update(Request $request, $id_instruktur)
    {
        $instruktur = Instruktur::find($id_instruktur);
        if(is_null($instruktur)) {
            return response([
                'message' => 'Instruktur Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            // 'id_instruktur'=> 'required',
            'nama_instruktur' => 'required',
            'alamat_instruktur' => 'required',
            'tanggal_lahir_instruktur' => 'required|date',
            'jenis_kelamin_instruktur' => 'required',
            'no_telp_instruktur' => 'required|numeric|digits_between:10,13|starts_with:08',
            'email'=> 'required|email:rfc,dns',
            'username'=> 'required',
            'password'=> 'required',
            'waktu_terlambat'=> 'required'
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 
        

        // $instruktur->id_instruktur = $updateData['id_instruktur'];
        $instruktur->nama_instruktur = $updateData['nama_instruktur'];
        $instruktur->alamat_instruktur = $updateData['alamat_instruktur'];
        $instruktur->tanggal_lahir_instruktur = $updateData['tanggal_lahir_instruktur'];
        $instruktur->jenis_kelamin_instruktur = $updateData['jenis_kelamin_instruktur'];
        $instruktur->no_telp_instruktur = $updateData['no_telp_instruktur'];
        $instruktur->email = $updateData['email'];
        $instruktur->username = $updateData['username'];
        $instruktur->password = $updateData['password'];
        $instruktur->waktu_terlambat = $updateData['waktu_terlambat'];

        if($instruktur->save()) {
            return response([
                'message' => 'Update Instruktur Success',
                'data' => $instruktur
            ],200);
        }

        return response([
            'message' => 'Update  Instruktur Failed',
            'data' => null
        ],400);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_instruktur)
    {
        $instruktur = Instruktur::find($id_instruktur);

        if(is_null($instruktur)){
            return response([
                'message' => 'Instruktur Not Found',
                'data' => null
            ],404);
        }

        if($instruktur->delete()){
            return response([
                'message' => 'Delete Instruktur Success',
                'data' => $instruktur
            ],200);
        }

        return response([
            'message'=>'Delete Instruktur Success',
            'data'=> null
        ],400);
    }
}
