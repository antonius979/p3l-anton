<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index()
    {
        $role = Role::all();

        if(count($role) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $role
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    public function show($id_role)
    {
        $role = Role::find($id_role);

        if(!is_null($role)){
            return response([
                'message' => 'Retrieve Role Success',
                'data' => $role
            ], 200);
        }

        return response([
            'message' => 'Role Not Found',
            'data' => null
        ]);
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_role' => 'required',
        ]);

        if($validate->fails())
            return response(['message'=>$validate->errors()],400); 
        
        $role = Role::create($storeData);
        return response([
            'message'=>'Add Role Success',
            'data'=>$role
        ],200);
    }

    public function destroy($id_role)
    {
        $role = Role::find($id_role);

        if(is_null($role)){
            return response([
                'message' => 'Role Not Found',
                'data' => null
            ],404);
        }

        if($role->delete()){
            return response([
                'message' => 'Delete Role Success',
                'data' => $role
            ],200);
        }

        return response([
            'message'=>'Delete Promo Success',
            'data'=> null
        ],400);
    }

    public function update(Request $request, $id_role)
    {
        $role = Role::find($id_role);
        if(is_null($role)) {
            return response([
                'message' => 'Role Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'nama_role' => 'required',
            
        ]);

        if($validate->fails())
        return response(['message'=>$validate->errors()],400); 

        $role->nama_role = $updateData['nama_role'];
       
        if($role->save()) {
            return response([
                'message' => 'Update Role Success',
                'data' => $role
            ],200);
        }

        return response([
            'message' => 'Update Role Failed',
            'data' => null
        ],400);



    }
}
