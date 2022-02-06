<?php

namespace App\Http\Controllers;

use App\interfaces\bookmarkInterface;
use Illuminate\Http\Request;

class bookmarkController extends Controller
{
    //
    protected bookmarkInterface $bookmarkInterface;
    public function __construct(bookmarkInterface $bookmarkInterface)
    {
        $this->bookmarkInterface=$bookmarkInterface;
    }
    public function bookmark(Request $req)
    {
        return $this->bookmarkInterface->addBookmark($req);
    }
    public function getBookmark($mid,$uid)
    {
        return $this->bookmarkInterface->getuserBookmark($mid,$uid);
    }
    public function delete($mid,$uid)
    {
        return $this->bookmarkInterface->deleteBookmark($mid,$uid);
    }
    public function getUserBookmark($id)
    {
        return $this->bookmarkInterface->getUserBookmarks($id);
    }
    public function getAllBookmarks($id)
    {
        return $this->bookmarkInterface->getAllUsesrBookmark($id);
    }
}
