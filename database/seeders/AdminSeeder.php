<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'first_name' => 'Dario',
            'last_name' => 'Towne',
            'display_name' => 'Dario',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'phone' => '03001234567',
            'gender' => 'Male',
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ]);

        $roleAdmin = Role::where('name', 'admin')->first();
        $user->assignRole($roleAdmin);
        $roleAdmin->givePermissionTo(Permission::all());
    }
}
