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
    public function login(Request $req)
    {
       return $this->authInterface->userLogin($req);
    }
    public function updateUser($id,Request $req)
    {
        return $this->authInterface->userUpdate($id,$req);
    }
    public function check(Request $req)
    {
        return $this->authInterface->checkEmail($req);
    }
    public function putPassword($id,Request $req)
    {
        return $this->authInterface->updatePassword($id,$req);
    }
}
