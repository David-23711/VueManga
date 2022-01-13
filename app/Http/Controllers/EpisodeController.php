<?php

namespace App\Http\Controllers;

use App\interfaces\episodeInterface;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    //
    protected episodeInterface $episodeInterface;
    public function __construct(episodeInterface $episodeInterface)
    {
        $this->episodeInterface = $episodeInterface;
    }

    public function index()
    {
        return $this->episodeInterface->getEpisode();
    }

}
