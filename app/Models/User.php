<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;

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

    function editUser($req, $id){

        $user = $this::find($id);

        $user->name = $req->input('name');
        $user->last_name = $req->input('last_name');
        $user->email = $req->input('email');

        //in case that role and department_id is selected like in edit employee section
        if ($req->input('role') && $req->input('department_id')) {
            
            $user->role = $req->input('role');
            $user->department_id = $req->input('department_id');

        }

        if ($req->input('password')) {

            $user->password = Hash::make($req->input('password'));

        }

        $user->save();

    }
}
