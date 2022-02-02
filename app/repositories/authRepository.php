<?php
namespace App\repositories;

use App\interfaces\authInterface;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;


class authRepository implements authInterface{
    public function userRegister($user){
      $user->validate([
        'email'=>['required',Rule::unique('users')]
      ]);
      $data = new User;
      if($user->avatar!=null)
      {
        $file = $user->avatar;
        $ext = $file->getClientOriginalExtension();
        $photo = time().'.'.$ext;
        $data->avatar=$photo;
      }else{
        $data->avatar=null;
      }
      $data->first_name=$user->first_name;
      $data->last_name=$user->last_name;
      $data->email=$user->email;
      $data->password=bcrypt($user->password);
      $data->save();

      return response()->json(['response'=>$data]);
    }
    public function userLogin($user)
    {
      $data = User::where(['email'=>$user->email])->first();
      if(!$data || Hash::check($user->password, $data->password)){
        return response()->json(['message'=>'Email or Password not match']);
      }else{
        return $data;
      }
    }
}
?>