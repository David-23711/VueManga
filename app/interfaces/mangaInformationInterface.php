<?php
namespace App\interfaces;


interface mangaInformationInterface{
    public function addManga($mangaInfo);
    public function getManga();
    public function updateManga($id,$editData);
    public function getAdminData($aid);
    public function getInfos($id);
    public function deleteManga($id,$data);
    public function addGenre($data);
    public function getGenreById($id);
    public function deletegetGenre($id);
    public function getReleaseDates();
    public function getByRelease();
    public function projectCount();
    public function getAllDataForUser();
    public function getDataByGenre();
}

?>
