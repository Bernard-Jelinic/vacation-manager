<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Department;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'last_name',
        'role',
        'department_id',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    function manageemployee(){

        return $this::select('departments.id AS department_id' , 'departments.name AS department_name', 'users.id', 'users.name', 'users.last_name', 'users.role', 'users.email')
            ->join('departments', 'departments.id', '=', 'users.department_id')
            ->get();

    }

    function editUser($data, $id){

        $this::where('id', '=', $id)
            ->update($data);

    }

    function showEditUser($id){

        return $this::select('departments.id AS department_id', 'departments.name AS department_name', 'users.id', 'users.name', 'users.last_name', 'users.role', 'users.email')
            ->where('users.id', '=', $id)
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->get();

    }

    function userprofile($id){

        return $this::select('name', 'last_name', 'email')
            ->where('id', '=', $id)
            ->get();

    }

    function addDepartment(){

        return $this::select('id', 'name', 'last_name')
            ->where('role', '=', 'manager')
            ->get();

    }

    function getDepartmentId($id){

        $department_id = $this::select('department_id')
            ->where('id', '=', $id)
            ->get();

        //because if I return raw $department_id it is an array
        return $department_id = $department_id[0]->department_id;

    }

    public function manageEditDepartments(){

        return $this::select('id', 'name', 'last_name', 'department_id')
            ->where('role', '=', 'manager')
            ->get();

    }
}
