<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    //
    public function addTag(Request $request){
        //validation
        $this->validate($request,[
            'tagName'=>'required'
        ]);

        return Tag::create([
            'tagName' => $request->tagName
        ]);
    }

    public function editTag(Request $request){
        //validation

        $this->validate($request,[
            'tagName'=>'required'
        ]);

        Tag::where('id',$request->id)->update([
            'tagName'=>$request->tagName
        ]);

        return response()->json([
            'tagName'=>$request->tagName
        ]);
    }

    public function getTag(){
        return Tag::orderBy('id','desc')->get();
    }

    public function deleteTag(Request $request){
        $this->validate($request,[
            'id'=>'required'
        ]);

        return Tag::find($request->id)->delete();
    }

}
