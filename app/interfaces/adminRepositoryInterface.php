<?php
namespace App\interfaces;
 interface adminRepositoryInterface{
    public function insertAdminData($adminData);
    public function loginAccept($adminData);
    public function editAdminDataNotAvatar($id,$adminData);
    public function editAdminDataWithAvatar($id,$adminData);
    public function checkEmail($admin);
    public function getAllAdmin();
    public function updatePassword($id,$admin);
    // public function deleteAdminData($id);
}
?>