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
use App\Models\MangaInformation;

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
Route::view('/admin/category','/manga/adminpanel');
Route::post('/admin/category/post',[CategoryController::class,'insert']);
Route::get('/admin/category/post',[CategoryController::class,'index']);
Route::put('/admin/category/post/{id}',[CategoryController::class,'update']);
Route::delete('/admin/category/post/{id}',[CategoryController::class,'destroy']);

//admin addManga
Route::view('/admin/manga','/manga/adminpanel');
Route::post('/admin/manga/post',[MangaInformationController::class,'insert']);
Route::get('/admin/manga/post',[MangaInformationController::class,'index']);
Route::put('/admin/manga/post/{id}',[MangaInformationController::class,'update']);
Route::delete('/admin/manga/post/{id}',[MangaInformationController::class,'delete']);
Route::view('/admin/manga/setting/{id}/admin/{aid}','/manga/adminpanel');
Route::get('/admin/manga/setting/{aid}',[MangaInformationController::class,'admin']);
Route::get('/admin/manga/setting/{aid}/{id}',[MangaInformationController::class,'manga']);
Route::post('/admin/manga/setting/addgenre',[MangaInformationController::class,'genre']);
Route::get('/admin/manga/getGenre/{id}',[MangaInformationController::class,'genrebyid']);
Route::delete('/admin/manga/getGenre/delete/{id}',[MangaInformationController::class,'deleteGenre']);
Route::get('/admin/manga/post/releaseDate',[MangaInformationController::class,'releaseDate']);
Route::get('/admin/manga/post/byrelease',[MangaInformationController::class,'byrelease']);

//admin addVolume
Route::get('/admin/posts/manga/volume',[VolumeController::class,'index']);
Route::post('/admin/manga/setting/addvolume',[MangaInformationController::class,'volume']);
Route::get('/admin/manga/getVolume/{id}',[MangaInformationController::class,'indexVolume']);

//admin addEpisode
Route::get('/admin/posts/manga/volume/episode',[EpisodeController::class,'index']);

//admin addimage
Route::get('/admin/posts/manga/volume/episode/image',[MultiImageController::class,'index']);

//user Comment
Route::get('/user/manga/comment',[CommentController::class,'index']);

//user Like
Route::get('/user/manga//like',[LikeController::class,'likeOrUnlike']);


