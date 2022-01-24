<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Department;

use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        $user = new User();
        $user->insert([
            'name' => $req->input('name'),
            'last_name' => $req->input('last_name'),
            'role' => $req->input('role'),
            'email' => $req->input('email'),
            'password' => Hash::make($req->input('password')),
            'created_at' => $date,
            'updated_at' => $date
        ]);

    }
    return view('dashboards.admins.addemployee');
   }

   function manageemployee(){
       return view('dashboards.admins.manageemployee');
   }

    function adddepartment(Request $req, $type = '',$id = ''){

        if($req->method() == 'POST'){

            $department = new Department();

            $validated = $req->validate([

                'name' => 'required|string',
                'manager_id' => 'required|string',
            ]);

            $data['name'] = $req->input('name');
            $data['manager_id'] = $req->input('manager_id');

            $department->insert($data);

        }

            $query = "SELECT id,name FROM users WHERE role = 'manager' ORDER BY id DESC";
            // $query = "SELECT id,name FROM users ORDER BY id DESC";
            $managers = DB::select($query);

            return view('dashboards.admins.adddepartment',[
                'managers' => $managers,
            ]);
            //return view('dashboards.admins.adddepartment');
   }

   function managedepartments(){

        // $query = "SELECT * FROM departments ORDER BY id";
        // $query = "SELECT departments.*,users.name FROM departments JOIN users ON departments.manager_id = users.id ORDER BY id limit 1";
        $query = "SELECT departments.id AS department_id, departments.name AS department_name, departments.manager_id,users.name AS user_name, users.last_name FROM departments JOIN users ON departments.manager_id = users.id";
        // $query = "SELECT ";

        $departments = DB::select($query);

        //print_r($departments);

        return view('dashboards.admins.managedepartments', ['departments' => $departments]);
   }

   function editdepartment(Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            $department = new Department();

            $validated = $req->validate([

                'name' => 'required|string',
                'manager_id' => 'required|string',
            ]);

            $data['name'] = $req->input('name');
            $data['manager_id'] = $req->input('manager_id');
            $data['updated_at'] = date("Y-m-d H:i:s");

            $department->where('id',$id)->update($data);

            return redirect('admin/managedepartments');

        }

    //print_r($req->route()->id);

//"SELECT departments.id AS department_id, departments.name AS department_name, departments.manager_id,users.name AS user_name, users.last_name FROM departments JOIN users ON departments.manager_id = users.id";


    // $query = "SELECT * FROM departments WHERE id={$req->route()->id}";
    $query = "SELECT departments.*,users.name AS user_name, users.last_name AS user_last_name, users.role AS user_role FROM departments JOIN users ON departments.manager_id = users.id WHERE departments.id ={$id}";

    $department = DB::select($query);

    $query_managers = "SELECT id, name, last_name FROM users WHERE role='manager'";

    $managers = DB::select($query_managers);

    //print_r($department);

    //print_r($managers);

    //print_r($query);

    return view('dashboards.admins.editdepartment', ['department' => $department, 'managers' => $managers]);
    //return view('dashboards.admins.editdepartments');

   }

   function deletedepartment(Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            $department = new Department();

            $row = $department->find($id);

            $row->delete();

            return redirect('admin/managedepartments');
            
        }

        //return view('dashboards.admins.managedepartments');

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
//    function profile(){
//        return view('dashboards.admins.profile');
//    }
//    function settings(){
//        return view('dashboards.admins.settings');
//    }
}
