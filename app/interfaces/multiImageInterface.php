<?php
namespace App\interfaces;

interface multiImageInterface{
    public function getMultiImages($id);
    public function uploadImages($images);
    public function getEpisodeByVid($id);
    public function getdynamicImages($id);
}

?>