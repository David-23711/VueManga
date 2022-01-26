<?php
namespace App\interfaces;

interface volumeInterface{
    public function addVolume($volume);
    public function getVolume($id);
    public function deleteVolume($vid,$mid);
    public function getAllData($id);
}
?>