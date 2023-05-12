<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use App\Models\Driver;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Validator;

class LoginAndroidController extends Controller
{
    public function login(Request $request)
    {
        $loginData = $request->all();
        $validate = Validator::make($loginData, [
            'email' => 'required|email:rfc,dns',
            'password' => 'required'
        ]); 

        if(Customer::where('email', $loginData['email'])->first()){
           $loginCustomer = Customer::where('email', $loginData['email'])
                                    ->where('status_customer', 'Belum Terverifikasi')->first();
            if($loginCustomer){
                return response([
                    'message' => 'data belum diverifikasi',
                    'data' => null
                ],404);
            }

            $checkHashedPass = Customer::where('email', $request->email)->first();

            $checkedPass = Hash::check($request->password, $checkHashedPass->password);

            if($checkedPass){
                $data = Customer::where('email', $request->email)->first();
                return response([
                    'message' => 'customer berhasil login',
                    'customer' => $data
                ]);
            }
        }
        else if(Pegawai::where('email',$loginData['email'])->first()){
            $loginPegawai = Pegawai::where('email', $loginData['email'])->first();

            $checkHashedPass = Pegawai::where('email', $request->email)->first();
            $checkedPass = Hash::check($request->password, $checkHashedPass->password);

            if($checkedPass){
                $data = Pegawai::where('email', $request->email)->first();
                return response([
                    'message' => 'pegawai berhasil login',
                    'pegawai' => $data
                ]);
            }
        }
        else if(Driver::where('email',$loginData['email'])->first()){
            $loginDriver = Driver::where('email', $loginData['email'])->first();

            $checkHashedPass = Driver::where('email', $request->email)->first();
            $checkedPass = Hash::check($request->password, $checkHashedPass->password);

            if($checkedPass){
                $data = Driver::where('email', $request->email)->first();
                return response([
                    'message' => 'driver berhasil login',
                    'driver' => $data
                ]);
            }
        }
      
        return response([
            'message' => 'Login gagal, username/password kamu masih salah',
            'data' => null
        ], 404);
    

        if ($validate->fails())
            return response(['message' => $validate->error()], 400); //return error validasi input
    }
}
