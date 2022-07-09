<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles_arr = ['manager', 'employee'];

        User::factory()->create([
            'role' => 'admin',
            'department_id' => null
        ]);

        $departments = Department::all();

        foreach ($roles_arr as $role) {
            foreach ($departments as $department) {
                User::factory()->create(['role' => $role, 'department_id' => $department->id]);
            }

        };
    }
}
