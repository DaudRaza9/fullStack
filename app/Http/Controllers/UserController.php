<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function createUser(Request $request){
        //--validate User--//

        $this->validate($request,[
            'fullName'=>'required',
            'email'=>'bail|required|email|unique:users',
            'password'=>'bail|required|min:6',
            'role_id'=>'required',
        ]);
          $password = bcrypt($request->password);

        $user= User::create([
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => $password,
            'role_id' => $request->role_id,
        ]);
        return $user;
    }
    public function getUser(){
        $user = User::all();
        return $user;
    }
    public function editUser(Request $request){
        $this->validate($request,[
            'fullName'=>'required',
            'email'=>"required|email|unique:users,email, $request->id",
            'password'=>'min:6',
            'role_id'=>'required',
        ]);
        $data =[
            'fullName' => $request->fullName,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ];

        if($request->password){
            $password = bcrypt($request->password);
            $data['password']=$password;
        }

        $user= User::where('id',$request->id)->update($data);
        return $user;
    }


}
