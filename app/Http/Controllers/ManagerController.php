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
            ->select(DB::raw('vacations.id, vacations.created_at, vacations.user_notified, vacations.status, users.name, users.last_name, departments.manager_id AS manager_id'))
            ->where('manager_read', '=', 0)
            ->where('manager_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
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

        return view('dashboards.managers.dashboard');
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

            return redirect('manager/userprofile');

        }

        $user = DB::table('users')
            ->select(DB::raw('name, last_name, email'))
            ->where('id', '=', $id)
            ->get();

        return view('dashboards.managers.userprofile',['user' => $user[0]]);

    }

    function allvacations(Request $req){

        $manager_id = Auth::user()->id;
        // dd($manager_id);

        // $department_id= DB::table('users')
        //     ->where('id', '=', $manager_id)
            // ->where('vacations.status', '=', 2)
            // ->update($data);

        $vacation_datas = DB::table('vacations')
            // ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.user_notified, vacations.status, users.name, users.last_name, departments.manager_id AS manager_id'))
            ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.user_notified, vacations.status, users.name, users.last_name'))
            ->where('department_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            // ->join('departments', 'users.department_id', '=', 'departments.id')
            ->get();

        $manager_ids = array();

        // converting to better readible format for people
        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
            $manager_ids[] = $value->id;
        }

        $data['manager_read'] = 1;

        // writing all managers employee vacations as manager_read
        foreach ($manager_ids as $value) {
            DB::table('vacations')
                ->where('id', '=', $value)
                ->update($data);
        }

        // variable display is because I can only have one view
        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'all']);

    }

    function pendingvacations(){

        $manager_id = Auth::user()->id;

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.user_notified, vacations.status, users.name, users.last_name, departments.manager_id AS manager_id'))
            ->where('vacations.status', '=', 0)
            ->where('manager_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->get();

        $manager_ids = array();

        // converting to better readible format for people
        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
            $manager_ids[] = $value->id;
        }

        $data['manager_read'] = 1;

        // writing managers employee pendings vacations as manager_read
        foreach ($manager_ids as $value) {
            DB::table('vacations')
                ->where('id', '=', $value)
                ->where('vacations.status', '=', 0)
                ->update($data);
        }

        // variable display is because I can only have one view
        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'pending']);

    }

    function approvedvacations(){

         $manager_id = Auth::user()->id;

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.user_notified, vacations.status, users.name, users.last_name, departments.manager_id AS manager_id'))
            ->where('vacations.status', '=', 1)
            ->where('manager_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->get();

        $manager_ids = array();

        // converting to better readible format for people
        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
            $manager_ids[] = $value->id;
        }

        $data['manager_read'] = 1;

        // writing managers employee approved vacations as manager_read
        foreach ($manager_ids as $value) {
            DB::table('vacations')
                ->where('id', '=', $value)
                ->where('vacations.status', '=', 1)
                ->update($data);
        }

        // variable display is because I can only have one view
        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'approved']);

    }

    function notapprovedvacations(){

         $manager_id = Auth::user()->id;

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.user_notified, vacations.status, users.name, users.last_name, departments.manager_id AS manager_id'))
            ->where('vacations.status', '=', 2)
            ->where('manager_id', '=', $manager_id)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->get();

        $manager_ids = array();

        // converting to better readible format for people
        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
            $manager_ids[] = $value->id;
        }

        $data['manager_read'] = 1;

        // writing managers employee not approved vacations as manager_read
        foreach ($manager_ids as $value) {
            DB::table('vacations')
                ->where('id', '=', $value)
                ->where('vacations.status', '=', 2)
                ->update($data);
        }

        // variable display is because I can only have one view
        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'not approved']);

    }

    function editvacation(Request $req){

        $id = $req->route()->id;

        $data['manager_read'] = 1;

        DB::table('vacations')
            ->where('id',$id)
            ->update($data);

        if ($req->method()=="POST") {
            
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

        // converting to better readible format for people
        foreach ($vacation_data as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.managers.editvacation', ['vacation_data' => $vacation_data]);

    }
}
