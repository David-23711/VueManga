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
    public function volume(Request $req)
    {
        return $this->volumeInterface->addVolume($req);
    }
    public function indexVolume($id)
    {
        return $this->volumeInterface->getVolume($id);
    }
    public function destroy($vid,$mid)
    {
        return $this->volumeInterface->deleteVolume($vid,$mid);
    }
    public function getAll($id)
    {
        return $this->volumeInterface->getAllData($id);
    }
}
