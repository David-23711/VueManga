<?php
namespace App\repositories;

use App\interfaces\multiImageInterface;

class multiImageRepository implements multiImageInterface
{
    public function getImage()
    {
        dd('working');
    }
}
?>