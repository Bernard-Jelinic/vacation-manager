<?php

namespace Database\Seeders;

use App\Models\User;
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
        User::factory()->create([
            'name' => 'Stjepan',
            'last_name' => 'Stjepić',
            'role' => 'admin',
            'department_id' => null,
            'email' => 'stjepan@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('stjepan'),
        ]);

        User::factory()->create([
            'name' => 'Bernard',
            'last_name' => 'Jelinić',
            'role' => 'user',
            'department_id' => 2,
            'email' => 'bernard@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('bernard'),
        ]);

        User::factory()->create([
            'name' => 'Matea',
            'last_name' => 'Mokricki',
            'role' => 'user',
            'department_id' => 3,
            'email' => 'matea@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('matea'),
        ]);

        User::factory()->create([
            'name' => 'Ivan',
            'last_name' => 'Jelinić',
            'role' => 'user',
            'department_id' => 1,
            'email' => 'ivan@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('ivan'),
        ]);

        User::factory()->create([
            'name' => 'Josip',
            'last_name' => 'Josipović',
            'role' => 'manager',
            'department_id' => 1,
            'email' => 'josip@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('josip'),
        ]);

        User::factory()->create([
            'name' => 'Pero',
            'last_name' => 'Perić',
            'role' => 'manager',
            'department_id' => 2,
            'email' => 'pero@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('pero'),
        ]);

        User::factory()->create([
            'name' => 'Ivo',
            'last_name' => 'Ivić',
            'role' => 'manager',
            'department_id' => 3,
            'email' => 'ivo@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('ivo'),
        ]);

        User::factory()->create([
            'name' => 'Josipa',
            'last_name' => 'Jelinić',
            'role' => 'user',
            'department_id' => 1,
            'email' => 'josipa@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('josipa'),
        ]);

        User::factory()->create([
            'name' => 'Miroslav',
            'last_name' => 'Jelinić',
            'role' => 'user',
            'department_id' => 2,
            'email' => 'miroslav@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('miroslav'),
        ]);

        User::factory()->create([
            'name' => 'Olivera',
            'last_name' => 'Jelinić',
            'role' => 'user',
            'department_id' => 3,
            'email' => 'olivera@gmail.com',
            'email_verified_at' => null,
            'password' => Hash::make('olivera'),
        ]);
    }
}
