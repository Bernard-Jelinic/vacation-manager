<?php

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Auth\RegisterController;

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


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['prefix'=>'admin', 'middleware'=>['isAdmin','auth','PreventBackHistory']], function(){

    Route::get('',[AdminController::class,'index'])->name('admin.dashboard');
    Route::get('fetchnotification',[AdminController::class,'fetchnotification']);

    Route::get('userprofile',[AdminController::class,'userprofile'])->name('admin.userprofile');
    Route::post('userprofile',[AdminController::class,'userprofile'])->name('admin.userprofile');

    Route::get('adddepartment',[AdminController::class,'adddepartment'])->name('adddepartment');
    Route::post('adddepartment',[AdminController::class,'adddepartment'])->name('adddepartment');
    Route::get('managedepartments',[AdminController::class,'managedepartments'])->name('managedepartments');
    Route::get('managedepartments/edit/{id}',[AdminController::class,'editdepartment'])->name('editdepartment');
    Route::post('managedepartments/edit/{id}',[AdminController::class,'editdepartment'])->name('editdepartment');
    Route::post('managedepartments/delete/{id}',[AdminController::class,'deletedepartment'])->name('deletedepartment');
    

    Route::get('addemployee',[AdminController::class,'addemployee'])->name('addemployee');
    // Route::get('addemployee',[AdminController::class,'addemployee'])->name('addemployee');

    Route::post('addemployee',[AdminController::class,'addemployee'])->name('addemployee');
    // Route::get('manageemployee',[AdminController::class,'manageemployee'])->name('manageemployee');

    Route::get('employees',[UserController::class,'index'])->name('employees.index');

    
    Route::get('manageemployee/edit/{id}',[AdminController::class,'editemployee'])->name('editemployee');
    Route::post('manageemployee/edit/{id}',[AdminController::class,'editemployee'])->name('editemployee');
    Route::post('manageemployee/delete/{id}',[AdminController::class,'deleteemployee'])->name('deleteemployee');
    // Route::post('employees/{employee}',[UserController::class,'destroy'])->name('employee.destroy');

    Route::get('allvacations',[AdminController::class,'allvacations'])->name('admin.allvacations');
    //URLs For Named Routes
    Route::get('editvacation/{id}',[AdminController::class,'editvacation'])->name('admin.editvacation');
    Route::post('editvacation/{id}',[AdminController::class,'editvacation'])->name('admin.editvacation');
    Route::get('pendingvacations',[AdminController::class,'pendingvacations'])->name('admin.pendingvacations');
    Route::get('approvedvacations',[AdminController::class,'approvedvacations'])->name('admin.approvedvacations');
    Route::get('notapprovedvacations',[AdminController::class,'notapprovedvacations'])->name('admin.notapprovedvacations');
       
});

Route::group(['prefix'=>'manager', 'middleware'=>['isManager','auth','PreventBackHistory']], function(){

    Route::get('',[ManagerController::class,'index'])->name('manager.dashboard');
    Route::get('fetchnotification',[ManagerController::class,'fetchnotification']);

    Route::get('userprofile',[ManagerController::class,'userprofile'])->name('manager.userprofile');
    Route::post('userprofile',[ManagerController::class,'userprofile'])->name('manager.userprofile');

    Route::get('allvacations',[ManagerController::class,'allvacations'])->name('manager.allvacations');
    Route::get('editvacation/{id}',[ManagerController::class,'editvacation']);
    Route::post('editvacation/{id}',[ManagerController::class,'editvacation']);
    Route::get('pendingvacations',[ManagerController::class,'pendingvacations'])->name('manager.pendingvacations');
    Route::get('approvedvacations',[ManagerController::class,'approvedvacations'])->name('manager.approvedvacations');
    Route::get('notapprovedvacations',[ManagerController::class,'notapprovedvacations'])->name('manager.notapprovedvacations');
    
});

Route::group(['prefix'=>'employee', 'middleware'=>['isEmployee','auth','PreventBackHistory']], function(){

    Route::get('',[EmployeeController::class,'index'])->name('employee.dashboard');
    Route::get('fetchnotification',[EmployeeController::class,'fetchnotification']);

    Route::get('userprofile',[EmployeeController::class,'userprofile'])->name('employee.userprofile');
    Route::post('userprofile',[EmployeeController::class,'userprofile'])->name('employee.userprofile');

    Route::get('applyvacation',[EmployeeController::class,'applyvacation'])->name('applyvacation');
    Route::post('applyvacation',[EmployeeController::class,'applyvacation'])->name('applyvacation');
    Route::get('historyvacations',[EmployeeController::class,'historyvacations'])->name('historyvacations');
    
});