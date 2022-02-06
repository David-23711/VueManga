<?php
namespace App\interfaces;

interface bookmarkInterface{
    public function addBookmark($bookmark);
    public function getuserBookmark($mid,$uid);
    public function deleteBookmark($mid,$uid);
    public function getUserBookmarks($id);
    public function getAllUsesrBookmark($id);
}
?>