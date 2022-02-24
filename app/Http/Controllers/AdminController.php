<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function fetchnotification(){

        $notifications = DB::table('vacations')
                ->select(DB::raw('vacations.id, vacations.created_at, users.name, users.last_name'))
                ->where('status', '=', 0)
                ->where('admin_read', '=', 0)
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

        return view('dashboards.admins.dashboard');

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

            $user->editUser($req, $id);

            return redirect('admin/userprofile');

        }

        $user = DB::table('users')
            ->select(DB::raw('name, last_name, email'))
            ->where('id', '=', $id)
            ->get();

        return view('dashboards.admins.userprofile',['user' => $user[0]]);

    }

    function adddepartment(Request $req, $type = '',$id = ''){

        if($req->method() == 'POST'){

            $validated = $req->validate([
                'name' => 'required|string'
            ]);

            $data['name'] = $req->input('name');

            DB::table('departments')->insert($data);

            // admin doesn't need to select manager
            if ($req->input('user_id')!= 'Select departments manager') {

                $user_id = $req->input('user_id');

                $department_id = DB::table('departments')
                        ->latest('id')
                        ->first();

                DB::table('users')->where('id', $user_id)->update(['department_id' => $department_id->id]);

            }

            return redirect('admin/managedepartments');

        }

        $managers = DB::table('users')
            ->select(DB::raw('id, name, last_name'))
            ->where('role', '=', 'manager')
            ->get();

        return view('dashboards.admins.adddepartment', ['managers'=>$managers]);

    }

    function managedepartments(){

        $departments = DB::table('departments')
                ->select(DB::raw('id, name'))
                ->get();

        $managers = DB::table('users')
                ->select(DB::raw('id, name, last_name, department_id'))
                ->where('role', '=', 'manager')
                ->get();

        $depart_manag = array();

        foreach ($departments as $department) {

            // to use array just comment first two line down
            $data = array();
            $data = (object) $data;

            $data->id = $department->id;
            // $data['id'] = $department->id;
            $data->department_name = $department->name;
            // $data['department_name'] = $department->name;

            $managers_full_name = "Department doesn't have manager";

            foreach ($managers as $manager) {

                if ($department->id == $manager->department_id) {
                    $managers_full_name = $manager->name . ' ' . $manager->last_name;
                }

                $data->manager_name = $managers_full_name;
                // $data['manager_name'] = $managers_full_name;
            }

            $depart_manag[] = $data;
        }

        return view('dashboards.admins.managedepartments', ['departments' => $depart_manag]);

    }

    function editdepartment(Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            $validated = $req->validate([
                'name' => 'required|string',
            ]);

            $data['name'] = $req->input('name');
            $data['updated_at'] = date("Y-m-d H:i:s");

            DB::table('departments')
                ->where('id',$id)
                ->update($data);

            // admin doesn't need to select manager
            if ($req->input('manager_id') != 'Select departments manager') {

                $manager_id = $req->input('manager_id');

                DB::table('users')->where('id', $manager_id)->update(['department_id' => $id]);

            }

            return redirect('admin/managedepartments');

        }

        $department = DB::table('departments')
                ->select('name')
                ->where('id', '=', $id)
                ->get();

        $managers = DB::table('users')
                ->select(DB::raw('id, name, last_name, department_id'))
                ->where('role', '=', 'manager')
                ->get();

        return view('dashboards.admins.editdepartment', ['department' => $department, 'managers' => $managers, 'department_id' => $id]);

    }

    function deletedepartment(Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            DB::table('departments')->delete($id);

            return redirect('admin/managedepartments');
            
        }

    }

    function addemployee(Department $department, Request $req){

        if($req->method() == 'POST'){

            $validated = $req->validate([
                'name'=>'required|alpha',
                'last_name'=>'required|alpha',
                'role'=>'required|alpha',
                'department_id'=>'required',
                'email'=>'required|email|unique:users',
                'password' => 'required|confirmed',
            ]);

            $date = date("Y-m-d H:i:s");

            User::create([
                'name' => $req->input('name'),
                'last_name' => $req->input('last_name'),
                'role' => $req->input('role'),
                'department_id' => $req->input('department_id'),
                'email' => $req->input('email'),
                'password' => Hash::make($req->input('password')),
                'created_at' => $date,
                'updated_at' => $date
            ]);

            return redirect('admin/manageemployee');

        }

        // it needs to display departments
        $departments = $department->getDepartment();

        return view('dashboards.admins.addemployee', ['departments' => $departments]);

    }

    function manageemployee(User $user){

        $employees = $user->manageemployee();

        return view('dashboards.admins.manageemployee', ['employees' => $employees]);

    }

    function editemployee(User $user, Department $department, Request $req){

        $id = $req->route()->id;
        
        if ($req->method() == "POST") {

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
                'role'=>'required|string',
                'department_id'=>'required|string',
            ]);

            $user->editUser($req, $id);

            return redirect('admin/manageemployee');

        }

        $employee = DB::table('departments')
            ->select(DB::raw('departments.id AS department_id, departments.name AS department_name, users.id, users.name, users.last_name, users.role, users.email'))
            ->where('users.id', '=', $id)
            ->join('users', 'departments.id', '=', 'users.department_id')
            ->get();

        // it needs to display departments
        $departments = $department->getDepartment();

        return view('dashboards.admins.editemployee', ['employee' => $employee,'departments' => $departments]);

    }

    function deleteemployee(User $user, Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            $user = User::find($id);
            $user->delete();

            return redirect('admin/manageemployee');
            
        }

   }

    function allvacations(Request $req){

        $data['admin_read'] = 1;

        DB::table('vacations')
            ->update($data);

        $vacation_datas = DB::table('vacations')
                    ->select(DB::raw(' vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name'))
                    ->join('users', 'vacations.user_id', '=', 'users.id')
                    ->get();

        // converting to better readible format for people
        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        // variable display is because I can only have one view
        return view('dashboards.admins.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'all']);

    }

    function pendingvacations(){

        $data['admin_read'] = 1;

        DB::table('vacations')
            ->where('status', '=',0)
            ->update($data);

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw(' vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name'))
            ->where('vacations.status', '=', 0)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->get();

        // converting to better readible format for people
        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        // variable display is because I can only have one view
        return view('dashboards.admins.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'pending']);

    }

    function approvedvacations(){

        $data['admin_read'] = 1;

        DB::table('vacations')
            ->where('status', '=',1)
            ->update($data);

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw(' vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name'))
            ->where('vacations.status', '=', 1)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->get();

        // converting to better readible format for people
        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        // variable display is because I can only have one view
        return view('dashboards.admins.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'approved']);

    }

    function notapprovedvacations(){

        $data['admin_read'] = 1;

        DB::table('vacations')
            ->where('status', '=',2)
            ->update($data);

        $vacation_datas = DB::table('vacations')
            ->select(DB::raw(' vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name'))
            ->where('vacations.status', '=', 2)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->get();

        // converting to better readible format for people
        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        // variable display is because I can only have one view
        return view('dashboards.admins.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'not approved']);

    }

    function editvacation(Request $req){

        $id = $req->route()->id;

        $data['admin_read'] = 1;

        DB::table('vacations')
            ->where('id',$id)
            ->update($data);

        if ($req->method()=="POST") {
            
            $validated = $req->validate([
                'status' => 'required|string',
            ]);

            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['status'] = $req->input('status');
            $data['admin_read'] = 1;
            $data['user_notified'] = 0;

            DB::table('vacations')
                ->where('id',$id)
                ->update($data);

            return redirect('admin/allvacations');

        }

        $vacation_data = DB::table('vacations')
                    ->select(DB::raw('vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name'))
                    ->join('users', 'vacations.user_id', '=', 'users.id')
                    ->where('vacations.id', '=', $id)
                    ->get();

        // converting to better readible format for people
        foreach ($vacation_data as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.admins.editvacation', ['vacation_data' => $vacation_data]);

    }

}
