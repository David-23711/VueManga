<?php
namespace App\repositories;

use App\interfaces\volumeInterface;
use App\Models\MangaInformation;
use App\Models\Volume;
use Illuminate\Support\Facades\File;

class volumeRepository implements volumeInterface{
    public function addVolume($volume)
    {
       if(!File::exists("manga/$volume->mangaInfoId"))
       {
           File::makeDirectory("manga/$volume->mangaInfoId");
       }
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
    public function deleteVolume($vid,$mid)
    {
        File::deleteDirectory("manga/$mid/$vid");
        $data = Volume::find($vid);
        $data->delete();
    }
    public function getAllData($id)
    {
       $data = MangaInformation::where('id',$id)->get();
       return $data;
       
    }
}

?>