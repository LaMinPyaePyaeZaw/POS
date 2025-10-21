<?php

namespace App\Http\Controllers\admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\PaySlipHistory;
use App\Http\Controllers\Controller;

class orderBoardController extends Controller
{
    //direct order list page
    public function userOrderList(){
        $order = Order::select('users.id as user_id','orders.id as order_id','orders.created_at','orders.order_code','users.name as user_name','products.name as product_name','orders.total_price','orders.status')
                ->leftJoin('products','orders.product_id','products.id')
                ->leftJoin('users','orders.user_id','users.id')
                ->groupBy('orders.order_code')
                ->orderBy('orders.created_at','desc')
                ->paginate(5);
        
        return view('admin.orderBoard.list',compact('order'));
    }

    //check order details page
    public function userOrderDetails($orderCode){
        //dd($orderCode);
        $order = Order::select('users.name as customer_name','users.phone as user_phone','orders.created_at','orders.order_code','products.image as product_image','products.name as product_name','products.price as product_price','orders.count as order_count')
                ->leftJoin('products','orders.product_id','products.id')
                ->leftJoin('users','orders.user_id','users.id')
                ->where('orders.order_code',$orderCode)
                ->get();
        
        $payslipData = PaySlipHistory::select('pay_slip_histories.*','payments.type as payment_type')
                                    ->leftJoin('payments','pay_slip_histories.payment_method','payments.id')
                                    ->where('pay_slip_histories.order_code',$orderCode)
                                    ->first();
        //dd($payslipData->toArray());
        //dd($order->toArray());
        $total = 0;
        foreach ($order as $item) {
           $total += $item->order_count * $item->product_price;
        }
        return view('admin.orderBoard.details',compact('order','total','payslipData'));
    }

    //change order code status
    public function changeStatus(Request $request){
        //logger($request->all());
        Order::where('order_code',$request->orderCode)->update([
            'status' => $request->status 
        ]);
    }
}
