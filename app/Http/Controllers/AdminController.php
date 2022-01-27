<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
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
            'password'=>'required'
        ]);

        $date = date("Y-m-d H:i:s");

        $data = [
            'name' => $req->input('name'),
            'last_name' => $req->input('last_name'),
            'role' => $req->input('role'),
            'email' => $req->input('email'),
            'password' => Hash::make($req->input('password')),
            'created_at' => $date,
            'updated_at' => $date
        ];

        DB::table('users')->insert($data);

        return redirect('admin/manageemployee');

    }

    return view('dashboards.admins.addemployee');

    }

    function manageemployee(){

        $query = "SELECT id, name, last_name, role, email FROM users ORDER BY id";

        $users = DB::select($query);

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
                // 'email'=>'required|email|unique:users',
                // 'password'=>'required'
            ]);

            $data['name'] = $req->input('name');
            $data['last_name'] = $req->input('last_name');
            $data['role'] = $req->input('role');
            // $data['email'] = $req->input('email');
            // $data['password'] = Hash::make($req->input('password'));
            $data['updated_at'] = $date;

            DB::table('users')->where('id',$id)->update($data);

            return redirect('admin/manageemployee');

        }

        $query = "SELECT id, name, last_name, role, email FROM users WHERE id ={$id}";

        $employee = DB::select($query);

        return view('dashboards.admins.editemployee', ['employee' => $employee]);

    }

    function deleteemployee(Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            DB::table('users')->delete($id);

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

   function allvacations(){
       return view('dashboards.admins.allvacations');
   }
   function pendingvacations(){
       return view('dashboards.admins.pendingvacations');
   }
   function approvedvacations(){
       return view('dashboards.admins.approvedvacations');
   }
   function notapprovedvacations(){
       return view('dashboards.admins.notapprovedvacations');
   }
}
