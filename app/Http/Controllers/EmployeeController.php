<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{

    function fetchnotification(User $user, Vacation $vacation){

        $id = Auth::user()->id;

        $notifications = $vacation->userFetchnotification($id);

        //to display notification number
        $counter = count($notifications);

        return response()->json([
            'notifications'=>$notifications,
            'count'=>$counter

        ]);

    }

    function index(){

        return view('dashboards.employees.dashboard');

    }

    function userprofile(User $user,Request $req){

        $id = Auth::user()->id;

        if($req->method() == 'POST'){

            $password = $req->input('password');

            // in case of changed password
            if(isset($password) || trim($password) !== '') {

                $validated = $req->validate([
                    'password' => 'required|confirmed',
                ]);

            }

            $validated = $req->validate([
                'name'=>'required|string',
                'last_name'=>'required|string',
            ]);

            $data['name'] = $req->input('name');
            $data['last_name'] = $req->input('last_name');
            $data['email'] = $req->input('email');

            //in case that role and department_id is selected like in edit employee section
            if ($req->input('role') && $req->input('department_id')) {
                
                $data['role'] = $req->input('role');
                $data['department_id'] = $req->input('department_id');

            }

            if ($req->input('password')) {

                $data['password'] = Hash::make($req->input('password'));

            }

            $user->editUser($data, $id);

            return redirect('employee/userprofile');

        }

        $user = $user->userprofile($id);

        return view('dashboards.employees.userprofile',['user' => $user[0]]);

    }

    function applyvacation(Vacation $vacation, Request $req){

        if($req->method() == 'POST'){

            //converting input to date because input is type string
            $depart = date('Y-m-d', strtotime($req->input('depart')));
            $return = date('Y-m-d', strtotime($req->input('return')));

            $validated = $req->validate([
                'depart'=>'required',
                'return'=>'required',
            ]);

            $date = date("Y-m-d H:i:s");

            Vacation::create([
                'depart' => $depart,
                'return' => $return,
                'created_at' => $date,
                'updated_at' => $date,
                'status' => 0,
                'admin_read' => 0,
                'manager_read' => 0,
                'employee_notified' => 0,
                'user_id' => Auth::user()->id,
            ]);

            return redirect('employee/');
            
        }

        return view('dashboards.employees.applyvacation');

    }

    function historyvacations(Vacation $vacation){

        $user_id = Auth::user()->id;

        // because user is read all the notifications
        $data['employee_notified'] = 1;

        $vacation->historyVacations($data, $user_id);

        $vacation_datas = $vacation->showHistoryvacations($user_id);

        return view('dashboards.employees.historyvacations', ['vacation_datas' => $vacation_datas]);

    }

}