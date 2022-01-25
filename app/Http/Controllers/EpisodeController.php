<?php

namespace App\Http\Controllers;

use App\interfaces\episodeInterface;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Node\FunctionNode;

class EpisodeController extends Controller
{
    //
    protected episodeInterface $episodeInterface;
    public function __construct(episodeInterface $episodeInterface)
    {
        $this->episodeInterface = $episodeInterface;
    }
    public function volume($id)
    {
      return $this->episodeInterface->getoneVolume($id);
    }
    public function insert(Request $req)
    {
        return $this->episodeInterface->saveEpisode($req);
    }
    public function index($id)
    {
        return $this->episodeInterface->getEpisode($id);
    }
    public function update($id,Request $req)
    {
        return $this->episodeInterface->updateEpisode($id,$req);
    }
    public function destroy($id)
    {
        return $this->episodeInterface->deleteEpisode($id);
    }

}
