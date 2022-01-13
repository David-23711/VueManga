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

    public function insert()
    {
        return $this->mangaInterface->addManga();
    }
}
