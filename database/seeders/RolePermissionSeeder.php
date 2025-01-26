<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat role
        $adminRole = Role::create(['name' => 'admin']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $employeeRole = Role::create(['name' => 'employee']);

        // Buat user untuk admin
        $useradmin = User::create([
            'name' => 'admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'occupation' => 'Administrator',
            'avatar' => 'images/default-avatar.png',

        ]);
        $useradmin->assignRole($adminRole);

        // Buat user untuk Teacher
        $userTeacher = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'occupation' => 'Instructor',
            'avatar' => 'images/default-avatar.png',

        ]);
        $userTeacher->assignRole($teacherRole);

        $userEmployee = User::create([
            'name' => 'Employee User',
            'email' => 'employee@example.com',
            'password' => Hash::make('password'),
            'occupation' => 'Staff',
            'avatar' => 'images/default-avatar.png',
            'nik' => '9876543210',
            'gender' => 'female',
            'date_of_birth' => '1985-05-15',
            'address' => 'Jl. Contoh No. 456',
            'phone_number' => '081298765432',
            'division' => 'HR',
            'position' => 'HR Manager',
            'employment_status' => 'Permanent',
            'join_date' => '2020-01-01',
            'is_active' => true,
        ]);
        $userEmployee->assignRole($employeeRole);
    }
}
