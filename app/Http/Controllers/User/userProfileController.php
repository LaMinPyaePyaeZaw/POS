<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class userProfileController extends Controller
{
    //direct user profile page
    public function profileDetails(){
        return view('user.profile');
    }

    //user profile update
    public function profileUpdate(Request $request){
        $this->validationCheck($request) ; 
        $data = $this->requestUserData($request);
        //dd($data);

        if($request->hasFile('image')){
            //delete old image and upload new image
            $oldImageName = $request->oldImage;
            //dd($oldImageName);

            //delete old image
            if($request->oldImage != null){
                if(file_exists(public_path('userProfile/'.$oldImageName))){
                    unlink(public_path('userProfile/'.$oldImageName));
                }
            }

            //update new image
            $fileName = uniqid().$request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path().'/userProfile/' , $fileName);
            $data['image'] = $fileName ;
        }else{
            $data['image'] = $request->oldImage;
        }

        User::where('id' , Auth::user()->id)->update($data);
        Alert::success('Update Success', 'Profile has been updated successfully...');
        return back();
    }

    //request user data
    private function requestUserData($request){
        //dd(Auth::user()->name);
        $data = [];
        if(Auth::user()->name != null){
            $data['name'] = Auth::user()->provider == 'simple' ? $request->name : Auth::user()->name ; 
        }else{
            $data['nickname'] = Auth::user()->provider == 'simple' ? $request->name : Auth::user()->name  ; 
        }

        $data['email'] = Auth::user()->provider == 'simple' ? $request->email : Auth::user()->email ; 
        $data['phone'] = $request->phone ; 
        $data['address'] = $request->address ; 
        return $data;
    }

    //update validation check
    private function validationCheck($request){
        $rules = [ 
            'phone' => 'required' ,
            'address' => 'required' ,
            'image' => 'mimes:png,jpg,jpeg|file' , 
            //'image' => 'required|mimes:png,jpg,jpeg|file' ,
        ];
         
        if(Auth::user()->provider == 'simple'){
            $rules['name'] = 'required' ;
            $rules['email'] = 'required|unique:users,email,'.Auth::user()->id;
        }
            $message = [
            'name.required' => 'Name is required*' ,
            'email.required' => 'Email is required*' ,
            'phone.required' => 'Phone is required*' ,
            'address.required' => 'Address is required*' ,
         ] ;
        $validator = $request->validate($rules , $message);
    }
}
