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
    
}
