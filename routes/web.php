<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//ovo spriječava da kada sam prijavljen da se vratim na login page sa back-om
Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {
    Auth::routes();
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin','auth','PreventBackHistory']], function(){
        Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');
        // Route::get('addemployee',[AdminController::class,'addemployee'])->name('admin.addemployee');
        Route::get('addemployee',[AdminController::class,'addemployee'])->name('addemployee');
        Route::get('manageemployee',[AdminController::class,'manageemployee'])->name('manageemployee');

        Route::get('adddepartment',[AdminController::class,'adddepartment'])->name('adddepartment');
        Route::get('managedepartments',[AdminController::class,'managedepartments'])->name('managedepartments');

        Route::get('allvacations',[AdminController::class,'allvacations'])->name('allvacations');
        Route::get('pendingvacations',[AdminController::class,'pendingvacations'])->name('pendingvacations');
        Route::get('approvedvacations',[AdminController::class,'approvedvacations'])->name('approvedvacations');
        Route::get('notapprovedvacations',[AdminController::class,'notapprovedvacations'])->name('notapprovedvacations');



        Route::post('update-profile-info',[AdminController::class,'updateInfo'])->name('adminUpdateInfo');
        Route::post('change-profile-picture',[AdminController::class,'updatePicture'])->name('adminPictureUpdate');
        Route::post('change-password',[AdminController::class,'changePassword'])->name('adminChangePassword');
       
});

Route::group(['prefix'=>'manager', 'middleware'=>['isManager','auth','PreventBackHistory']], function(){
    Route::get('dashboard',[ManagerController::class,'index'])->name('manager.dashboard');
    Route::get('profile',[ManagerController::class,'profile'])->name('manager.profile');
    Route::get('settings',[ManagerController::class,'settings'])->name('manager.settings');
    
});

Route::group(['prefix'=>'user', 'middleware'=>['isUser','auth','PreventBackHistory']], function(){
    Route::get('dashboard',[UserController::class,'index'])->name('user.dashboard');
    Route::get('profile',[UserController::class,'profile'])->name('user.profile');
    Route::get('settings',[UserController::class,'settings'])->name('user.settings');
    
});