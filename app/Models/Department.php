<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    protected $fillable = [
        'name',
        'updated_at'
    ];

    public function getDepartment(){

        return $this::select('id', 'name')
            ->orderBy('id', 'DESC')
            ->get();

    }

    public function editDepartment($data, $id){

        $this::where('id', '=', $id)
            ->update($data);

    }

    public function getLatestDepartmentId(){

        return $this::latest('id')
                ->first();

    }

}
