<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        //first check logged in and admin user

        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }
        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }
        //check if user is a admin user
        $user = Auth::user();
        if ($user->userType == 'User') {
            return redirect('/login');
        }
        if ($request->path() == 'login') {
            return redirect('/');
        }
        return $this->checkForPermission($user, $request);
    }

    public function checkForPermission($user, $request)
    {
        $permission = json_decode($user->role->permission);
        $hasPermission = false;
        if(!$permission){
            return view('welcome');
        }
        foreach ($permission as $p) {
            if ($p->name == $request->path()) {
                if ($p->read) {
                    $hasPermission = true;
                }
            }
        }
        if ($hasPermission) {
            return view('welcome');
        }else{
            return view('notFound');
        }
    }

    public function login(Request $request)
    {
        $this->validate($request, ['email' => 'bail|required|email', 'password' => 'bail|required|min:6',]);
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            if ($user->role->isAdmin == 0) {
                Auth::logout();
                return response()->json(['msg' => 'Incorrect login details'], 401);
            }
            return response()->json(['msg' => 'you are logged in', 'user' => $user]);
        } else {
            return response()->json(['msg' => 'Incorrect Login details'], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }

}
