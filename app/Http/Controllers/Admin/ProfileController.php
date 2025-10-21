<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    //profile details page
    public function profileDetails(){
        return view('admin.profile.details');
    }

    //update profile
    public function profileUpdate(Request $request){
        $this->validationCheck($request) ; 
        $data = $this->requestAdminData($request);
        //dd($data);

        if($request->hasFile('image')){
            //delete old image and upload new image
            $oldImageName = $request->oldImage;
            //dd($oldImageName);

             //delete old image
             if($request->oldImage != null){
                if(file_exists(public_path('adminProfile/'.$oldImageName))){
                     unlink(public_path('adminProfile/'.$oldImageName));
                 }
             }

             //update new image
             $fileName = uniqid().$request->file('image')->getClientOriginalName();
             $request->file('image')->move(public_path().'/adminProfile/' , $fileName);
             $data['image'] = $fileName ;
         }else{
             $data['image'] = $request->oldImage;
        }

        

        User::where('id' , Auth::user()->id)->update($data);
        Alert::success('Update Success', 'Profile has been updated successfully...');
        return back();
    }

    //create admin account page
    public function createAdminAccount(){
        return view('admin.profile.createAdminAccount');
    }

    //create new admin
    public function create(Request $request){
        $request->validate([
            'name' => 'required' , 
            'email' => 'required|unique:users,email', 
            'password' => 'required' , 
            'confirmPassword' => 'required|same:password' , 
        ]);

        $adminAccount = [
            'name' => $request->name , 
            'email' => $request->email , 
            'password' => Hash::make($request->password) ,
            'role' => 'admin' , 
            'provider' => 'simple' , 
        ];  
        User::create($adminAccount);
        Alert::success('Create Success', 'New admin has been created successfully...');
        return back();
    }

    //direct account profile info
    public function accountProfile($id){
        $account = User::where('id',$id)->first();
        return view('admin.profile.accoutProfile',compact('account'));
    }

    //request admin data
    private function requestAdminData($request){
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
