<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    //password change
    public function change(){
        return view('admin/password.changePassword');
    }

    //change password page
    public function changePassword(Request $request){
        $validator = $request->validate([
            'oldPassword' => 'required' ,
            'newPassword' => 'required' ,
            'confirmPassword' => 'required|same:newPassword' , 
        ]);

        //to get old password from database
        $dbHashPassword = User::select('password') //User is currently login user
                    ->where('id' , Auth::user()->id)->first(); //get hashed password
        $dbHashPassword = $dbHashPassword['password'];
        $userOldPassword = $request->oldPassword; //plane text 
        if(Hash::check($userOldPassword , $dbHashPassword)){ //[plane text , hash value]
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id' , Auth::user()->id)->update($data);
            Alert::success('Password Change Success', 'Password has been changed successfully...');
            return back();
        }
        Alert::error('Error Message', 'Old Pasword Do Not Match ! Try Again...');
        return back();

    }
}
