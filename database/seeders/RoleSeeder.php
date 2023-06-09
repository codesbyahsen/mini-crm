<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = array(
            [
                'name' => 'admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'sub-admin',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'company',
                'guard_name' => 'company',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'employee',
                'guard_name' => 'employee',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        DB::table('roles')->insert($roles);
    }
}
