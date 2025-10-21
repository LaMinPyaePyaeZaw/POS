<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    //direct admin dashboard page
    public function index(){
        //for total sale 
        $total_sale_amount = Order::sum('total_price');
        
        //for user count
        $userCount = User::where('role','user')->count();
        
        //order pending requests
        $orderPendingCount = Order::where('status',0)->groupBy('order_code')->get();
        $orderPendingCount = count($orderPendingCount);

        //order success count
        $orderSuccessCount = Order::where('status',1)->groupBy('order_code')->get();
        $orderSuccessCount = count($orderSuccessCount);

        //for admin count
        $adminCount = User::orWhere('role','admin')->orWhere('role','superadmin')->count();

        //category count
        $categoryCount = Category::count();

        //product count
        $productCount = Product::count();

        //payment type count
        $paymentType = Payment::count();
        return view('admin.home',compact('total_sale_amount','userCount','orderPendingCount','orderSuccessCount','adminCount','categoryCount','productCount','paymentType'));
    }
}
