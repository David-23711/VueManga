<?php
namespace App\repositories;

use App\interfaces\multiImageInterface;
use App\Models\Episode;
use App\Models\MultiImage;
use Illuminate\Support\Facades\File;

class multiImageRepository implements multiImageInterface
{
    public function getMultiImages($id)
    {
       $data = MultiImage::where('episode_id',$id)->orderBy('manga_image','asc')->pluck('manga_image','id')->toArray();
       return $data;
    }
    public function uploadImages($images)
    {   
            foreach($images->multi_images as $key=>$img)
            {
                $img_name=$img->getClientOriginalName();
                $img->storeAs("manga/$images->episode_id",$img_name);
                $data = new MultiImage;
                $data->episode_id = $images->episode_id;
                $data->manga_information_id = $images->manga_information_id;
                $data->volume_id=$images->volume_id;
                $data->manga_image = $img_name;
                $data->image_name = "ep.$key";
                $data->save();    
            }
    }
    public function getEpisodeByVid($id)
    {
        $data = Episode::where('volume_id',$id)->orderBy('episode_name','asc')->get();
        return $data;
    }
    public function getdynamicImages($id)
    {
        $data = MultiImage::where('episode_id',$id)->orderBy('manga_image','asc')->get();
        return $data;
    }
}
?>