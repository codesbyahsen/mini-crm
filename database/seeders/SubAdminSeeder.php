<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class SubAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Daisy',
            'last_name' => 'Smith',
            'display_name' => 'Smith',
            'email' => 'sub-admin@admin.com',
            'email_verified_at' => now(),
            'phone' => '03123456789',
            'gender' => 'Male',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);

        $roleSubAdmin = Role::where('name', 'sub-admin')->first();
        $user->assignRole($roleSubAdmin);
        $roleSubAdmin->givePermissionTo(['View Employee', 'Create Employee', 'Delete Employee']);
    }
}
