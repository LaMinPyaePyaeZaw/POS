<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class RoleChangeController extends Controller
{
    //admin list page
   public function adminList(){
        $adminList = User::select('id' , 'name' , 'nickname' , 'email' , 'address' , 'phone' , 'role')
                        ->orWhere('role' , 'admin')
                        ->orWhere('role' , 'superadmin')
                        ->paginate(5);
        $userCount = User::where('role' , 'user')->count();
        return view('admin.roleChange.adminlist' , compact('adminList' , 'userCount'));
   }

   //delete admin account
   public function deleteAdmin($id){
     User::where('id',$id)->delete();
     Alert::success('Delete Success', 'Admin account has been deleted successfully...');
     return back();
   }

   //admin user page
   public function userList(){
     $userList = User::select('id' , 'name' , 'nickname' , 'email' , 'address' , 'phone' , 'role')
                     ->where('role' , 'user')
                     ->paginate(5);
      $adminCount  = User::orWhere('role' , 'admin')
                        ->orWhere('role' , 'superadmin')
                        ->count();
     return view('admin.roleChange.userList' , compact('userList' , 'adminCount'));
}

  //delete user account
  public function deleteUser($id){
    User::where('id',$id)->delete();
    Alert::success('Delete Success', 'User account has been deleted successfully...');
    return back();
  }

  //change to admin role
  public function roleChange($id){
    User::where('id' , $id)->update(['role' => 'admin']);
    Alert::success('Change Success', 'User account has been changed successfully...');
    return back();
  }

  //change to user role
  public function roleChangeUser($id){
    User::where('id' , $id)->update(['role' => 'user']);
    Alert::success('Change Success', 'Admin account has been changed successfully...');
    return back();
  }
}
