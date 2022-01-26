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
use App\Models\Episode;
use App\Models\MangaInformation;
use App\Models\MultiImage;
use App\Models\Volume;

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
Route::post('/admin/login/checkEmail',[AdminController::class,'check']);
Route::put('/admin/login/putPassword/{id}',[AdminController::class,'putPassword']);
Route::view('/admin/team','/manga/adminpanel');
Route::get('/admin/team/getAdmin',[AdminController::class,'index']);

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
Route::post('/admin/manga/setting/addvolume',[VolumeController::class,'volume']);
Route::get('/admin/manga/getVolume/{id}',[VolumeController::class,'indexVolume']);
Route::delete('/admin/manga/getVolume/{vid}/{mid}',[VolumeController::class,'destroy']);
Route::get('/admin/getalldata/{id}',[VolumeController::class,'getAll']);
//admin addEpisode
Route::view('/admin/manga/volume/episodes/{id}/{mid}','/manga/adminpanel');
Route::get('/admin/getVolume/{id}',[EpisodeController::class,'volume']);
Route::post('/admin/manga/setting/episode/save',[EpisodeController::class,'insert']);
Route::get('/admin/manga/setting/episode/save/{id}',[EpisodeController::class,'index']);
Route::put('/admin/manga/setting/episode/update/{id}',[EpisodeController::class,'update']);
Route::delete('/admin/manga/setting/episode/save/{id}/{mid}/{vid}',[EpisodeController::class,'destroy']);


//admin addimage
Route::view('/admin/manga/volume/episodes/insertImage/{eid}/{mid}/{vid}','/manga/adminpanel');
Route::post('/admin/manga/volume/episodes/insertImage',[MultiImageController::class,'insert']);
Route::view('admin/manga/volume/images/{id}/{vid}', '/manga/adminpanel');
Route::get('/admin/manga/volume/getEpisodeByVid/{vid}',[MultiImageController::class,'episodeByVid']);
Route::get('/admin/manga/volume/multiImages/{id}',[MultiImageController::class,'index']);
Route::view('/admin/manga/volume/images/{eid}/{vid}/mangaRoom','/manga/adminpanel');
Route::get('/admin/manga/volume/dynamicImages/{id}',[MultiImageController::class,'dynamicIndex']);

//user Comment
Route::get('/user/manga/comment',[CommentController::class,'index']);

//user Like
Route::get('/user/manga//like',[LikeController::class,'likeOrUnlike']);


