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
    public function index($id)
    {
        return $this->imageInterface->getMultiImages($id);
    }
    public function insert(Request $req)
    {
        return $this->imageInterface->uploadImages($req);
    }
    public function episodeByVid($id)
    {
        return $this->imageInterface->getEpisodeByVid($id);
    }
    public function dynamicIndex($id)
    {
        return $this->imageInterface->getdynamicImages($id);
    }
}
