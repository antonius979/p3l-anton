<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'username' => 'required',
            'password' => 'required'
        ]); 

        // if(Customer::where('email', $loginData['email'])->first()){
        //    $loginCustomer = Customer::where('email', $loginData['email'])
        //                             ->where('status_customer', 'Belum Terverifikasi')->first();
        //     if($loginCustomer){
        //         return response([
        //             'message' => 'data belum diverifikasi',
        //             'data' => null
        //         ],404);
        //     }

        //     $checkHashedPass = Customer::where('email', $request->email)->first();

        //     $checkedPass = Hash::check($request->password, $checkHashedPass->password);

        //     if($checkedPass){
        //         $data = Customer::where('email', $request->email)->first();
        //         return response([
        //             'message' => 'customer berhasil login',
        //             'data' => $data
        //         ]);
        //     }
        // }
        if(Pegawai::where('username',$loginData['username'])->first()){
            $loginPegawai = Pegawai::where('username', $loginData['username'])->first();

            $checkHashedPass = Pegawai::where('username', $request->username)->first();
            $checkedPass = Hash::check($request->password, $checkHashedPass->password);

            if($checkedPass){
                $data = Pegawai::where('username', $request->username)->first();
                return response([
                    'message' => 'pegawai berhasil login',
                    'data' => $data
                ]);
            }
        }
        // else if(Driver::where('email',$loginData['email'])->first()){
        //     $loginDriver = Driver::where('email', $loginData['email'])->first();

        //     $checkHashedPass = Driver::where('email', $request->email)->first();
        //     $checkedPass = Hash::check($request->password, $checkHashedPass->password);

        //     if($checkedPass){
        //         $data = Driver::where('email', $request->email)->first();
        //         return response([
        //             'message' => 'driver berhasil login',
        //             'data' => $data
        //         ]);
        //     }
        // }
      
        return response([
            'message' => 'Login gagal, username/password kamu masih salah',
            'data' => null
        ], 404);
    

        if ($validate->fails())
            return response(['message' => $validate->error()], 400); //return error validasi input
    }
}
