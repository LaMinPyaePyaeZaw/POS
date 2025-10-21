<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class paymentController extends Controller
{
    //payment page
    public function choosePaymentMethod(){
        $data = Payment::paginate(3);
        return view('admin.payment.payment' , compact('data'));
    }

    //create payment
    public function createPayment(Request $request){
        $validator = $request->validate([
            'paymentId' => 'required' ,
            'paymentMethod' => 'required' ,
            'accountName' => 'required' , 
        ]);

        //to create data
        Payment::create([
            'type' => $request->paymentMethod ,
            'account_number' => $request->paymentId , 
            'account_name' => $request->accountName,
        ]);
        Alert::success('Create Success', 'Payment has been created successfully...');
        return back();
    }

    //delete payment
    public function delete($id){
        Payment::where('id',$id)->delete();
        Alert::success('Delete Success', 'Payment has been deleted successfully...');
        return back();
    }

    //edit payment
    public function edit($id){
        $data = Payment::where('id',$id)->first();
        return view('admin.payment.edit' , compact('data'));   
    }

    //update payment
    public function update(Request $request){
        $validator = $request->validate([
            'paymentId' => 'required' ,
            'paymentMethod' => 'required' ,
            'accountName' => 'required' , 
        ]);

        Payment::where('id',$request->id)->update([
            'type' => $request->paymentMethod ,
            'account_number' => $request->paymentId , 
            'account_name' => $request->accountName,
        ]);

        Alert::success('Update Success', 'Payment has been updated successfully...'); 
        return to_route('paybill');
    }

}
