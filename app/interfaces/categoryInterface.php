<?php
namespace App\interfaces;

    interface categoryInterface{
    public function postCategory($category);
    public function getCategory();
    public function updateCategory($id,$category);
    public function deleteCategory($id);
    public function categoryCount();
}
?>