<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    function fetchnotification(){
        
        // $notifications = "SELECT COUNT(*) FROM vacations WHERE admin_read = 0;";
        // $rows_number = DB::select($notifications);
        //$count = DB::table('vacations')->where('admin_read', '=', 0)->count();

        $notifications = DB::table('vacations')
                ->select(DB::raw('vacations.id, vacations.created_at, users.name, users.last_name'))
                ->where('status', '!=', 0)
                ->where('user_notified', '=', 0)
                ->where('user_id', '=', Auth::user()->id)
                ->join('users', 'vacations.user_id', '=', 'users.id')
                ->get();
                // ->count();

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

        return view('dashboards.users.dashboard');

    }

    function applyvacation(Request $req){

        // $user_id = Auth::user()->id;

        // $vacation_datas = DB::table('vacations')
        //     ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at,vacations.status, vacations.user_id, users.name, users.last_name'))
        //     // ->where('status', '=', 0)
        //     // ->where('user_notified', '=', 0)
        //     ->where('vacations.status', '=', 2)
        //     ->where('manager_id', '=', $user_id)
        //     ->join('users', 'vacations.user_id', '=', 'users.id')
        //     ->get();

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

        // because user is read all the notifications
        $data['user_notified'] = 1;

        DB::table('vacations')
            ->where('user_id',$user_id)
            ->update($data);
        
        $query = "SELECT `id`, `depart`, `return`, `created_at`, `status` FROM `vacations` WHERE user_id={$user_id}";
        $vacation_datas = DB::select($query);

        // converting to better format for people
        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.users.historyvacations', ['vacation_datas' => $vacation_datas]);

    }

}