<?php
namespace App\repositories;
use App\interfaces\episodeInterface;

class episodeRepository implements episodeInterface{
    public function getEpisode()
    {
        dd('working');
    }
}
?>