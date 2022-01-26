<?php

namespace App\Http\Controllers;

use App\Models\admin;
use App\Http\Requests\StoreadminRequest;
use App\Http\Requests\UpdateadminRequest;
use App\interfaces\adminRepositoryInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected adminRepositoryInterface $adminInterface;
    public function __construct(adminRepositoryInterface $adminInterface)
    {
        $this->adminInterface = $adminInterface;
    }
    
    function insert(Request $req)
    {
        return $this->adminInterface->insertAdminData($req);
    }

    function getLoginData(Request $req)
    {
        return $this->adminInterface->loginAccept($req);
    }
    function editAdminNotAvatar($id,Request $req)
    {
        return $this->adminInterface->editAdminDataNotAvatar($id,$req);
    }
    function editAdminWithAvatar($id,Request $req)
    {
        return $this->adminInterface->editAdminDataWithAvatar($id,$req);
    }
    function check(Request $req)
    {
        return $this->adminInterface->checkEmail($req);
    }
    function putPassword($id,Request $req)
    {
        return $this->adminInterface->updatePassword($id,$req);
    }
    function index()
    {
        return $this->adminInterface->getAllAdmin();
    }
}
