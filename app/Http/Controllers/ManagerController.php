<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    function index(){
        return view('dashboards.managers.index');
    }

    function profile(){
        return view('dashboards.managers.profile');
    }

    function settings(){
        return view('dashboards.managers.settings');
    }
}
