<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function TestMethod(){
        return response()->json('We should return only Json data..!!');
    }

    public function test(){
        return  response()->json([
            'msg'=>'some error message'
        ],422);
    }
}
