<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vacation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{

    function fetchnotification(User $user, Vacation $vacation){

        $manager_id = Auth::user()->id;

        $department_id = $user->getDepartmentId($manager_id);

        $notifications = $vacation->managerFetchnotification($manager_id, $department_id);

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

    function userprofile(User $user, Request $req){

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

            return redirect('manager/userprofile');

        }

        $user = $user->userprofile($id);

        return view('dashboards.managers.userprofile',['user' => $user[0]]);

    }

    function allvacations(User $user, Vacation $vacation){

        $manager_id = Auth::user()->id;

        $display = 'all';

        $department_id = $user->getDepartmentId($manager_id);

        $vacation_datas = $vacation->getManagerVacations($department_id, $display);

        $manager_ids = array();

        foreach ($vacation_datas as $value) {
            $manager_ids[] = $value->id;
        }

        $data['manager_read'] = 1;

        // writing all managers employee vacations as manager_read
        foreach ($manager_ids as $id) {
            $vacation->editVacation($data, $id);
        }

        // variable display is so I can only have one view
        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => $display]);

    }

    function pendingvacations(User $user, Vacation $vacation){

        $manager_id = Auth::user()->id;

        $display = 'pending';

        $department_id = $user->getDepartmentId($manager_id);


        $vacation_datas = $vacation->getManagerVacations($department_id, $display);

        $manager_ids = array();

        foreach ($vacation_datas as $value) {
            $manager_ids[] = $value->id;
        }

        $data['manager_read'] = 1;

        // writing all managers employee vacations as manager_read
        foreach ($manager_ids as $id) {
            $vacation->editVacation($data, $id);
        }

        // variable display is because I can only have one view
        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => 'pending']);

    }

    function approvedvacations(User $user, Vacation $vacation){

        $manager_id = Auth::user()->id;

        $display = 'approved';

        $department_id = $user->getDepartmentId($manager_id);

        $vacation_datas = $vacation->getManagerVacations($department_id, $display);

        $manager_ids = array();

        foreach ($vacation_datas as $value) {
            $manager_ids[] = $value->id;
        }

        $data['manager_read'] = 1;

        // writing all managers employee vacations as manager_read
        foreach ($manager_ids as $id) {
            $vacation->editVacation($data, $id);
        }

        // variable display is because I can only have one view
        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => $display]);

    }

    function notapprovedvacations(User $user, Vacation $vacation){

        $manager_id = Auth::user()->id;

        $display = 'notapproved';

        $department_id = $user->getDepartmentId($manager_id);


        $vacation_datas = $vacation->getManagerVacations($department_id, $display);

        $manager_ids = array();

        foreach ($vacation_datas as $value) {
            $manager_ids[] = $value->id;
        }

        $data['manager_read'] = 1;

        // writing all managers employee vacations as manager_read
        foreach ($manager_ids as $id) {
            $vacation->editVacation($data, $id);
        }

        // variable display is because I can only have one view
        return view('dashboards.managers.allvacations', ['vacation_datas' => $vacation_datas, 'display' => $display]);

    }

    function editvacation(Vacation $vacation, Request $req){

        $id = $req->route()->id;

        $vacation_data['manager_read'] = 1;

        $vacation->editVacation($vacation_data, $id);

        if ($req->method()=="POST") {
            
            $validated = $req->validate([
                'status' => 'required|string',
            ]);

            $data['updated_at'] = date("Y-m-d H:i:s");
            $data['status'] = $req->input('status');
            $data['manager_read'] = 1;
            $data['employee_notified'] = 0;

            $vacation->editVacation($data, $id);

            return redirect('manager/allvacations');

        }

        $vacation_data = $vacation->showEditVacation($id);

        return view('dashboards.managers.editvacation', ['vacation_data' => $vacation_data]);

    }
}
