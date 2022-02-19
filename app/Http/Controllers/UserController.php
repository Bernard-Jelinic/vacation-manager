<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    function fetchnotification(){

        $notifications = DB::table('vacations')
                ->select(DB::raw('vacations.id, vacations.created_at, users.name, users.last_name'))
                ->where('status', '!=', 0)
                ->where('user_notified', '=', 0)
                ->where('user_id', '=', Auth::user()->id)
                ->join('users', 'vacations.user_id', '=', 'users.id')
                ->get();

        // converting to better readible format for people
        foreach ($notifications as $value) {
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        //to display notification number
        $counter = count($notifications);

        return response()->json([
            'notifications'=>$notifications,
            'count'=>$counter

        ]);

    }

    function index(){

        return view('dashboards.users.dashboard');

    }

    function userprofile(Request $req){

        $id = Auth::user()->id;

        if($req->method() == 'POST'){

            $email = $req->input('email');
            $password = $req->input('password');

            $date = date("Y-m-d H:i:s");

            $user_email = DB::table('users')
                    ->select('email')
                    ->where('id', $id)
                    ->get();

            // in case of changed email
            if($user_email[0]->email !== $email){
                
                $validated = $req->validate([
                    'email'=>'required|email|unique:users',
                ]);

                $data['email'] = $req->input('email');

            }

            // in case of changed password
            if(isset($password) || trim($password) !== '') {

                $validated = $req->validate([
                    'password' => 'required|confirmed',
                ]);

                $data['password'] = Hash::make($req->input('password'));

            }

            $validated = $req->validate([
                'name'=>'required|string',
                'last_name'=>'required|string',
            ]);

            $data['name'] = $req->input('name');
            $data['last_name'] = $req->input('last_name');
            $data['updated_at'] = $date;

            DB::table('users')->where('id',$id)->update($data);

            return redirect('user/userprofile');

        }

        $user = DB::table('users')
            ->select(DB::raw('name, last_name, email'))
            ->where('id', '=', $id)
            ->get();

        return view('dashboards.users.userprofile',['user' => $user[0]]);

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