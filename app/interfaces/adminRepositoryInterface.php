<?php
namespace App\interfaces;
 interface adminRepositoryInterface{
    public function insertAdminData($adminData);
    public function loginAccept($adminData);
    public function editAdminDataNotAvatar($id,$adminData);
    public function editAdminDataWithAvatar($id,$adminData);
    // public function readAdminData();
    // public function readAdminDataById($id);
    // public function updateAdminData($id,$adminData);
    // public function deleteAdminData($id);
}
?>