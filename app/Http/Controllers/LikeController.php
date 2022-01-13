<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\interfaces\likeInterface;

class LikeController extends Controller
{
    //
    protected likeInterface $likeInterface;
    public function __construct(likeInterface $likeInterface)
    {
        $this->likeInterface = $likeInterface;
    }

    public function likeOrUnlike()
    {
        return $this->likeInterface->getLike();
    }

}
