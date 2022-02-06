<?php

namespace App\Http\Controllers;

use App\interfaces\ratingInterface;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    //
    protected ratingInterface $ratingInterface;
    function __construct(ratingInterface $ratingInterface)
    {
        $this->ratingInterface=$ratingInterface;
    }
    public function rating(Request $req)
    {
        $this->ratingInterface->userRating($req);
    }
    public function getRating($id,$uid)
    {
        return $this->ratingInterface->getUserRating($id,$uid);
    }
    public function total($mid,$uid)
    {
        return $this->ratingInterface->getTotalRating($mid,$uid);
    }
    public function insertRating($id,Request $req)
    {
        return $this->ratingInterface->addRating($id,$req);
    }
    
}
