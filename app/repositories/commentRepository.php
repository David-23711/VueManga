<?php
namespace App\repositories;
use App\interfaces\commentInterface;

class commentRepository implements commentInterface{
    public function getComment()
    {
        dd('working');
    }
}

?>