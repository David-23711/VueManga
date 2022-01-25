<?php
namespace App\repositories;

use App\interfaces\volumeInterface;
use App\Models\MangaInformation;
use App\Models\Volume;

class volumeRepository implements volumeInterface{
    public function addVolume($volume)
    {
        $data = new Volume();
        $data->volume = $volume->volume;
        $data->manga_information_id = $volume->mangaInfoId;
        $data->save();
    }
    public function getVolume($id)
    {
        $data = Volume::where('manga_information_id',$id)->get();
        return $data;
    }
    public function deleteVolume($id)
    {
        $data = Volume::find($id);
        $data->delete();
    }
    public function getAllData($id)
    {
       $data = MangaInformation::where('id',$id)->get();
       return $data;
       
    }
}

?>