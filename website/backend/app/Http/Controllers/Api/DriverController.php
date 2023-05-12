<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
{
    public function index()
    {
        $driver = Driver::all();

        if(count($driver) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $driver
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function getDriver(){

        $driver = Driver::where('status_ketersediaan_driver', 'Tersedia')->get();

        if(count($driver) > 0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $driver
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }


    public function show($id_driver)
    {
        $driver = Driver::find($id_driver);

        if(!is_null($driver)){
            return response([
                'message' => 'Retrieve Driver Success',
                'data' => $driver
            ], 200);
        }

        return response([
            'message' => 'Driver Not Found',
            'data' => null
        ]);
    }

    public function store(Request $request)
    {
        $registrationData = $request->all();
        $validate = Validator::make($registrationData, [

            'nama_driver' => 'required',
            'alamat_driver' => 'required',
            'tanggal_lahir_driver' => 'required|date',
            'jenis_kelamin_driver' => 'required',
            'no_telp_driver' => 'required|numeric|digits_between:10,13|starts_with:08',
            'email'=> 'required|email:rfc,dns',

            'sim_driver' => 'required|mimes:jpeg,jpg,png,gif,pdf',
            'surat_bebas_napza' => 'required|mimes:jpeg,jpg,png,gif,pdf',
            'surat_kesehatan_jiwa' => 'required|mimes:jpeg,jpg,png,gif,pdf',
            'surat_kesehatan_jasmani' => 'required|mimes:jpeg,jpg,png,gif,pdf',
            'skck' => 'required|mimes:jpeg,jpg,png,gif,pdf',
            'foto_driver' => 'required|mimes:jpeg,jpg,png,gif,pdf',

            'bahasa_asing' => 'required',
            'tarif_driver_perhari' => 'nullable' ,
            'rerata_rating_driver' => 'nullable',
            'status_ketersediaan_driver' => 'required',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error validasi


        // GENERATE ID
        $get_data = Driver::orderBy('id_driver','DESC')->first();

        if(is_null($get_data)) {
            $id_driver = 'DRV-'.date('dmy').sprintf('%03d', 1);
        } else {
            $find = substr($get_data->id_driver, -3);
            $increment = $find + 1;
            $id_driver = 'DRV-'.date('dmy').sprintf('%03d', $increment);
        }

        if($request->bahasa_asing == 'Bahasa Indonesia'){
            $tarifDriver = 100000;
        }
        elseif($request->bahasa_asing == 'Bahasa Indonesia & Bahasa Inggris'){
            $tarifDriver = 200000;
        }


        //untuk gambar
        if($request->hasFile('sim_driver')){    
            $foto1 = $request->file('sim_driver');
            $foto_sim_driver = $foto1->getClientOriginalName();
            $foto1->move(public_path("source_simDriver/"), $foto_sim_driver);
        }

        if($request->hasFile('surat_bebas_napza')){    
            $foto2 = $request->file('surat_bebas_napza');
            $foto_surat_bebas_napza = $foto2->getClientOriginalName();
            $foto2->move(public_path("source_sbnDriver/"), $foto_surat_bebas_napza);
        }

        if($request->hasFile('surat_kesehatan_jiwa')){    
            $foto3 = $request->file('surat_kesehatan_jiwa');
            $foto_surat_kesehatan_jiwa = $foto3->getClientOriginalName();
            $foto3->move(public_path("source_skjiwaDriver/"), $foto_surat_kesehatan_jiwa);
        }

        if($request->hasFile('surat_kesehatan_jasmani')){    
            $foto4 = $request->file('surat_kesehatan_jasmani');
            $foto_surat_kesehatan_jasmani = $foto4->getClientOriginalName();
            $foto4->move(public_path("source_skjasmaniDriver/"), $foto_surat_kesehatan_jasmani);
        }

        if($request->hasFile('skck')){    
            $foto5 = $request->file('skck');
            $foto_skck = $foto5->getClientOriginalName();
            $foto5->move(public_path("source_skckDriver/"), $foto_skck);
        }

        if($request->hasFile('foto_driver')){    
            $foto6 = $request->file('foto_driver');
            $foto_driver = $foto6->getClientOriginalName();
            $foto6->move(public_path("source_fotoDriver/"), $foto_driver);
        }

        $driver = Driver::create([
            'id_driver' => $id_driver,
            'nama_driver' =>  $request->nama_driver,
            'alamat_driver' => $request->alamat_driver,
            'tanggal_lahir_driver' =>  $request->tanggal_lahir_driver,
            'jenis_kelamin_driver' =>  $request->jenis_kelamin_driver,
            'no_telp_driver' =>  $request->no_telp_driver,
            'email'=>  $request->email,

            'sim_driver' => $foto_sim_driver,
            'surat_bebas_napza' => $foto_surat_bebas_napza,
            'surat_kesehatan_jiwa' => $foto_surat_kesehatan_jiwa,
            'surat_kesehatan_jasmani' => $foto_surat_kesehatan_jasmani,
            'skck' => $foto_skck,
            'foto_driver' => $foto_driver,

            'bahasa_asing' => $request->bahasa_asing,
            'tarif_driver_perhari' => $tarifDriver ,
            'rerata_rating_driver' => $request->rerata_rating_driver,
            'status_ketersediaan_driver' => $request->status_ketersediaan_driver,
            'password' => bcrypt($request->tanggal_lahir_driver),
        ]);

            return response([
                'message'=>'Register Success',
                'data'=>$driver,
            ],200);
    }

    public function destroy($id_driver)
    {
        $driver = Driver::find($id_driver);

        if(is_null($driver)){
            return response([
                'message' => 'Driver Not Found',
                'data' => null
            ],404);
        }

        if($driver->delete()){
            return response([
                'message' => 'Delete Driver Success',
                'data' => $driver
            ],200);
        }

        return response([
            'message'=>'Delete Driver Success',
            'data'=> null
        ],400);
    }

    public function update(Request $request, $id_driver){
        $driver = Driver::find($id_driver);
        if(is_null($driver)){
            return response([
                'message'=>'Driver Not Found',
                'data'=>null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'nama_driver' => 'required',
            'alamat_driver' => 'required',
            'tanggal_lahir_driver' => 'required|date',
            'jenis_kelamin_driver' => 'required',
            'no_telp_driver' => 'required|numeric|digits_between:10,13|starts_with:08',
            'email'=> 'required|email:rfc,dns',

            'bahasa_asing' => 'required',
            'tarif_driver_perhari' => 'nullable' ,
            'rerata_rating_driver' => 'nullable',
            'status_ketersediaan_driver' => 'required',
     
        ]);

        if($validate->fails())
            return response(['message'=> $validate->errors()],400);

            if($request->bahasa_asing == 'Bahasa Indonesia'){
                $tarifDriver = 100000;
            }
            elseif($request->bahasa_asing == 'Bahasa Indonesia & Bahasa Inggris'){
                $tarifDriver = 200000;
            }

        $driver->nama_driver = $updateData['nama_driver'];
        $driver->alamat_driver = $updateData['alamat_driver'];
        $driver->tanggal_lahir_driver = $updateData['tanggal_lahir_driver'];
        $driver->jenis_kelamin_driver = $updateData['jenis_kelamin_driver'];
        $driver->no_telp_driver = $updateData['no_telp_driver'];
        $driver->email = $updateData['email'];
        $driver->bahasa_asing= $updateData['bahasa_asing'];
        $driver->tarif_driver_perhari = $tarifDriver;
        $driver->rerata_rating_driver = $updateData['rerata_rating_driver'];
        $driver->status_ketersediaan_driver = $updateData['status_ketersediaan_driver'];

        if(isset($request->password)){
            $updateData['password'] = bcrypt($request->password);
            $driver->password = $updateData['password'];
        }

        if($driver->save()){
            return response([
                'message' => 'Update Driver Success',
                'data'=> $driver
            ],200);
        }

        return response([
            'messsage'=>'Update Driver Failed',
            'data'=>null,
        ],400);
    }

    public function updateSIM(Request $request, $id_driver){
        $driver= Driver::find($id_driver);

        if(is_null($driver)){
            return response([
                'message' => 'Driver Not Found',
                'data' => $driver
            ],404);
        }

         // SIM
         if(!$request->hasFile('sim_driver')){
            return response([
                'message' => 'Update SIM Driver Failed',
                'data' => null
            ],400);
        }
        $file1 = $request->file('sim_driver');

        if(!$file1->isValid()){
            return response([
                'message' => 'Update SIM Driver Failed',
                'data' => null
            ],400);
        }

        $foto1 = public_path().'/source_simDriver/';
        $file1->move($foto1,$file1->getClientOriginalName());
        $foto_sim_driver = $file1->getClientOriginalName();
        $foto1 = '/source_simDriver'.$file1->getClientOriginalName();

        $updateData = $request->all();

        $driver->sim_driver = $foto_sim_driver;

        if($driver->save()){
            return response([
                'message' => 'Update Dokumen Success',
                'data' => $foto_sim_driver
            ],200);
        }

        return response([
            'message' => 'Update Dokumen Failed',
            'data' => null
        ],400);
    }

    public function updateSBN(Request $request, $id_driver){
        $driver= Driver::find($id_driver);

        if(is_null($driver)){
            return response([
                'message' => 'Driver Not Found',
                'data' => $driver
            ],404);
        }

        if(!$request->hasFile('surat_bebas_napza')){
            return response([
                'message' => 'Update Surat Bebas Napza Failed',
                'data' => null
            ],400);
        }

        $file2 = $request->file('surat_bebas_napza');

        if(!$file2->isValid()){
            return response([
                'message' => 'Update Surat Bebas Napza Failed',
                'data' => null
            ],400);
        }

        $foto2 = public_path().'/source_sbnDriver/';
        $file2->move($foto2,$file2->getClientOriginalName());
        $foto_surat_bebas_napza= $file2->getClientOriginalName();
        $foto2 = '/source_sbnDriver'.$file2->getClientOriginalName();

        $updateData = $request->all();

        $driver->surat_bebas_napza = $foto_surat_bebas_napza;

        if($driver->save()){
            return response([
                'message' => 'Update Dokumen Success',
                'data' => $foto_surat_bebas_napza
            ],200);
        }

        return response([
            'message' => 'Update Dokumen Failed',
            'data' => null
        ],400);

    }

    public function updateSK_JIWA(Request $request, $id_driver){
        $driver= Driver::find($id_driver);

        if(is_null($driver)){
            return response([
                'message' => 'Driver Not Found',
                'data' => $driver
            ],404);
        }

        if(!$request->hasFile('surat_kesehatan_jiwa')){
            return response([
                'message' => 'Update Surat Kesehatan Jiwa Failed',
                'data' => null
            ],400);
        }

        $file3 = $request->file('surat_kesehatan_jiwa');

        if(!$file3->isValid()){
            return response([
                'message' => 'Update Surat Kesehatan Jiwa Failed',
                'data' => null
            ],400);
        }

        $foto3 = public_path().'/source_skjiwaDriver/';
        $file3->move($foto3,$file3->getClientOriginalName());
        $foto_surat_kesehatan_jiwa= $file3->getClientOriginalName();
        $foto3 = '/source_skjiwaDriver'.$file3->getClientOriginalName();

        $updateData = $request->all();

        $driver->surat_kesehatan_jiwa = $foto_surat_kesehatan_jiwa;

        if($driver->save()){
            return response([
                'message' => 'Update Dokumen Success',
                'data' => $foto_surat_kesehatan_jiwa
            ],200);
        }

        return response([
            'message' => 'Update Dokumen Failed',
            'data' => null
        ],400);

    }

    public function updateSK_JASMANI(Request $request, $id_driver){
        $driver= Driver::find($id_driver);

        if(is_null($driver)){
            return response([
                'message' => 'Driver Not Found',
                'data' => $driver
            ],404);
        }

        if(!$request->hasFile('surat_kesehatan_jasmani')){
            return response([
                'message' => 'Update Surat Kesehatan Jasmani Failed',
                'data' => null
            ],400);
        }

        $file4 = $request->file('surat_kesehatan_jasmani');

        if(!$file4->isValid()){
            return response([
                'message' => 'Update Surat Kesehatan Jasmani Failed',
                'data' => null
            ],400);
        }

        $foto4 = public_path().'/source_skjasmaniDriver/';
        $file4->move($foto4,$file4->getClientOriginalName());
        $foto_surat_kesehatan_jasmani= $file4->getClientOriginalName();
        $foto4 = '/source_sbnDriver'.$file4->getClientOriginalName();

        $updateData = $request->all();

        $driver->surat_kesehatan_jasmani = $foto_surat_kesehatan_jasmani;

        if($driver->save()){
            return response([
                'message' => 'Update Dokumen Success',
                'data' => $foto_surat_kesehatan_jasmani
            ],200);
        }

        return response([
            'message' => 'Update Dokumen Failed',
            'data' => null
        ],400);

    }

    public function updateSKCK(Request $request, $id_driver){
        $driver= Driver::find($id_driver);

        if(is_null($driver)){
            return response([
                'message' => 'Driver Not Found',
                'data' => $driver
            ],404);
        }

        if(!$request->hasFile('skck')){
            return response([
                'message' => 'Update SKCK Failed',
                'data' => null
            ],400);
        }

        $file5 = $request->file('skck');

        if(!$file5->isValid()){
            return response([
                'message' => 'Update Surat Kesehatan Jasmani Failed',
                'data' => null
            ],400);
        }

        $foto5 = public_path().'/source_skckDriver/';
        $file5->move($foto5,$file5->getClientOriginalName());
        $foto_skck= $file5->getClientOriginalName();
        $foto5 = '/source_skckDriver'.$file5->getClientOriginalName();

        $updateData = $request->all();

        $driver->skck = $foto_skck;

        if($driver->save()){
            return response([
                'message' => 'Update Dokumen Success',
                'data' => $foto_skck
            ],200);
        }

        return response([
            'message' => 'Update Dokumen Failed',
            'data' => null
        ],400);

    }

    public function updateFotoDriver(Request $request, $id_driver){
        $driver= Driver::find($id_driver);

        if(is_null($driver)){
            return response([
                'message' => 'Driver Not Found',
                'data' => $driver
            ],404);
        }

        if(!$request->hasFile('foto_driver')){
            return response([
                'message' => 'Update Foto Driver Failed',
                'data' => null
            ],400);
        }

        $file6 = $request->file('foto_driver');

        if(!$file6->isValid()){
            return response([
                'message' => 'Update Foto Driver Failed',
                'data' => null
            ],400);
        }

        $foto6 = public_path().'/source_fotoDriver/';
        $file6->move($foto6,$file6->getClientOriginalName());
        $foto_driver= $file6->getClientOriginalName();
        $foto6 = '/source_sbnDriver'.$file6->getClientOriginalName();

        $updateData = $request->all();

        $driver->foto_driver = $foto_driver;

        if($driver->save()){
            return response([
                'message' => 'Update Dokumen Success',
                'data' => $foto_driver
            ],200);
        }

        return response([
            'message' => 'Update Dokumen Failed',
            'data' => null
        ],400);

    }

}
