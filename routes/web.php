<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/login', function () {
    return view('auth.login');
});

// Route::get('/register', function () {
//     return view('register');
// });

//this prevent going back to login page if you are already login
Route::middleware(['middleware'=>'PreventBackHistory'])->group(function () {
    Auth::routes();
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin','auth','PreventBackHistory']], function(){

    Route::get('dashboard',[AdminController::class,'index'])->name('admin.dashboard');
    Route::get('fetchnotification',[AdminController::class,'fetchnotification']);

    Route::get('adddepartment',[AdminController::class,'adddepartment'])->name('adddepartment');
    Route::post('adddepartment',[AdminController::class,'adddepartment'])->name('adddepartment');
    Route::get('managedepartments',[AdminController::class,'managedepartments'])->name('managedepartments');
    Route::get('managedepartments/edit/{id}',[AdminController::class,'editdepartment']);
    Route::post('managedepartments/edit/{id}',[AdminController::class,'editdepartment']);
    Route::post('managedepartments/delete/{id}',[AdminController::class,'deletedepartment']);

    Route::get('addemployee',[AdminController::class,'addemployee'])->name('addemployee');
    Route::post('addemployee',[AdminController::class,'addemployee'])->name('addemployee');
    Route::get('manageemployee',[AdminController::class,'manageemployee'])->name('manageemployee');
    Route::get('manageemployee/edit/{id}',[AdminController::class,'editemployee']);
    Route::post('manageemployee/edit/{id}',[AdminController::class,'editemployee']);
    Route::post('manageemployee/delete/{id}',[AdminController::class,'deleteemployee']);

    Route::get('allvacations',[AdminController::class,'allvacations'])->name('allvacations');
    Route::get('editvacation/{id}',[AdminController::class,'editvacation']);
    Route::post('editvacation/{id}',[AdminController::class,'editvacation']);
    Route::get('pendingvacations',[AdminController::class,'pendingvacations'])->name('pendingvacations');
    Route::get('approvedvacations',[AdminController::class,'approvedvacations'])->name('approvedvacations');
    Route::get('notapprovedvacations',[AdminController::class,'notapprovedvacations'])->name('notapprovedvacations');
       
});

Route::group(['prefix'=>'manager', 'middleware'=>['isManager','auth','PreventBackHistory']], function(){

    Route::get('dashboard',[ManagerController::class,'index'])->name('manager.dashboard');
    Route::get('fetchnotification',[ManagerController::class,'fetchnotification']);

    Route::get('allvacations',[ManagerController::class,'allvacations'])->name('allvacations');
    Route::get('editvacation/{id}',[ManagerController::class,'editvacation']);
    Route::post('editvacation/{id}',[ManagerController::class,'editvacation']);
    Route::get('pendingvacations',[ManagerController::class,'pendingvacations'])->name('pendingvacations');
    Route::get('approvedvacations',[ManagerController::class,'approvedvacations'])->name('approvedvacations');
    Route::get('notapprovedvacations',[ManagerController::class,'notapprovedvacations'])->name('notapprovedvacations');
    
});

Route::group(['prefix'=>'user', 'middleware'=>['isUser','auth','PreventBackHistory']], function(){

    Route::get('dashboard',[UserController::class,'index'])->name('user.dashboard');
    Route::get('fetchnotification',[UserController::class,'fetchnotification']);

    Route::get('applyvacation',[UserController::class,'applyvacation'])->name('applyvacation');
    Route::post('applyvacation',[UserController::class,'applyvacation'])->name('applyvacation');
    Route::get('historyvacations',[UserController::class,'historyvacations'])->name('historyvacations');
    
});