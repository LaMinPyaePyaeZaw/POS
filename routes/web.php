<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;

require __DIR__.'/auth.php';
require_once __DIR__.'/admin.php'; //for admin
require_once __DIR__.'/user.php';  //for user

Route::redirect('/','auth/login');

Route::middleware('admin')->group(function(){
    Route::get('auth/register' , [AuthController::class,'registerPage'])->name('userRegister');
    Route::get('auth/login' , [AuthController::class,'loginPage'])->name('userLogin');
});

//for github login
Route::get('/auth/{provider}/redirect', [ProviderController::class,'redirect']);

//for google login
Route::get('/auth/{provider}/callback', [ProviderController::class,'callback']);






