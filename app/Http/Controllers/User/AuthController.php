<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    //direct password change page
    public function change(){
        return view('user.changePassword');
    }

    //change password
    public function changePassword(Request $request){
        //dd($request->All());
        $validator = $request->validate([
            'oldPassword' => 'required' ,
            'newPassword' => 'required' ,
            'confirmPassword' => 'required|same:newPassword' , 
        ]);

        $dbHashPassword = User::select('password')
                                ->where('id',Auth::user()->id)->first();
        $dbHashPassword = $dbHashPassword['password'];
        //dd($dbHashPassword);
        $userOldPassword = $request->oldPassword; 
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
