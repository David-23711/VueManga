<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\bookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MangaInformationController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MultiImageController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\VolumeController;
use App\Models\Episode;
use App\Models\MangaInformation;
use App\Models\MultiImage;
use App\Models\Volume;
use Illuminate\Support\Facades\Auth;

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
Route::get('/admin/home/dashboard/categorycount',[CategoryController::class,'count']); 

//admin addManga
Route::view('/admin/manga','/manga/adminpanel');
Route::post('/admin/manga/post',[MangaInformationController::class,'insert']);
Route::get('/admin/manga/post',[MangaInformationController::class,'index']);
Route::put('/admin/manga/post/{id}',[MangaInformationController::class,'update']);
Route::delete('/admin/manga/post/{id}',[MangaInformationController::class,'delete']);
Route::view('/admin/manga/setting/{id}/admin/{aid}','/manga/adminpanel');
Route::get('/admin/manga/setting/{aid}',[MangaInformationController::class,'admin']);
Route::get('/admin/manga/setting/data/{id}',[MangaInformationController::class,'manga']);
Route::post('/admin/manga/setting/addgenre',[MangaInformationController::class,'genre']);
Route::get('/admin/manga/getGenre/{id}',[MangaInformationController::class,'genrebyid']);
Route::delete('/admin/manga/getGenre/delete/{id}',[MangaInformationController::class,'deleteGenre']);
Route::get('/admin/manga/post/releaseDate',[MangaInformationController::class,'releaseDate']);
Route::get('/admin/manga/post/byrelease',[MangaInformationController::class,'byrelease']);
Route::get('/admin/home/dashboard/projectcount',[MangaInformationController::class,'count']);

//admin addVolume
Route::get('/admin/posts/manga/volume',[VolumeController::class,'index']);
Route::post('/admin/manga/setting/addvolume',[VolumeController::class,'volume']);
Route::get('/admin/manga/getVolume/{id}',[VolumeController::class,'indexVolume']);
Route::delete('/admin/manga/getVolume/{vid}/{mid}',[VolumeController::class,'destroy']);
Route::get('/admin/getalldata/{id}',[VolumeController::class,'getAll']);
//admin addEpisode
Route::view('/admin/manga/volume/episodes/{id}/{mid}/{aid}','/manga/adminpanel');
Route::get('/admin/getVolume/{id}',[EpisodeController::class,'volume']);
Route::post('/admin/manga/setting/episode/save',[EpisodeController::class,'insert']);
Route::get('/admin/manga/setting/episode/save/{id}',[EpisodeController::class,'index']);
Route::put('/admin/manga/setting/episode/update/{id}',[EpisodeController::class,'update']);
Route::delete('/admin/manga/setting/episode/save/{id}/{mid}/{vid}',[EpisodeController::class,'destroy']);


//admin addimage
Route::view('/admin/manga/volume/episodes/insertImage/{eid}/{mid}/{vid}','/manga/adminpanel');
Route::post('/admin/manga/volume/episodes/insertImage',[MultiImageController::class,'insert']);
Route::view('admin/manga/volume/images/{id}/{mid}/{vid}/{aid}', '/manga/adminpanel');
Route::get('/admin/manga/volume/getEpisodeByVid/{vid}',[MultiImageController::class,'episodeByVid']);
Route::get('/admin/manga/volume/multiImages/{id}',[MultiImageController::class,'index']);
Route::view('/admin/manga/volume/images/{eid}/{mid}/{vid}/{aid}/mangaRoom','/manga/adminpanel');
Route::get('/admin/manga/volume/dynamicImages/{id}',[MultiImageController::class,'dynamicIndex']);

//user Comment
Route::get('/user/manga/comment',[CommentController::class,'index']);

//user Like
Route::get('/user/manga//like',[LikeController::class,'likeOrUnlike']);

//user view
// Route::view('/user','/manga/userpanel');
Route::view('/user','/manga/userpanel');
Route::view('/user/{category}','/manga/userpanel');
Route::view('/user/data/{date}','/manga/userpanel');
Route::view('/user/data/{date}/{current}/{total}','/manga/userpanel');
Route::view('/user/{category}/{current}/{total}','/manga/userpanel');
Route::get('/user/allDatas',[MangaInformationController::class,'userIndex']);
Route::get('/admin/category/byGenre',[MangaInformationController::class,'getByGenre']);
Route::view('/index/viewinfo/{mid}','/manga/userpanel');
Route::get("/admin/manga/dashboard",[MangaInformationController::class,'dashboard']);
Route::view("/user/readmanga/{mid}/{vid}/{eid}/{number}",'/manga/userpanel');
Route::post("/user/viewinfo/{id}/rating",[RatingController::class,'rating']);
Route::get("/getUserRating/{id}/{uid}",[RatingController::class,'getRating']);
Route::post("/user/viewinfo/{id}/totalRating",[RatingController::class,'insertRating']);
//user Register
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::view("/index/login",'/manga/userpanel');
Route::view("/index/register",'/manga/userpanel');
Route::view("/pagination/{current}/{total}",'/manga/userpanel');
Route::post("/user/index/register",[AuthController::class,"register"]);
Route::post("/index/login/singIn",[AuthController::class,"login"]);


Route::view("/portfolio",'portfolio');
//user Bookmark
Route::post("/user/viewinfo/{id}/bookmark",[bookmarkController::class,'bookmark']);
Route::get("/user/viewinfo/{mid}/{uid}/getBookmark",[bookmarkController::class,'getBookmark']);
Route::delete("/user/viewinfo/{mid}/{uid}/deleteBookmark",[bookmarkController::class,'delete']);
//
Route::get("/user/viewinfo/{mid}/{uid}/getRatingTotal",[RatingController::class,'total']);
Route::get("/user/getBookmark/{id}",[bookmarkController::class,"getUserBookmark"]);
Route::view("/bookmarks/{id}",'/manga/userpanel');
Route::get("/bookmarks/{id}/getUserBookmark",[bookmarkController::class,"getAllBookmarks"]);
Route::put("/update/user/{id}",[AuthController::class,"updateUser"]);
Route::view("/user/readmanga/slideView/{eid}/{mid}/{vid}/{number}",'/manga/userpanel');

//hotmanga
Route::view("/hotmanga",'/manga/userpanel');
Route::get("/hotmanga/getHotManga",[MangaInformationController::class,"getHotManga"]);
Route::view("/hotmanga/pagination/{current}/{total}",'/manga/userpanel');

Route::view("/newest",'/manga/userpanel');
Route::get("/newest/getNewestManga",[MangaInformationController::class,"getNewestManga"]);
Route::view("/newest/pagination/{current}/{total}",'/manga/userpanel');
