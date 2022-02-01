<?php

namespace App\Http\Controllers;

use App\interfaces\authInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    protected authInterface $authInterface;
    function __construct(authInterface $authInterface)
    {
       $this->authInterface=$authInterface;
    }
    public function register(Request $req){
        return $this->authInterface->userRegister($req);
    }
}
