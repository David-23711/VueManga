<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\interfaces\volumeInterface;

class VolumeController extends Controller
{
    //
    protected volumeInterface $volumeInterface;
    public function __construct(volumeInterface $volumeInterface)
    {
        $this->volumeInterface = $volumeInterface;
    }

    public function index()
    {
        return $this->volumeInterface->getVolume();
    }
}
