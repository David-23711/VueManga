<?php
namespace App\repositories;

use App\interfaces\volumeInterface;

class volumeRepository implements volumeInterface{
    public function getVolume()
    {
        dd('Working');
    }
}

?>