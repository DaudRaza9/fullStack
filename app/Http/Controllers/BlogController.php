<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    //
    public function createBlog(Request $request){
        $this->validate($request,[
            'image'=>'required|mimes:jpeg,jpg,png'
        ]);

        $picName = time().'.'.$request->image->extension();
        $request->image->move(public_path('uploads'),$picName);
        return response()->json([
           'success'=>1,
            'file'=>[
                'url'=>"http://laravel-fullstack/uploads/$picName"
            ]
        ]);
        return $picName;
    }
}
