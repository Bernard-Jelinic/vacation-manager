<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index(){
        return view('dashboards.admins.dashboard');
   }

   function addemployee(){
       return view('dashboards.admins.addemployee');
   }

   function manageemployee(){
       return view('dashboards.admins.manageemployee');
   }

    function adddepartment(){
       return view('dashboards.admins.adddepartment');
   }

   function managedepartments(){
       return view('dashboards.admins.managedepartments');
   }

   function allvacations(){
       return view('dashboards.admins.allvacations');
   }
   function pendingvacations(){
       return view('dashboards.admins.pendingvacations');
   }
   function approvedvacations(){
       return view('dashboards.admins.approvedvacations');
   }
   function notapprovedvacations(){
       return view('dashboards.admins.notapprovedvacations');
   }
//    function profile(){
//        return view('dashboards.admins.profile');
//    }
//    function settings(){
//        return view('dashboards.admins.settings');
//    }
}
