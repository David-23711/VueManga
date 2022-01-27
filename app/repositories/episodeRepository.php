<?php
namespace App\repositories;
use App\interfaces\episodeInterface;
use App\Models\Episode;
use App\Models\Volume;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class episodeRepository implements episodeInterface{
    public function getEpisode($id)
    {
        $start=0;
        if(request('search')=="null")
        {
           $data= Episode::where('volume_id',$id)->orderByRaw("LENGTH(episode_name)", 'ASC')->orderBy("episode_name",'ASC')->get();
        }else{
            $data = Episode::when(request('search'),function($query){
                $query->where('episode_name','like','%'.request('search').'%');
            })->orderByRaw("LENGTH(episode_name)", 'ASC')->orderBy("episode_name",'ASC')->where('volume_id',$id)->get();
           
        }
         return $data;
    }
    public function getoneVolume($id)
    {
        $data = Volume::where('id',$id)->get();
        return $data;
    }
    public function saveEpisode($episode)
    {
        $vid = $episode->volume_id;
        $mid = $episode->manga_information_id;
        if(!File::exists("manga/$mid/$vid"))
        {
            File::makeDirectory("manga/$mid/$vid");
        }
        $episode->validate([
            'episode_name'=>[Rule::unique('episodes')->where(function($query) use($vid,$mid){
                return $query->where('volume_id',$vid)
                ->where('manga_information_id',$mid);
            })]
        ]);
        $data = new Episode;
        $data->volume_id = $episode->volume_id;
        $data->manga_information_id = $episode->manga_information_id;
        $data->episode_name = $episode->episode_name;
        $data->save();
    }
    public function updateEpisode($id,$episode)
    {
        $data = Episode::find($id);
        $data->update([
            'episode_name'=>$episode['episode_name']
        ]);
    }
    public function deleteEpisode($id,$mid,$vid)
    {
        $data = Episode::find($id);
        $data->delete();
        File::deleteDirectory("manga/$mid/$vid/$id");
    }
}
?>