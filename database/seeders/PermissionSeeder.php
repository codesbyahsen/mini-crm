<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = array(
            [
                'name' => 'Company Read',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company Add',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company Edit',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Company Delete',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Employee Read',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Employee Add',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Employee Edit',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Employee Delete',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],

            [
                'name' => 'Project Read',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Project Add',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Project Edit',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Project Delete',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }
    }
}
