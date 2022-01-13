<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\interfaces\commentInterface;

class CommentController extends Controller
{
    //
    protected commentInterface $commentInterface;
    public function __construct(commentInterface $commentInterface)
    {
        $this->commentInterface = $commentInterface;
    }

    public function index()
    {
        return $this->commentInterface->getComment();
    }
}
