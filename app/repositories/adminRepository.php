<?php
 namespace App\Repositories;
 use App\interfaces\adminRepositoryInterface;
 use App\Models\admin;
 use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\File; 

 class adminRepository implements adminRepositoryInterface{
     function insertAdminData($adminData)
     {
         if($adminData){
             $file = $adminData->avatar;
       $ext = $file->getClientOriginalExtension();
       $img = time().'.'.$ext;
       $path = $file->move('manga/',$img);
       $data= new admin;
       $data->admin= $adminData->name;
       $data->email = $adminData->email;
       $data->avatar = $img;
       $data->password = bcrypt($adminData->password);
       $data->phone= $adminData->phone;
       $data->address = $adminData->address;
       $data->save();
  
         }
       
     }
     function loginAccept($adminData)
     {
       $admin = admin::where(['email'=>$adminData->email])->first();
       if(!$admin || !Hash::check($adminData->password, $admin->password))
       {
           return dd('Not Match');
       }else {
           return $admin;
       }
     }
    function editAdminDataNotAvatar($id,$adminData)
    {
        $data = admin::find($id);
        $data->admin = $adminData->editName;
        $data->save();
        return $data;
        //    dd('Edited Name');
    }
    function editAdminDataWithAvatar($id,$adminData)
    {
        $current=$adminData->currentAvatar;
        $file = $adminData->editAvatar;
       
        $ext = $file->getClientOriginalExtension();
        $photo = time().'.'.$ext;
        $path = $file->move('manga/',$photo);
        $data = admin::find($id);
        $data->admin = $adminData->editName;
        $data->avatar = $photo;
        $data->save();
        File::delete("manga/$current");
        return $data;
       
    }
    function checkEmail($admin)
    {
        $count = admin::where("email",$admin->forgetEmail)->count();
        $data = admin::where("email",$admin->forgetEmail)->pluck("id")->toArray();
        return response()->json(["count"=>$count,"data"=>$data]);
    }
    function updatePassword($id,$admin)
    {
        $data = admin::find($id);
        $password=bcrypt($admin['forgetPass']);
        $data->update([
            'password'=>$password,
        ]);
        return $data;
    }
    function getAllAdmin()
    {
        $data = admin::all();
        return $data;
    }
 }

?>