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
                'name' => 'read companies',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'edit companies',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'delete companies',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'read employees',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'edit employees',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'delete employees',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'read projects',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'edit projects',
                'guard' => 'web',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'delete projects',
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
