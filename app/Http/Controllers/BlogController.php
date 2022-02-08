<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Blogcategory;
use App\Models\Blogtag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    //
    public function createBlog(Request $request)
    {
        $this->validate($request, [
            'image' => 'required|mimes:jpeg,jpg,png'
        ]);

        $picName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('uploads'), $picName);
        return response()->json([
            'success' => 1,
            'file' => [
                'url' => "http://laravel-fullstack/uploads/$picName"
            ]
        ]);
//        return $picName;
    }

    public function create(Request $request)
    {
        $this->validate($request,[
           'title'=>'required',
            'post'=>'required',
            'post_excerpt'=>'required',
            'metaDescription'=>'required',
            'jsonData'=>'required',
            'category_id'=>'required',
            'tag_id'=>'required',
        ]);
        $category = $request->category_id;
        $tags = $request->tag_id;
        $blogCategories = [];
        $blogTags = [];

//        DB::beginTransaction();
//        try {
            $blog = Blog::create([
                'title' => $request->title,
                'slug' => $request->title,
                'post' => $request->post,
                'post_excerpt' => $request->post_excerpt,
                'user_id' => Auth::user()->id,
                'metaDescription' => $request->metaDescription,
                'jsonData' => $request->jsonData,
            ]);

            //insert blog categories
            foreach ($category as $c) {
                array_push($blogCategories, ['category_id' => $c, 'blog_id' => $blog->id]);
            }
            Blogcategory::insert($blogCategories);

            //insert tag categories
            foreach ($tags as $t) {
                array_push($blogTags, ['tag_id' => $t, 'blog_id' => $blog->id]);
            }
            Blogtag::insert($blogTags);
            DB::commit();
            return 'done';
//        } catch (\Throwable $e) {
//            DB::rollBack();
//            return 'not done';
//        }
    }

    public function blogData(Request $request){
        return Blog::with(['tag','cat'])->orderBy('id','desc')->get();
    }

    public function deleteBlog(Request $request){
        $blog = Blog::where('id',$request->id)->delete();
        $category = Blogcategory::where('blog_id',$request->id)->delete();
        $tag = Blogtag::where('blog_id',$request->id)->delete();

        return 'records are deleted successfully';
    }

    public function singleBlogItem(Request $request,$id){
        return Blog::with(['tag','cat'])->where('id',$id)->get();
    }


}
