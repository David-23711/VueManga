<?php
namespace App\repositories;

use App\interfaces\ratingInterface as InterfacesRatingInterface;
use App\Models\MangaInformation;
use App\Models\Rating;

class ratingRepository implements InterfacesRatingInterface
{
  public function userRating($rating)
  {
      $data=new Rating;
      $data->user_id=$rating->user_id;
      $data->manga_information_id=$rating->manga_information_id;
      $data->rating=$rating->rating;
      $data->save();
  }
  public function getUserRating($id,$uid)
  {
      $data=Rating::where("manga_information_id",$id)->where("user_id",$uid)->get();
      return $data;
  }
  public function getTotalRating($mid, $uid)
  {
    $data=Rating::where("manga_information_id",$mid)->get();
    return $data;
  }
  public function addRating($id,$rating)
  {
    $data=MangaInformation::find($id);
    $data->rating=$rating->rating;
    $data->users=$rating->users;
    $data->save();
  }
}
?>