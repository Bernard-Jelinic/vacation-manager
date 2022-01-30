<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ManagerController extends Controller
{

    function fetchnotification(){

        $manager_id = Auth::user()->id;

        $notifications = DB::table('vacations')
            ->select(DB::raw('vacations.id, vacations.created_at, users.name, users.last_name'))
            ->where('status', '=', 0)
            ->where('user_notified', '=', 0)
            ->where('manager_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->get();

        foreach ($notifications as $value) {
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        $counter = count($notifications);

        return response()->json([
            'notifications'=>$notifications,
            'count'=>$counter
        ]);

    }

    function index(){

        return view('dashboards.managers.dashboard');
    }

    function allvacations(Request $req){

        $manager_id = Auth::user()->id;

        // $data['manager_read'] = 1;

        // DB::table('vacations')
        //     ->update($data);

        //////$query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id";
        //////$vacation_datas = DB::select($query);

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at,vacations.status, vacations.user_id, users.name, users.last_name'))
            // ->where('status', '=', 0)
            // ->where('user_notified', '=', 0)
            ->where('manager_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->get();

        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'all']);

    }

    function pendingvacations(){

        $data['manager_read'] = 1;

        DB::table('vacations')
            ->where('status', '=',0)
            ->update($data);

        // $query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id WHERE vacations.status = 0";
        // $vacation_datas = DB::select($query);

        $manager_id = Auth::user()->id;

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at,vacations.status, vacations.user_id, users.name, users.last_name'))
            // ->where('status', '=', 0)
            // ->where('user_notified', '=', 0)
            ->where('vacations.status', '=', 0)
            ->where('manager_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->get();

        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'pending']);

    }

    function approvedvacations(){

        $data['manager_read'] = 1;

        DB::table('vacations')
            ->where('status', '=',1)
            ->update($data);

        // $query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id WHERE vacations.status = 1";
        // $vacation_datas = DB::select($query);

        $manager_id = Auth::user()->id;

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at,vacations.status, vacations.user_id, users.name, users.last_name'))
            // ->where('status', '=', 0)
            // ->where('user_notified', '=', 0)
            ->where('vacations.status', '=', 1)
            ->where('manager_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->get();

        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'approved']);

    }

    function notapprovedvacations(){

        $data['manager_read'] = 1;

        DB::table('vacations')
            ->where('status', '=',2)
            ->update($data);

        // $query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id WHERE vacations.status = 2";
        // $vacation_datas = DB::select($query);

        $manager_id = Auth::user()->id;

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at,vacations.status, vacations.user_id, users.name, users.last_name'))
            // ->where('status', '=', 0)
            // ->where('user_notified', '=', 0)
            ->where('vacations.status', '=', 2)
            ->where('manager_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->get();

        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'not approved']);

    }

    function editvacation(Request $req){

        $id = $req->route()->id;

        $data['manager_read'] = 1;

        DB::table('vacations')
            ->where('manager_id',$id)
            ->update($data);

        if ($req->method()=="POST") {
            
            print_r($req->input('status'));
            
            $validated = $req->validate([
                'status' => 'required|string',
            ]);

            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['status'] = $req->input('status');

            DB::table('vacations')
                ->where('id',$id)
                ->update($data);

            return redirect('manager/allvacations');

        }

        $query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id WHERE vacations.id = {$id}";

        $vacation_data = DB::select($query);

        //print_r($vacation_data);

        foreach ($vacation_data as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.managers.editvacation', ['vacation_data' => $vacation_data]);

    }
}
