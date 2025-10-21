<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleInformationController extends Controller
{
    //sale info list
    public function saleInfoList(){
        $order = Order::select('users.id as user_id','orders.id as order_id','orders.count as order_count','orders.created_at','orders.order_code','users.name as user_name','products.image as product_image','products.name as product_name','orders.total_price','orders.status','products.price as product_price')
                    ->leftJoin('products','orders.product_id','products.id')
                    ->leftJoin('users','orders.user_id','users.id')
                    ->where('orders.status',1)
                    ->groupBy('orders.order_code')
                    ->orderBy('orders.created_at','desc')
                    ->get();
        //dd($order->toArray());

        $total = 0;
        foreach ($order as $item) {
           $total += $item->order_count * $item->product_price;
        }

        //dd($total);
        return view('admin.saleInformation.list',compact('order','total'));
    }
}
