<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Department;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    function fetchnotification(Vacation $vacation){

        $notifications = $vacation->adminFetchnotification();

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

            return redirect('admin/userprofile');

        }

        $user = $user->userprofile($id);

        return view('dashboards.admins.userprofile',['user' => $user[0]]);

    }

    function adddepartment(User $user, Department $department, Request $req){

        if($req->method() == 'POST'){

            $validated = $req->validate([
                'name' => 'required|string'
            ]);

            $data['name'] = $req->input('name');

            Department::create([
                'name' => $req->input('name'),
            ]);

            // admin doesn't need to select manager
            if ($req->input('user_id')!= 'Select departments manager') {

                $user_id = $req->input('user_id');

                // // $department_id = DB::table('departments')
                // //         ->latest('id')
                // //         ->first();

                $department_id = $department->getLatestDepartmentId();

                // $data['department_id'] = $department_id->id;

                // $user->editUser($data, $user_id);

                DB::table('users')->where('id', $user_id)->update(['department_id' => $department_id->id]);

            }

            return redirect('admin/managedepartments');

        }

        $managers = $user->addDepartment();

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

    function editdepartment(Department $department, Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            $validated = $req->validate([
                'name' => 'required|string',
            ]);

            $data['name'] = $req->input('name');
            $data['updated_at'] = date("Y-m-d H:i:s");

            $department->editDepartment($data, $id);

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

    function deletedepartment(Department $department, Request $req){

        $id = $req->route()->id;

        if($req->method() == 'POST'){

            $department = Department::find($id);
            $department->delete();

            return redirect('admin/managedepartments');
            
        }

    }

    function addemployee(Department $department, Request $req){

        if($req->method() == 'POST'){

            $validated = $req->validate([
                'name'=>'required|alpha',
                'last_name'=>'required|alpha',
                'role'=>'required|alpha',
                'department_id'=>'required|numeric',
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

            return redirect('admin/manageemployee');

        }

        $employee = $user->showEditUser($id);

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

    function allvacations(Vacation $vacation){

        $display = 'all';

        $vacation_datas = $vacation->getAdminVacations($display);

        // variable display is because I can only have one view
        return view('dashboards.admins.allvacations', ['vacation_datas' => $vacation_datas, 'display' => $display]);

    }

    function pendingvacations(Vacation $vacation){

        $display = 'pending';

        $vacation_datas = $vacation->getAdminVacations($display);

        // variable display is because I can only have one view
        return view('dashboards.admins.allvacations', ['vacation_datas' => $vacation_datas, 'display' => $display]);

    }

    function approvedvacations(Vacation $vacation){

        $display = 'approved';

        $vacation_datas = $vacation->getAdminVacations($display);

        // variable display is because I can only have one view
        return view('dashboards.admins.allvacations', ['vacation_datas' => $vacation_datas, 'display' => $display]);

    }

    function notapprovedvacations(Vacation $vacation){

        $display = 'notapproved';

        $vacation_datas = $vacation->getAdminVacations($display);

        // variable display is because I can only have one view
        return view('dashboards.admins.allvacations', ['vacation_datas' => $vacation_datas, 'display' => $display]);

    }

    function editvacation(Vacation $vacation, Request $req){

        $id = $req->route()->id;

        $vacation_data['admin_read'] = 1;

        $vacation->editVacation($vacation_data, $id);

        if ($req->method()=="POST") {
            
            $validated = $req->validate([
                'status' => 'required|string',
            ]);

            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['status'] = $req->input('status');
            $data['admin_read'] = 1;
            $data['user_notified'] = 0;

            $vacation->editVacation($data, $id);

            return redirect('admin/allvacations');

        }

        $vacation_data = $vacation->showEditVacation($id);

        return view('dashboards.admins.editvacation', ['vacation_data' => $vacation_data]);

    }

}
