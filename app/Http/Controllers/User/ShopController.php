<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Rating;
use App\Models\Report;
use App\Models\Comment;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PaySlipHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class ShopController extends Controller
{
    //direct shop page
    public function shop($category_id = null){
       //dd($category_id);
        $products = Product::when(request('searchKey'),function($query){
                                $query->where('products.name','like','%'.request('searchKey').'%');
                            });

        //when user input min and max
        if(request('minPrice') != null && request('maxPrice') != null){
            $products = $products->whereBetween('price',[request('minPrice'),request('maxPrice')]);
        }

        //when user input min 
        if(request('minPrice') != null && request('maxPrice') == null){
            $products = $products->where('products.price','>=',request('minPrice'));
        }

        //when user input max 
        if(request('minPrice') == null && request('maxPrice') != null){
            $products = $products->where('products.price','<=',request('maxPrice'));
        }
        // $products = $products->when(request('minPrice'),function($query){
        //     $query->where('products.price','>=',request('minPrice'));
        // });

        // $products = $products->when(request('maxPrice'),function($query){
        //     $query->where('products.price','<=',request('maxPrice'));
        // });

        $products = $products->select('products.*','categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id');
        if($category_id == null){
            $products = $products->paginate(9);  
        }else{
            $products = $products->where('products.category_id',$category_id)->paginate(9);
        }
                         
        $categories = Category::get();
        return view('user.shop',compact('products','categories'));
    }

    //direct product details
    public function details($id){
        $product = Product::select('products.id','products.name','products.price','products.description','products.category_id','products.image' ,'products.count' ,'categories.name as category_name' )
                        ->leftJoin('categories', 'products.category_id' , 'categories.id') //table names from db
                        ->where('products.id',$id)
                        ->first();
                       // dd($product->toArray());
        $comment = Comment::select('comments.*','users.name as user_name','users.image as user_profile')
                        ->where('comments.product_id',$id)
                        ->leftJoin('users','comments.user_id','users.id')
                        ->orderBy('created_at','desc')
                        ->get();

        //to calculate average rating
        $productRating = Rating::where('product_id',$id)->avg('count'); 
        
        $ratingCheckedCount = Rating::where('product_id',$id)->get(); 

        $userRating = Rating::select('count')->where('product_id',$id)->where('user_id',Auth::user()->id)->first();
        $userRating = $userRating == null ? 0 : $userRating['count'];
        
        $productList = Product::select('products.id','products.name','products.price','products.description','products.category_id','products.image' ,'products.count' ,'categories.name as category_name' )
                        ->leftJoin('categories', 'products.category_id' , 'categories.id') //table names from db
                        ->get();

        return view('user.details',compact('product','comment','productRating','ratingCheckedCount','userRating','productList'));
        
       
    }

    //comment
    public function comment(Request $request){
        //dd($request->all());
        $request->validate([
            'comment' => 'required'
        ]);
        $data = [
            'product_id' => $request->productId , 
            'user_id' => $request->userId , 
            'message' => $request->comment , 
        ];
        Comment::create($data);
        return back();
    }

    //add rating
    public function addRating(Request $request){

        $ratingCheckData = Rating::where('product_id',$request->productId)->where('user_id',$request->userId)->first();
        //dd($ratingCheckData);
        //dd($request->all());

        if($ratingCheckData == null){
            Rating::create([
                'product_id' => $request->productId , 
                'user_id' => $request->userId , 
                'count' => $request->productRating ,
             ]);
        }else{
            Rating::where('product_id',$request->productId)->where('user_id',$request->userId)->update([
                'count' => $request->productRating 
            ]);
        }
         
         Alert::success('Rating success' , 'Rating Successfully...');
         return back();
    }

    //direct cart page
    public function cart(){
        $id = Auth::user()->id ; 

        $cart = Cart::select('carts.*','products.image','products.name','products.price')
                    ->leftJoin('products','carts.product_id','products.id')       
                    ->where('user_id',$id)
                    ->get();
        //dd($cart->toArray());

        //product price * qty
       
       $totalPrice = 0;
       foreach ($cart as $item) {
            $totalPrice += $item->price * $item->qty;
       }
       //dd($totalPrice);

       $payment = Payment::get();
        return view('user.cart',compact('cart','totalPrice','payment'));
    }

    //add to cart process
    public function addtoCart(Request $request){
        //dd($request->all());
        $productId = $request->productId ;
        $qty = $request->qty ; 
        $userId = Auth::user()->id;

        Cart::create([
            'user_id' => $userId ,
            'product_id' => $productId , 
            'qty' => $qty 
        ]);
        return to_route('shopList');
    }

    //remove cart by cart_id
    public function removeCart(Request $request){
       // logger($request->cardId);

        Cart::where('id',$request->cardId)->delete();

        //$data = Cart::where("user_id",Auth::user()->id)->get();
        $serverResponse = [
            'message' => 'success' 
        ];
        return response()->json($serverResponse,200); //server status code 200 is 'Ok'  
    }

    //order product
    public function order(Request $request){
        //logger($request->all());
        $orderArr = [];
        
        foreach($request->all() as $item){
            //logger($item);

            array_push($orderArr,[
                'user_id' => $item['user_id'] , 
                'product_id' => $item['product_id'], 
                'order_code' => $item['order_code'] , 
                'status' => 0 ,
                'count' => $item['qty'] , 
                'total_price' => $item['total_price']
            ]);
            //Cart::where('user_id',$item['user_id'])->where('product_id',$item['product_id'])->delete();
        }

        Session::put('orderList',$orderArr) ; //session creating
        

        return response()->json([
            "message" => 'success' , 
            "status" => 200
        ],200);
    }

    //direct user order list page
    public function orderList(){
        $order = Order::where('user_id',Auth::user()->id)
                ->groupBy('order_code')
                ->orderBy('created_at','desc')
                ->get();
        //dd($order->toArray());
        return view('user.orderlist',compact('order'));
    }

    //direct user order details page
    public function orderDetails($userOrderCode){
        $order = Order::select('users.name as customer_name','orders.created_at','orders.order_code','products.image as product_image','products.name as product_name','products.price as product_price','orders.count as order_count')
                ->leftJoin('products','orders.product_id','products.id')
                ->leftJoin('users','orders.user_id','users.id')
                ->where('orders.order_code',$userOrderCode)
                ->get();
        //dd($order->toArray());
        $total = 0;
        foreach ($order as $item) {
           $total += $item->order_count * $item->product_price;
        }
        return view('user.orderDetails',compact('order','total'));
    }

    //direct payment page
    public function payment(){
        //dd(Session::get('orderList'));
        $orderProduct = Session::get('orderList');
        $payment = Payment::orderBy('type','asc')->get();
        $total = 0;
        foreach($orderProduct as $item){
            $total += $item['total_price'] ; 
        }
        return view('user.payment',compact('payment','total','orderProduct'));
    }

    //orderProduct
    public function orderProduct(Request $request){
        //cart => orderTable
        //clear cart
        //user payslip data => payslip_history
        //dd($request->all());
        $request->validate([
            'name' => 'required' ,
            'phone' => 'required' ,
            'paymentMethod' => 'required' ,
            'payslipImage' => 'required' ,
        ]);

        //cart products to order step
        $cartProduct = Session::get('orderList');
        //dd($cartProduct);
        foreach ($cartProduct as $item) {
            Order::create($item);

            //after ordered -> clear cart
            Cart::where('user_id',$item['user_id'])->where('product_id',$item['product_id'])->delete();
        }

        $data = [
            'customer_name' => $request->name , 
            'phone' => $request->phone , 
            'payment_method' => $request->paymentMethod , 
            'order_code' => $request->orderCode , 
            'order_amount' => $request->totalAmount ,

        ];

        if($request->hasFile('payslipImage')){
            $fileName = uniqid().$request->file('payslipImage')->getClientOriginalName();
            $request->file('payslipImage')->move(public_path().'/payslipRecords/' , $fileName);
            $data['payslip_image'] = $fileName ;
        }

        //insert data to payslip table
        PaySlipHistory::create($data);
        return to_route('orderList');   
    }

    //contact page
    public function contact(){
        return view('user.contact');
    }

    //contact and report 
    public function contactReport(Request $request){
        $data = [
            'user_id' => Auth::user()->id ,
            'title' => $request->title , 
            'message' => $request->message ,
        ];
        Report::create($data);
        Alert::success('Report Success', 'Your report has been reported successfully...');
        return back();
    }

    //contact us
    public function aboutUs(){
        return view('user.aboutus');
    }

    //privacy and policy page
    public function privacy(){
        return view('user.privacy');
    }

    //terms and conditions
    public function terms(){
        return view('user.terms');
    }

    //faq
    public function faq(){
        return view('user.faq');
    }
}