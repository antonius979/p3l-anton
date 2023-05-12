<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::all();

        if(count($member)>0){
                return response([
                'message' =>'Retrieve All Success',
                'data' =>$member
                ],200);
            }

        return response([
            'message' => 'Empty',
            'data' =>null
            ],404);
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
            'nama_member' => 'required',
            'alamat_member' => 'required',
            'tanggal_lahir_member'=>'required|date',
            'jenis_kelamin_member' => 'required',
            'no_telp_member' => 'required|numeric|digits_between:10,13|starts_with:08',
            'email'=>'required|email:rfc,dns|unique:customers|unique:pegawais|unique:drivers',
            'umur' => 'required|numeric',
            'username' => 'required',
            'password' => 'required',
            'sisa_deposit_uang' => 'required',
            'sisa_deposit_kelas' => 'required',
            'masa_berlaku' => 'required',
            'paket' => 'required',
            'status_member',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error validasi

        // GENERATE ID
        $get_data = Member::orderBy('id_member','DESC')->first();

        if(is_null($get_data)) {
            $id_member = date('y').'.'.date('m').'.'.sprintf('%03d', 1);
        } else {
            $find = explode('-', $get_data->id_member)[1];
            $increment = $find + 1;
            // $id_customer = 'CUS'.date('ymd').'-'.sprintf('%03d', $increment);
            $id_member = date('y').'.'.date('m').'.'.sprintf('%03d', $increment);
        }

        $storeData['password'] = bcrypt($request->tanggal_lahir); //enkripsi password

        // //untuk gambar
        // if(($request->hasFile('ktp_customer'))){    
        //     $foto1 = $request->file('ktp_customer');
        //     $foto_ktp = $foto1->getClientOriginalName();
        //     $foto1->move(public_path("source_ktpCustomer/"), $foto_ktp);
        // }

        // if($request->hasFile('sim_customer')){    
        //     $foto2 = $request->file('sim_customer');
        //     $foto_sim = $foto2->getClientOriginalName();
        //     $foto2->move(public_path("source_simCustomer/"), $foto_sim);
        // }else {
        //     $foto_sim = null;
        // }

        // if($request->hasFile('foto_customer')){    
        //     $foto3 = $request->file('foto_customer');
        //     $foto_customer = $foto3->getClientOriginalName();
        //     $foto3->move(public_path("source_fotoCustomer/"), $foto_customer);
        // }


        // $storeData['ktp_customer']= $foto_ktp;
        // $storeData['sim_customer']= $foto_sim;
        // $storeData['foto_customer']= $foto_customer;

        $member = Member::create([
            'id_member' => $id_member,
            'nama_member' => $request->nama_member,
            'email' => $request->email,
            'password' => bcrypt($request->tanggal_lahir_member),
            'alamat_member' => $request->alamat_member,
            'tanggal_lahir_member' => $request->tanggal_lahir_member,
            'jenis_kelamin_member' => $request->jenis_kelamin_member,
            'no_telp_member' => $request->no_telp_member,
            'umur' => $request->umur,
            'username' => $request->username,
            'sisa_deposit_uang' => $request->sisa_deposit_uang,
            'sisa_deposit_kelas' => $request->sisa_deposit_kelas,
            'masa_berlaku' => $request->masa_berlaku,
            'paket' => $request->paket,
            'status_member' => $request->status_member,
        ]);
      
        return response([
            'message' => 'Register Success',
            'data' =>$member,
        ],200); // return data user dalam bentuk json
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id_member)
    {
        $member = Member::find($id_member);

        if(!is_null($member)){
            return response([
                'message' => 'Retrieve Member Success',
                'data' => $member
            ], 200);
        }

        return response([
            'message' => 'Member Not Found',
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
    public function update(Request $request, $id_member)
    {
        $member = Member::find($id_member);
   
        if(is_null($member)){
            return response([
                'message'=>'Member Not Found',
                'data'=>null
            ],404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData,[
            'nama_member' => 'required',
            'alamat_member' => 'required',
            'tanggal_lahir_member'=>'required|date',
            'jenis_kelamin_member' => 'required',
            'no_telp_member' => 'required|numeric|digits_between:10,13|starts_with:08',
            'umur' => 'required|numeric',
            'username' => 'required',
            'sisa_deposit_uang' => 'required',
            'sisa_deposit_kelas' => 'required',
            'paket' => 'required',
            'masa_berlaku' => 'required',
            'status_member',
            'email' => ['required', Rule::unique('members')->ignore($member), Rule::unique('pegawais'), Rule::unique('instrukturs')],
            'password' => 'nullable',
        ]);


        if($validate->fails())
            return response(['message'=> $validate->errors()],400);
        
        $updateData['password'] = bcrypt($request->password);
        

        $member->nama_member = $updateData['nama_member'];
        $member->alamat_member = $updateData['alamat_member'];
        $member->tanggal_lahir_member = $updateData['tanggal_lahir_member'];
        $member->jenis_kelamin_member = $updateData['jenis_kelamin_member'];
        $member->no_telp_member = $updateData['no_telp_member'];
        $member->email = $updateData['email'];
        $member->username = $updateData['username'];
        $member->umur = $updateData['umur'];
        if(isset($request->password)){
            $updateData['password'] = bcrypt($request->password);
            $member->password = $updateData['password'];
        }
        $member->sisa_deposit_uang = $updateData['sisa_deposit_uang'];
        $member->sisa_deposit_kelas = $updateData['sisa_deposit_kelas'];
        $member->masa_berlaku = $updateData['masa_berlaku'];
        $member->paket = $updateData['paket'];
        // $member->status_member = $updateData['status_member'];
        

        if($member->save()){
            return response([
                'message' => 'Update Member Success',
                'data'=> $member,
            ],200);
        }

        return response([
            'messsage'=>'Update Member Failed',
            'data'=>null,
        ],400);
    }

    public function updateStatus(Request $request, $id_member){
        $member = Member::find($id_member);
        if(is_null($member)){
            return response([
                'message'=>'Member Not Found',
                'data'=>null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'status_member'=> 'required',
        ]);

        if($validate->fails())
            return response(['message'=> $validate->errors()],400);
    
        $member->status_member = $updateData['status_member'];

        if($member->save()){
            return response([
                'message' => 'Update Member Success',
                'data'=> $member,
            ],200);
        }

        return response([
            'messsage'=>'Update Member Failed',
            'data'=>null,
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_member)
    {
        $member = Member::find($id_member);

        if(is_null($member)){
            return response([
                'message' => 'Member Not Found',
                'data' => null
            ],404);
        }

        if($member->delete()){
            return response([
                'message' => 'Delete Member Success',
                'data' => $member
            ],200);
        }

        return response([
            'message'=>'Delete Member Success',
            'data'=> null
        ],400);
    }
}
