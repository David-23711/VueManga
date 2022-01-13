<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MangaInformationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MultiImageController;
use App\Http\Controllers\VolumeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::view('/','/manga/adminpanel');
Route::view('/admin/home','/manga/adminpanel');
Route::view('/admin/login','/manga/adminpanel');
Route::view('/admin/register','/manga/adminpanel');
Route::match(['get','post'],'/admin/register/addAdmin',[AdminController::class,'insert']);
Route::match(['get','post'],'/admin/login/accept',[AdminController::class,'getLoginData']);
Route::put('/admin/editdata/notavatar/{id}',[AdminController::class,'editAdminNotAvatar']);
Route::put('/admin/editdata/withavatar/{id}',[AdminController::class,'editAdminWithAvatar']);

//admin addCategory
Route::get('/admin/category/manga',[CategoryController::class,'index']);

//admin addManga
Route::get('/admin/posts/manga',[MangaInformationController::class,'insert']);

//admin addVolume
Route::get('/admin/posts/manga/volume',[VolumeController::class,'index']);

//admin addEpisode
Route::get('/admin/posts/manga/volume/episode',[EpisodeController::class,'index']);

//admin addimage
Route::get('/admin/posts/manga/volume/episode/image',[MultiImageController::class,'index']);

//user Comment
Route::get('/user/manga/comment',[CommentController::class,'index']);

//user Like
Route::get('/user/manga//like',[LikeController::class,'likeOrUnlike']);


