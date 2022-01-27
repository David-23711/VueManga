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
       return response()->json(['data'=>$data,'id'=>$id]);
    }
    public function uploadImages($images)
    {    
        if(!File::exists("manga/$images->manga_information_id/$images->volume_id/$images->episode_id"))
               {
                File::makeDirectory("manga/$images->manga_information_id/$images->volume_id/$images->episode_id");
               }
            foreach($images->multi_images as $key=>$img)
            {
              
               $img_name=$img->getClientOriginalName();
               $data=$img->move("manga/$images->manga_information_id/$images->volume_id/$images->episode_id",$img_name);
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
        $data = Episode::where('volume_id',$id)->orderByRaw("LENGTH(episode_name)", 'ASC')->orderBy("episode_name",'ASC')->get();
        return $data;
    }
    public function getdynamicImages($id)
    {
        $data = MultiImage::where('episode_id',$id)->orderByRaw("LENGTH(manga_image)", 'ASC')->orderBy("manga_image",'ASC')->pluck('manga_image','id')->toArray();
        return $data;
    }
}
?>