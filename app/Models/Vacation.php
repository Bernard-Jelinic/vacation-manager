<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // converting to better readible format for people
    private function convertVacationsDate($vacation_datas){

        foreach ($vacation_datas as $value) {
            $value->depart = date('d.m.Y', strtotime($value->depart));
            $value->return = date('d.m.Y', strtotime($value->return));
            $value->created_at = date('d.m.Y', strtotime($value->created_at));
        }

        return $vacation_datas;

    }

    public function editvacation($id){
        
        

    }

    public function setOneAdminRead($id){

        $this::where('id', '=', $id)
            ->update(['admin_read' => 1]);

    }
}
