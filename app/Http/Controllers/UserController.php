<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    function index(){

        return view('dashboards.users.dashboard');

    }

    function applyvacations(){

        return view('dashboards.users.applyvacations');

    }

    function historyvacations(){

        return view('dashboards.users.historyvacations');

    }

}