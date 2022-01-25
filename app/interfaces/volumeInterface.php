<?php
namespace App\interfaces;

interface volumeInterface{
    public function addVolume($volume);
    public function getVolume($id);
    public function deleteVolume($id);
    public function getAllData($id);
}
?>