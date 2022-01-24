<?php

namespace App\Http\Controllers;

use App\Models\Role;
use http\Client\Curl\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //
    public function createRole(Request $request){
        $this->validate($request,[
            'roleName'=>'required',

        ]);
        return Role::create([
           'roleName'=>$request->roleName
        ]);
    }

    public function getRole(Request $request){
        return Role::all();
    }

    public function editRole(Request $request){
        $this->validate($request,[
            'roleName'=>'required',
        ]);

        $data =[
            'roleName'=>$request->roleName
        ];
        $user =Role::findorfail($request->id)->update($data);
    }

    public function assignRole(Request $request){
        $this->validate($request,[
            'permission'=>'required',
            'id'=>'required',
        ]);

        return Role::where('id',$request->id)->update([
             'permission'=> $request->permission
        ]);
    }
}
