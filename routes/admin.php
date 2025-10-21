<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminListController;
use App\Http\Controllers\admin\orderBoardController;
use App\Http\Controllers\Admin\RoleChangeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\SaleInformationController;

//admin site
Route::group(['prefix' => 'admin' , 'middleware' => ['auth' , 'admin'] ],function(){
   
    Route::get('/home',[AdminDashboardController::class,'index'])->name('adminDashboard'); 
 
    //category
    Route::prefix('category')->group(function(){
        Route::get('list' , [CategoryController::class,'list'])->name('categoryList');
        Route::get('create' , [CategoryController::class,'createPage'])->name('categoryCreatePage');
        Route::post('create' , [CategoryController::class,'create'])->name('categoryCreate');
        Route::get('delete/{id}' , [CategoryController::class,'delete'])->name('categoryDelete');
        Route::get('edit/{id}' , [CategoryController::class,'edit'])->name('categoryEdit');
        Route::post('update' , [CategoryController::class,'update'])->name('categoryUpdate');
    });

    //product
    Route::prefix('product')->group(function(){
        Route::get('list' , [ProductController::class,'list'])->name('productList');
        Route::get('create' , [ProductController::class,'createPage'])->name('productCreatePage');
        Route::post('create' , [ProductController::class,'productCreate'])->name('productCreate');
        Route::get('delete/{id}' , [ProductController::class,'delete'])->name('productDelete');
        Route::get('details/{id}' , [ProductController::class,'details'])->name('productDetails');
        Route::get('edit/{id}' , [ProductController::class,'edit'])->name('productEdit');
        Route::post('update' , [ProductController::class,'update'])->name('productUpdate');
    });

    //password change
    Route::prefix('password')->group(function(){
        Route::get('change' , [AuthController::class,'change'])->name('passwordChange');
        Route::post('change' , [AuthController::class,'changePassword'])->name('changePassword');
    });

    //payment
    Route::prefix('payment')->group(function(){
        Route::get('choosePayment' , [paymentController::class,'choosePaymentMethod'])->name('paybill');
        Route::post('create' , [paymentController::class,'createPayment'])->name('createPayment');
        Route::get('delete/{id}' , [paymentController::class,'delete'])->name('paymentDelete');
        Route::get('edit/{id}' , [paymentController::class,'edit'])->name('paymentEdit');
        Route::post('update' , [paymentController::class,'update'])->name('paymentUpdate');
    });

    //profile
    Route::prefix('profile')->group(function(){
        Route::get('details' , [ProfileController::class,'profileDetails'])->name('adminprofileDetails');
        Route::post('update' , [ProfileController::class,'profileUpdate'])->name('adminprofileUpdate');
        //create admin account
        Route::get('create/adminAccount' , [ProfileController::class,'createAdminAccount'])->name('createAdminAccount');
        Route::post('create/adminAccount', [ProfileController::class,'create'])->name('createNewAdmin');
        Route::get('account/{id}', [ProfileController::class,'accountProfile'])->name('accountProfile');
    });

    //admin list
    Route::prefix('role')->group(function(){
        Route::get('adminList' , [RoleChangeController::class,'adminList'])->name('adminList');
        Route::get('deleteAdminAccount/{id}' , [RoleChangeController::class,'deleteAdmin'])->name('deleteAdmin');
        Route::get('userList' , [RoleChangeController::class,'userList'])->name('userList');
        Route::get('deleteUserAccount/{id}' , [RoleChangeController::class,'deleteUser'])->name('deleteUser');
        Route::get('changeAdminRole/{id}' , [RoleChangeController::class,'roleChange'])->name('roleChange');
        Route::get('changeUserRole/{id}' , [RoleChangeController::class,'roleChangeUser'])->name('roleChangeUser');
        //Route::post('change' , [AuthController::class,'changePassword'])->name('changePassword');
    });

    //order board
    Route::prefix('order')->group(function(){
        Route::get('list' , [orderBoardController::class,'userOrderList'])->name('userOrderList');
        Route::get('details/{orderCode}' , [orderBoardController::class,'userOrderDetails'])->name('userOrderDetails');
        Route::get('change/status' , [orderBoardController::class,'changeStatus'])->name('changeStatus');
    });

    //sale information
    Route::prefix('saleInfo')->group(function(){
        Route::get('list' , [SaleInformationController::class,'saleInfoList'])->name('saleInfoList');
    });

});

?>