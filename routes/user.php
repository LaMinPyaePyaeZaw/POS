<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\userProfileController;
use App\Http\Controllers\User\UserDashboardController;

    //customer site
    Route::group(['prefix' => 'user' , 'middleware' => ['auth' , 'user'] ],function(){
        
        Route::get('/home',[UserDashboardController::class,'index'])->name('customerDashboard');
        Route::get('/shop/{category_id?}' , [ShopController::class , 'shop'])->name('shopList');
        Route::get('details/{id}',[ShopController::class , 'details'])->name('shopDetails');
        Route::post('comment',[ShopController::class , 'comment'])->name('comment');
        Route::post('addRating',[ShopController::class , 'addRating'])->name('addRating');
        Route::get ('cart',[ShopController::class , 'cart'])->name('cart');
        Route::post('addToCart',[ShopController::class , 'addtoCart'])->name('addToCart');
        Route::get('remove/cart',[ShopController::class , 'removeCart'])->name('removeCart');
        Route::get('order',[ShopController::class , 'order'])->name('order');
        Route::get('orderList',[ShopController::class , 'orderList'])->name('orderList');
        Route::get('orderDetails/{userOrderCode}' , [ShopController::class,'orderDetails'])->name('orderDetails');
        Route::get('payment',[ShopController::class,'payment'])->name('payment');
        Route::post('order/product',[ShopController::class,'orderProduct'])->name('orderProduct');
        Route::get('contact',[ShopController::class,'contact'])->name('contact');
        Route::post('contact/report',[ShopController::class,'contactReport'])->name('contactReport');
        Route::get('aboutUs',[ShopController::class,'aboutUs'])->name('aboutUs');
        Route::get('privacyAndPolicy',[ShopController::class,'privacy'])->name('privacy');
        Route::get('termsAndConditions',[ShopController::class,'terms'])->name('terms');
        Route::get('faqsAndHelp',[ShopController::class,'faq'])->name('faq');
    });

    //profile
    Route::prefix('userprofile')->group(function(){
        Route::get('details' , [userProfileController::class,'profileDetails'])->name('profileDetails');
        Route::post('update' , [userProfileController::class,'profileUpdate'])->name('profileUpdate');
    });

    //password change
    Route::prefix('password')->group(function(){
        Route::get('change' , [AuthController::class,'change'])->name('userpasswordChange');
        Route::post('change' , [AuthController::class,'changePassword'])->name('userchangePassword');
    });
?>