<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminCheck;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('app')->middleware([AdminCheck::class])->group(function (){
        //---tag routes---//
        Route::post('/create_tag',[TagController::class,'addTag']);
        Route::get('/get_tags',[TagController::class,'getTag']);
        Route::post('/edit_tag',[TagController::class,'editTag']);
        Route::post('/delete_tag',[TagController::class,'deleteTag']);
        //---category routes---//
        Route::post('/upload',[CategoryController::class,'upload']);
        Route::post('/delete_image',[CategoryController::class,'deleteImage']);
        Route::post('/create_category',[CategoryController::class,'addCategory']);
        Route::get('/get_category',[CategoryController::class,'getCategory']);
        Route::post('/edit_category',[CategoryController::class,'editCategory']);
        Route::post('/delete_category',[CategoryController::class,'deleteCategory']);
        //---Admin User routes---//
        Route::post('/create_user',[UserController::class,'createUser']);
        Route::get('/get_user',[UserController::class,'getUser']);
        Route::post('/edit_user',[UserController::class,'editUser']);
        //--Role Routes--//
        Route::post('/create_role',[RoleController::class,'createRole']);
        Route::get('/get_role',[RoleController::class,'getRole']);
        Route::post('/edit_role',[RoleController::class,'editRole']);
        Route::post('/assign_roles',[RoleController::class,'assignRole']);
        //--Login--//
        Route::post('/login',[AdminController::class,'login']);

        //--blog--//
         Route::post('/create-blog',[BlogController::class,'create']);
         Route::post('/createBlog',[BlogController::class,'createBlog']);
         Route::post('/blog',[BlogController::class,'blog']);
         Route::get('/blogData',[BlogController::class,'blogData']);
         Route::post('/delete_blog',[BlogController::class,'deleteBlog']);
         Route::get('/blog_single/{id}',[BlogController::class,'singleBlogItem']);
});

Route::get('/slug',[AdminController::class,'slug']);
Route::get('/blogData',[BlogController::class,'blogData']);

Route::get('/logout',[AdminController::class,'logout']);
Route::get('/',[AdminController::class,'index']);
Route::get('/{slug}',[AdminController::class,'index']);

//Route::get('/', function () {
//    return view('welcome');
//});
//Route::get('/new',[TestController::class,'TestMethod']);
//Route::any('{slug}',function (){
//    return view('welcome');
//});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
