<?php

namespace App\Http\Controllers;

use App\Models\User;
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

    function addemployee(Request $req){

    if($req->method() == 'POST'){

        $validated = $req->validate([
            'name'=>'required|alpha',
            'last_name'=>'required|alpha',
            'role'=>'required|alpha',
            'email'=>'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        $date = date("Y-m-d H:i:s");

        $department_id = NULL;

        // in case that employee type is manager it doesn't need to be saved
        if ($req->input('department_id')!=='Select department') {
            $department_id = $req->input('department_id');
        }

        User::create([
            'name' => $req->input('name'),
            'last_name' => $req->input('last_name'),
            'department_id' => $department_id,
            'role' => $req->input('role'),
            'email' => $req->input('email'),
            'password' => Hash::make($req->input('password')),
            'created_at' => $date,
            'updated_at' => $date,
        ]);

        return redirect('admin/manageemployee');

    }

    // in case that employee type is user it needs to display departments
    $query = "SELECT id, name FROM departments ORDER BY id DESC";

    $departments = DB::select($query);

    return view('dashboards.admins.addemployee', ['departments' => $departments]);

    }

    function manageemployee(){

        $users = DB::table('departments')
            ->select(DB::raw('departments.id AS department_id, departments.name AS department_name, users.id, users.name, users.last_name, users.role, users.email'))
            ->join('users', 'departments.id', '=', 'users.department_id')
            ->get();

        return view('dashboards.admins.manageemployee', ['users' => $users]);

    }

    function editemployee(Request $req){

        $id = $req->route()->id;
        
        if ($req->method() == "POST") {

            $email = $req->input('email');
            $password = $req->input('password');

            $date = date("Y-m-d H:i:s");

            $query = "SELECT email FROM users WHERE id={$id}";
            $user_email = DB::select($query);

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
                    'password'=>'required'
                ]);

                $data['password'] = Hash::make($req->input('password'));

            }

            $validated = $req->validate([
                'name'=>'required|string',
                'last_name'=>'required|string',
                'role'=>'required|string',
                'department_id'=>'required|string',
            ]);

            $data['name'] = $req->input('name');
            $data['last_name'] = $req->input('last_name');
            $data['role'] = $req->input('role');
            $data['department_id'] = $req->input('department_id');
            $data['updated_at'] = $date;

            DB::table('users')->where('id',$id)->update($data);

            return redirect('admin/manageemployee');

        }

        $employee = DB::table('departments')
            ->select(DB::raw('departments.id AS department_id, departments.name AS department_name, users.id, users.name, users.last_name, users.role, users.email'))
            ->where('users.id', '=', $id)
            ->join('users', 'departments.id', '=', 'users.department_id')
            ->get();

        $query_depart = "SELECT id, name FROM departments ORDER BY id DESC";

        $departments = DB::select($query_depart);

        return view('dashboards.admins.editemployee', ['employee' => $employee,'departments' => $departments]);

    }

    function deleteemployee(Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            DB::table('users')->delete($id);

            DB::table('vacations')
                ->where('user_id','=', $id)
                ->delete();

            return redirect('admin/manageemployee');
            
        }

   }

    function adddepartment(Request $req, $type = '',$id = ''){

        if($req->method() == 'POST'){

            $validated = $req->validate([
                'name' => 'required|string',
                'manager_id' => 'required|string',
            ]);

            $data['name'] = $req->input('name');
            $data['manager_id'] = $req->input('manager_id');

            DB::table('departments')->insert($data);

            return redirect('admin/managedepartments');

        }

        $query = "SELECT id,name FROM users WHERE role = 'manager' ORDER BY id DESC";

        $managers = DB::select($query);

        return view('dashboards.admins.adddepartment',[
            'managers' => $managers,
        ]);

   }

    function managedepartments(){

        $query = "SELECT departments.id AS department_id, departments.name AS department_name, departments.manager_id,users.name AS user_name, users.last_name FROM departments JOIN users ON departments.manager_id = users.id";

        $departments = DB::select($query);

        return view('dashboards.admins.managedepartments', ['departments' => $departments]);

    }

    function editdepartment(Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            $validated = $req->validate([
                'name' => 'required|string',
                'manager_id' => 'required|string',
            ]);

            $data['name'] = $req->input('name');
            $data['manager_id'] = $req->input('manager_id');
            $data['updated_at'] = date("Y-m-d H:i:s");

            DB::table('departments')
                ->where('id',$id)
                ->update($data);

            return redirect('admin/managedepartments');

        }

        $query = "SELECT departments.*,users.name AS user_name, users.last_name AS user_last_name, users.role AS user_role FROM departments JOIN users ON departments.manager_id = users.id WHERE departments.id ={$id}";

        $department = DB::select($query);

        $query_managers = "SELECT id, name, last_name FROM users WHERE role='manager'";

        $managers = DB::select($query_managers);

        return view('dashboards.admins.editdepartment', ['department' => $department, 'managers' => $managers]);

    }

    function deletedepartment(Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            DB::table('departments')->delete($id);

            return redirect('admin/managedepartments');
            
        }

    }

    function allvacations(Request $req){

        $data['admin_read'] = 1;

        DB::table('vacations')
            ->update($data);

        $query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id";
        $vacation_datas = DB::select($query);

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

        $query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id WHERE vacations.status = 0";
        $vacation_datas = DB::select($query);

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

        $query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id WHERE vacations.status = 1";
        $vacation_datas = DB::select($query);

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

        $query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id WHERE vacations.status = 2";
        $vacation_datas = DB::select($query);

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

            DB::table('vacations')
                ->where('id',$id)
                ->update($data);

            return redirect('admin/allvacations');

        }

        $query = "SELECT vacations.id, vacations.depart, vacations.return, vacations.created_at, vacations.status, vacations.user_id, users.name, users.last_name FROM vacations JOIN users ON vacations.user_id = users.id WHERE vacations.id = {$id}";

        $vacation_data = DB::select($query);

        // converting to better readible format for people
        foreach ($vacation_data as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return view('dashboards.admins.editvacation', ['vacation_data' => $vacation_data]);

    }

}
