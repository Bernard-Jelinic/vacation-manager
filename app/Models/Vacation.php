<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Scopes\VacationScope;

class Vacation extends Model
{
    use HasFactory;

    protected $table = 'vacations';

    protected $fillable = [
        'depart',
        'return',
        'created_at',
        'updated_at',
        'status',
        'admin_read',
        'manager_read',
        'user_notified',
        'user_id'
    ];

    // public static function booted()
    // {
    //     static::addGlobalScope(new VacationScope);
    // }

    public function adminFetchnotification(){

        $datas =  $this::select('vacations.id', 'vacations.created_at', 'users.name', 'users.last_name')
        ->where('status', '=', 0)
        ->where('admin_read', '=', 0)
        ->join('users', 'vacations.user_id', '=', 'users.id')
        ->get();

        return $this->convertVacationsDate($datas);

    }

    public function managerFetchnotification($manager_id, $department_id){

        $datas = $this::select('vacations.id', 'vacations.created_at', 'users.name', 'users.last_name', 'users.department_id')
            ->where('department_id', '=', $department_id)
            ->where('vacations.status', '=', 0)
            ->where('vacations.manager_read', '=', 0)
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->get();

        return $this->convertVacationsDate($datas);

    }

    public function userFetchnotification($id){

        $datas = $this::select('vacations.id', 'vacations.created_at', 'users.name', 'users.last_name')
                ->where('status', '!=', 0)
                ->where('user_notified', '=', 0)
                ->where('user_id', '=', $id)
                ->join('users', 'vacations.user_id', '=', 'users.id')
                ->get();

        return $this->convertVacationsDate($datas);

    }

    public function getAdminVacations($status){
        
        if ($status == 'all') {

            $this::query()
                ->update(['admin_read' => 1]);

            $vacation_datas = $this::select('vacations.id', 'vacations.depart', 'vacations.return', 'vacations.created_at', 'vacations.status', 'vacations.user_id', 'users.name', 'users.last_name')
                ->join('users', 'vacations.user_id', '=', 'users.id')
                ->get();

        }
        else{

            if ($status == 'pending') {
                
                $get_status = 0;

            }elseif($status == 'approved'){

                $get_status = 1;

            }elseif($status == 'notapproved'){

                $get_status = 2;

            }

            $this::where('status', '=', $get_status)
                ->update(['admin_read' => 1]);
            
            $vacation_datas = $this::select('vacations.id', 'vacations.depart', 'vacations.return', 'vacations.created_at', 'vacations.status', 'vacations.user_id', 'users.name', 'users.last_name')
                ->join('users', 'vacations.user_id', '=', 'users.id')
                ->where('vacations.status', '=', $get_status)
                ->get();

        }

        $vacation_datas = $this->convertVacationsDate($vacation_datas);

        return $vacation_datas;

    }

    public function getManagerVacations($department_id, $status){
        
        if ($status == 'all') {

            $vacation_datas = $this::select('vacations.id', 'vacations.depart', 'vacations.return', 'vacations.created_at', 'vacations.user_notified', 'vacations.status', 'users.name', 'users.last_name')
                ->where('department_id', '=', $department_id)
                ->where('role', '=', 'user')
                ->join('users', 'vacations.user_id', '=', 'users.id')
                ->get();

        }else{

            if ($status == 'pending') {
                
                $get_status = 0;

            }elseif($status == 'approved'){

                $get_status = 1;

            }elseif($status == 'notapproved'){

                $get_status = 2;

            }

            $vacation_datas = $this::select('vacations.id', 'vacations.depart', 'vacations.return', 'vacations.created_at', 'vacations.user_notified', 'vacations.status', 'users.name', 'users.last_name')
                ->where('department_id', '=', $department_id)
                ->where('role', '=', 'user')
                ->where('vacations.status', '=', $get_status)
                ->join('users', 'vacations.user_id', '=', 'users.id')
                ->get();

        }

        $vacation_datas = $this->convertVacationsDate($vacation_datas);

        return $vacation_datas;

    }

    // converting to better readible format for people
    private function convertVacationsDate($vacation_datas){

        foreach ($vacation_datas as $vacation_data) {

            if ($vacation_data->depart) {
                $vacation_data->depart = date('d.m.Y', strtotime($vacation_data->depart));
            }
            if ($vacation_data->return) {
                $vacation_data->return = date('d.m.Y', strtotime($vacation_data->return));
            }
            if ($vacation_data->created_at) {
                $created_at = $vacation_data->created_at->format('d.m.Y');
                unset($vacation_data->created_at);
                $vacation_data->formated_created_at = $created_at;
            }

        }
        
        return $vacation_datas;

    }

    public function editVacation($data, $id){

        $this::where('id', '=', $id)
            ->update($data);

    }

    public function showEditVacation($id){

        $vacation_datas = $this::select('vacations.id', 'vacations.depart', 'vacations.return', 'vacations.created_at', 'vacations.status', 'vacations.user_id', 'users.name', 'users.last_name')
            ->join('users', 'vacations.user_id', '=', 'users.id')
            ->where('vacations.id', '=', $id)
            ->get();

        return $this->convertVacationsDate($vacation_datas);

    }

    public function showHistoryvacations($user_id){

        $vacation_datas = $this::select('vacations.id', 'vacations.depart', 'vacations.return', 'vacations.created_at', 'vacations.status')
            ->where('user_id', '=', $user_id)
            ->get();

        return $this->convertVacationsDate($vacation_datas);

    }

    public function historyVacations($data, $user_id){

        $this::where('user_id', '=', $user_id)
            ->update($data);

    }

}
