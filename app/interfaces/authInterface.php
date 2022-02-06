<?php
namespace App\interfaces;

interface authInterface{
    public function userRegister($user);
    public function userLogin($user);
    public function userUpdate($id,$user);
    public function checkEmail($user);
    public function updatePassword($id,$user);
}

?>