<?php
namespace App\repositories;

use App\Http\Controllers\MangaInformationController;
use App\interfaces\mangaInformationInterface;
use App\Models\admin;
use App\Models\Genre;
use App\Models\MangaInformation;
use App\Models\Volume;
use Illuminate\Support\Facades\File;
use SebastianBergmann\Type\ObjectType;

class mangaInformationRepository implements mangaInformationInterface{
    public function addManga($mangaInfo)
    {
        $file = $mangaInfo->visual_key;
        $ext = $file->getClientOriginalExtension();
        $photo = time().'.'.$ext;
        $path = $file->move('manga/',$photo);
        $data = new MangaInformation;
        $data->manga_name= $mangaInfo->manga_name;
        $data->alternative_name = $mangaInfo->alternative_name;
        $data->author = $mangaInfo->author;
        $data->admin_id = $mangaInfo->admin_id;
        $data->visual_key = $photo;
        $data->release_date = $mangaInfo->release_date;
        $data->status = $mangaInfo->status;
        $data->description = $mangaInfo->description;
        $data->save();
    }
    public function getManga()
    {
       if(request('search') == "null")
       {
           $data = MangaInformation::orderBy('created_at','desc')->paginate(6);
       }else 
       {
        $data = MangaInformation::when(request('search'),function($query){
            $query->where('manga_name','like','%'.request('search').'%')
            ->orWhere('alternative_name','like','%'.request('search').'%');
        })->orderBy('created_at','desc')->paginate(6);
       }
    //    if(request('genre')!='null')
    //    {
        //    }
        // $data=Genre::where('genre',request('genre'))->pluck('manga_information_id')->toArray();
        // $count=count($data);
        // $manga=array();
        // for($i=0;$i<$count;$i++)
        // {
        //     $manga[]=MangaInformation::where('id',$data[$i])->paginate(6);
        // }
        return $data;
    }
    public function updateManga($id,$editData)
    {
        $data = MangaInformation::find($id);
        $current = $editData->current_key;
        global $photo;
           
             if($editData->visual_key != null)
            {
                $file = $editData->visual_key;
                $ext = $file->getClientOriginalExtension();
                $photo = time().'.'.$ext;
                $file->move('manga/',$photo);
                 File::delete("manga/$current");
               
            }else {
                $photo = $current;
                
            }
            $data->update([
                'manga_name'=>$editData['manga_name'],
                'alternative_name'=>$editData['alternative_name'],
                'author'=>$editData['author'],
                'release_date' => $editData['release_date'],
                'status' => $editData['status'],
                'visual_key'=>$photo,
                'description' => $editData['description'],
            ]);
            return $data;
            
        }
        
        public function deleteManga($id,$data)
        {
            
            $current = $data->current_key;
           
                $delete = MangaInformation::find($id);
                $delete->delete();
                File::delete("manga/$current");
                File::deleteDirectory("manga/$id");
            
        }
        public function getAdminData($aid)
        {
            $data = admin::where("id",$aid)->pluck('admin')->toArray();
            return $data;
        }

        public function getInfos($id)
        {
          $data = MangaInformation::where('id',$id)->get();
          return $data;
        }
        public function addGenre($data)
        {
           $genres = $data->genre;
           $mangaInfoId= $data->mangaInfoId;
           foreach($genres as $genre)
           {
              $add = new Genre;
              $add->manga_information_id = $mangaInfoId;
              $add->genre = $genre;
              $add->save();
           }
        }
        public function getGenreById($id)
        {
            $data = Genre::where('manga_information_id',$id)->orderBy('genre','asc')->get();
            return $data;
        }
        public function deletegetGenre($id)
        {
            $data = Genre::find($id);
            $data->delete();   
        }
        public function getReleaseDates()
        {
            $data = MangaInformation::pluck('release_date')->toArray();
            return $data;
        }
        public function getByRelease()
        {
            if(request('release')=='Latest')
            {
                $data = MangaInformation::orderBy("created_at","desc")->paginate(6);
            }else if(request('release') == 'Desc')
            {
                $data = MangaInformation::orderBy('manga_name','desc')->paginate(6);
            }else if(request('release')== 'Asc')
            {
                $data = MangaInformation::orderBy('manga_name','asc')->paginate(6);
            }else {
                $data = MangaInformation::when(request('release'),function($query){
                    $query -> where('release_date','like','%'.request('release').'%');
                })->orderBy('created_at')->paginate(6);
            }
             return $data;
        }
        public function projectCount()
        {
            $data=MangaInformation::all()->count();
            return $data;
        }
        public function getAllDataForUser()
        {
            $data = MangaInformation::with('volumes','episodes')->get();
            return $data;
        }
        public function getDataByGenre() 
        {
            $data=Genre::where('genre',request('genre'))->pluck('manga_information_id')->toArray();
            $count=count($data);
            $manga=array();
            for($i=0;$i<$count;$i++)
            {
                $manga[]=MangaInformation::where('id',$data[$i])->get();
            }
            return $manga;
        }
        public function getForDashboard()
        {
            $data=MangaInformation::orderBy("created_at","desc")->get();
            return $data;
        }
        public function getHotMangaAll()
        {
            $data=MangaInformation::orderBy("rating","desc")->paginate(6);
            return $data;
        }
        public function getNewestMangaAll()
        {
            $data=MangaInformation::orderByRaw("LENGTH(release_date) desc")->orderBy("release_date","desc")->paginate(6);
            return $data;
        }
}
