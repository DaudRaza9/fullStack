<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function upload(Request $request){
        $this->validate($request,[
            'file'=>'required|mimes:jpeg,jpg,png'
        ]);

        $picName = time().'.'.$request->file->extension();
        $request->file->move(public_path('uploads'),$picName);

        return $picName;
    }

    public function deleteImage(Request $request){
        $fileName = $request->imageName;
        $this->deleteFileFromServer($fileName,false);
        return 'done!';
    }

    public function deleteFileFromServer($fileName,$hasFullPath=false){
        if(!$hasFullPath){
            $filePath = public_path('/uploads/'.$fileName);
        }
        if(file_exists($filePath)){
            @unlink($filePath);
        }
        return ;
    }

    public function addCategory(Request $request){
        $this->validate($request,[
            'iconImage'=>'required',
            'categoryName'=>'required',
        ]);

        return Category::create([
            'iconImage' => $request->iconImage,
            'categoryName' => $request->categoryName,
        ]);
    }

    public function getCategory(Request $request){
       return Category::orderBy('id','desc')->get();
    }

    public function editCategory(Request $request){
        $this->validate($request,[
            'iconImage'=>'required',
            'categoryName'=>'required',
        ]);

        return Category::where('id',$request->id)->update([
            'iconImage' => $request->iconImage,
            'categoryName' => $request->categoryName,
        ]);
    }

    public function deleteCategory(Request $request){
        //1st delete original file from server
        $this->deleteFileFromServer($request->iconImage);
        $this->validate($request,[
            'id'=>'required'
        ]);

        return Category::findorfail($request->id)->delete();
    }
}
