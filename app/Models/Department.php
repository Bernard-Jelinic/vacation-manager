<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\DB;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';

    // protected $fillable = [
    //     'id',
    //     'name',
    //     'updated_at'
    // ];

    protected $fillable = [
    //     'id',
        'name',
        'updated_at'
    ];

    public function getDepartment(){

        return $this::select('id', 'name')
            ->orderBy('id', 'DESC')
            ->get();

    }

}
