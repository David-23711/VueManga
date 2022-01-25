<?php
namespace App\interfaces;

interface episodeInterface{
    public function getEpisode($id);
    public function getoneVolume($id); 
    public function saveEpisode($episode);
    public function updateEpisode($id,$episode);
    public function deleteEpisode($id);
}
?>