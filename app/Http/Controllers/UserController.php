<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function index(){

        return view('dashboards.users.dashboard');

    }

    function applyvacation(Request $req){

        if($req->method() == 'POST'){

            //converting input to date because input is type string
            $depart = date('Y-m-d', strtotime($req->input('depart')));
            $return = date('Y-m-d', strtotime($req->input('return')));

            $validated = $req->validate([
                'depart'=>'required',
                'return'=>'required',
            ]);

            $date = date("Y-m-d H:i:s");

            $data = [
                'depart' => $depart,
                'return' => $return,
                'created_at' => $date,
                'updated_at' => $date,
                'status' => 0,
                'admin_read' => 0,
                'manager_read' => 0,
                'user_notified' => 0,
                'user_id' => Auth::user()->id,

            ];

            DB::table('vacations')->insert($data);

            return redirect('user/historyvacations');
            
        }

        return view('dashboards.users.applyvacation');

    }

    function historyvacations(){

        $user_id = Auth::user()->id;
        $query = "SELECT `id`, `depart`, `return`, `created_at`, `status` FROM `vacations` WHERE user_id={$user_id}";
        $vacation_datas = DB::select($query);

        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.users.historyvacations', ['vacation_datas' => $vacation_datas]);

    }

}