<?php

namespace App\Http\Controllers;

use App\interfaces\multiImageInterface;
use Illuminate\Http\Request;

class MultiImageController extends Controller
{
    //
    protected multiImageInterface $imageInterface;
    public function __construct(multiImageInterface $imageInterface)
    {
        $this->imageInterface = $imageInterface;
    }
    public function index()
    {
        return $this->imageInterface->getImage();
    }
}
