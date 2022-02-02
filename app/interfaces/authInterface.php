<?php
namespace App\interfaces;

interface authInterface{
    public function userRegister($user);
    public function userLogin($user);
}

?>