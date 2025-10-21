<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Models\Rating;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserDashboardController extends Controller
{
    //direct user dashboard page
    public function index(){
        $category = Category::get();
        $products = Product::select('products.*','categories.name as category_name')
                            ->leftJoin('categories','products.category_id','categories.id')
                            ->get();
        //dd($products->toArray());
        $customerCount = User::where('role','user')->count();
        $rating = Rating::select('ratings.count','users.name','users.image','users.nickname','ratings.created_at')
                        ->leftJoin('users','ratings.user_id','users.id')
                        ->orderBy('created_at','desc')
                        ->get();
        //dd($rating->toArray());
        return view('user.home' , compact('category' , 'products' , 'customerCount','rating'));
    }
}
