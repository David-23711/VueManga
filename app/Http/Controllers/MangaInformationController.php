<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\interfaces\mangaInformationInterface;

class MangaInformationController extends Controller
{
    //
    protected mangaInformationInterface $mangaInterface;

    public function __construct(mangaInformationInterface $mangaInterface)
    {
       $this->mangaInterface = $mangaInterface;
    }

    public function insert(Request $req)
    {
        return $this->mangaInterface->addManga($req);
    }

    public function index()
    {
        return $this->mangaInterface->getManga();
    }
    public function update($id,Request $req)
    {
        return $this->mangaInterface->updateManga($id,$req);
    }
    public function delete($id,Request $req)
    {
    return $this->mangaInterface->deleteManga($id,$req);
    }
    public function admin($aid)
    {
        return $this->mangaInterface->getAdminData($aid);   
    }
    public function manga($aid,$id)
    {
       return $this->mangaInterface->getInfos($id);   
    }
    public function genre(Request $req)
    {
        return $this->mangaInterface->addGenre($req);
    }
    public function genrebyid($id)
    {
        return $this->mangaInterface->getGenreById($id);

    }
    public function deleteGenre($id)
    {
        return $this->mangaInterface->deletegetGenre($id);
    }
    public function releaseDate()
    {
        return $this->mangaInterface->getReleaseDates();
    }
    public function byrelease()
    {
        return $this->mangaInterface->getByRelease();
    }
   public function count()
   {
       return $this->mangaInterface->projectCount();
   }
   public function userIndex()
   {
       return $this->mangaInterface->getAllDataForUser();
   }
   public function getByGenre()
   {
       return $this->mangaInterface->getDataByGenre();
   }
}
