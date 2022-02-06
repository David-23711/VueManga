<?php
namespace App\repositories;

use App\interfaces\bookmarkInterface;
use App\Models\bookmark;
use Illuminate\Support\Facades\DB;

class bookmarkRepository implements bookmarkInterface{
    public function addBookmark($bookmark)
    {
        $data=new bookmark;
        $data->user_id=$bookmark->user_id;
        $data->manga_information_id=$bookmark->manga_information_id;
        $data->save();
    }
    public function getuserBookmark($mid, $uid)
    {
        $data=bookmark::where("manga_information_id",$mid)->where("user_id",$uid)->count();
        return $data;
    }
    public function deleteBookmark($mid,$uid)
    {
        $data=bookmark::where("manga_information_id",$mid)->where("user_id",$uid);
        $data->delete();
    }
    public function getUserBookmarks($id)
    {
        $data=bookmark::where("user_id",$id)->count();
        return $data;
    }
    public function getAllUsesrBookmark($id)
    {
        $data=DB::table("bookmarks")
        ->join("manga_information","bookmarks.manga_information_id","manga_information.id")
        ->where("bookmarks.user_id",$id)
        ->select("manga_information.*","bookmarks.created_at as bcreated")
        ->orderBy("bcreated","desc")->get();
        return $data; 
    }
}

?>