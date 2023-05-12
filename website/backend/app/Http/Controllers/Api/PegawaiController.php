<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    // public function index(){
    //     $pegawai = Pegawai::join('roles','roles.id_role', '=', 'pegawais.id_role')
    //     ->select('pegawais.*','roles.nama_role')
    //     ->get();

    //     if(count($pegawai)>0){
    //             return response([
    //             'message' =>'Retrieve All Success',
    //             'data' =>$pegawai
    //             ],200);
    //         }

    //     return response([
    //         'message' => 'Empty',
    //         'data' =>null
    //         ],404);
    // }

    // public function show ($id_pegawai){
    //     $pegawai = Pegawai::find($id_pegawai);

    //     if(!is_null($pegawai)){
    //         return response([
    //             'message'  => 'Retrieve pegawai Success',
    //             'data' => $pegawai
    //         ],200);

    //     }

    //     return response([
    //         'message' => 'Pegawai Not Found',
    //         'data' => null
    //     ],404);
    // }

    // public function store(Request $request)
    // {
    //     $registrationData = $request->all();
    //     $validate = Validator::make($registrationData, [
    //         'id_role' => 'required',
    //         'foto_pegawai' => 'mimes:jpeg,jpg,png,gif',
    //         'nama_pegawai' => 'required|max:60',
    //         'tanggal_lahir_pegawai' => 'required|date',
    //         'jenis_kelamin_pegawai' => 'required',
    //         'alamat_pegawai'=> 'required|max:60',
    //         'no_telp_pegawai'=> 'required|numeric|digits_between:10,13|starts_with:08',
    //         'email'=> 'required|email:rfc,dns|unique:pegawais|unique:customers|unique:drivers',
    //     ]);

    //     if($validate->fails())
    //         return response(['message' => $validate->errors()], 400); // return error validasi

    //     $registrationData['password'] = bcrypt($request->tanggal_lahir_pegawai);
    //     //untuk gambar
    //     if($request->hasFile('foto_pegawai')){    
    //         $foto = $request->file('foto_pegawai');
    //         $foto_name = $foto->getClientOriginalName();
    //         $foto->move(public_path("source_imagePegawai/"), $foto_name);
    //     }

    //     $registrationData['foto_pegawai']= $foto_name;
    //     $pegawai = Pegawai::create([
    //         'id_role' => $request->id_role,
    //         'foto_pegawai' => $foto_name,
    //         'nama_pegawai' => $request->nama_pegawai,
    //         'tanggal_lahir_pegawai' => $request->tanggal_lahir_pegawai,
    //         'jenis_kelamin_pegawai' => $request->jenis_kelamin_pegawai,
    //         'alamat_pegawai' => $request->alamat_pegawai,
    //         'no_telp_pegawai' => $request->no_telp_pegawai,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->tanggal_lahir_pegawai),
    //     ]);
    //     return response([
    //         'message'=>'Register Success',
    //         'data'=>$pegawai,
    //     ],200);
    // }

    // public function update(Request $request, $id_pegawai){
    //     $pegawai = Pegawai::find($id_pegawai);
    //     if(is_null($pegawai)){
    //         return response([
    //             'message'=>'Pegawai Not Found',
    //             'data'=>null
    //         ],404);
    //     }

    //     $updateData = $request->all();
    //     $validate = Validator::make($updateData,[
    //         'id_role' => 'required',
    //         'nama_pegawai' => 'required|max:60',
    //         'tanggal_lahir_pegawai' => 'required|date',
    //         'jenis_kelamin_pegawai' => 'required',
    //         'alamat_pegawai'=> 'required|max:60',
    //         'no_telp_pegawai'=> 'required|numeric|digits_between:10,13|starts_with:08',
    //         'email'=> ['required','email:rfc,dns', Rule:: unique('pegawais')->ignore($pegawai), Rule::unique('customers'), Rule::unique('drivers')],
     
    //     ]);

    //     if($validate->fails())
    //         return response(['message'=> $validate->errors()],400);
        
    //     $pegawai->id_role = $updateData['id_role'];
    //     $pegawai->nama_pegawai = $updateData['nama_pegawai'];
    //     $pegawai->tanggal_lahir_pegawai = $updateData['tanggal_lahir_pegawai'];
    //     $pegawai->jenis_kelamin_pegawai = $updateData['jenis_kelamin_pegawai'];
    //     $pegawai->alamat_pegawai = $updateData['alamat_pegawai'];
    //     $pegawai->no_telp_pegawai = $updateData['no_telp_pegawai'];
    //     $pegawai->email = $updateData['email'];
    //     if(isset($request->password)){
    //         $updateData['password'] = bcrypt($request->password);
    //         $pegawai->password = $updateData['password'];
    //     }

    //     if($pegawai->save()){
    //         return response([
    //             'message' => 'Update Pegawai Success',
    //             'data'=> $pegawai,
    //         ],200);
    //     }

    //     return response([
    //         'messsage'=>'Update Pegawai Failed',
    //         'data'=>null,
    //     ],400);
    // }

    // public function destroy($id_pegawai){
    //     $pegawai = Pegawai::find($id_pegawai);

    //         if(is_null($pegawai)){
    //             return response([
    //                 'message' => 'Pegawai Not Found',
    //                 'data'=>null
    //             ],404);
    //         }

    //         if($pegawai->delete()){
    //             return response([
    //                 'message' => 'Delete pegawai Success',
    //                 'data' =>$pegawai,
    //             ],200);
    //         }
    //         return response([
    //             'message' => 'Delete pegawai Failed',
    //             'data' => null,
    //         ],400);
        
    // }

    // public function updateFoto(Request $request, $id_pegawai){
    //     $pegawai= Pegawai::find($id_pegawai);

    //     if(is_null($pegawai)){
    //         return response([
    //             'message' => 'Pegawai Not Found',
    //             'data' => $pegawai
    //         ],404);
    //     }

    //     if(!$request->hasFile('foto_pegawai')){
    //         return response([
    //             'message' => 'Update Foto Pegawai Failed',
    //             'data' => null
    //         ],400);
    //     }

    //     $file6 = $request->file('foto_pegawai');

    //     if(!$file6->isValid()){
    //         return response([
    //             'message' => 'Update Foto Pegawai Failed',
    //             'data' => null
    //         ],400);
    //     }

    //     $foto6 = public_path().'/source_imagePegawai/';
    //     $file6->move($foto6,$file6->getClientOriginalName());
    //     $foto_pegawai= $file6->getClientOriginalName();
    //     $foto6 = '/source_imagePegawai'.$file6->getClientOriginalName();

    //     $updateData = $request->all();

    //     $pegawai->foto_pegawai = $foto_pegawai;

    //     if($pegawai->save()){
    //         return response([
    //             'message' => 'Update Dokumen Success',
    //             'data' => $foto_pegawai
    //         ],200);
    //     }

    //     return response([
    //         'message' => 'Update Dokumen Failed',
    //         'data' => null
    //     ],400);

    // }


}
