<?php
namespace App\interfaces;

interface ratingInterface{
 public function userRating($rating);
 public function getUserRating($id,$uid);
 public function getTotalRating($mid,$uid);
 public function addRating($id,$rating);
}
?>