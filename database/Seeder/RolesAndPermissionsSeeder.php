<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

       
        $viewUsers          = Permission::firstOrCreate(['name' => 'view_users']);
        $editUsers          = Permission::firstOrCreate(['name' => 'edit_users']);
        $deleteUsers        = Permission::firstOrCreate(['name' => 'delete_users']);
        $changeAnyPassword  = Permission::firstOrCreate(['name' => 'change_any_password']);
        $editNameOnly       = Permission::firstOrCreate(['name' => 'edit_user_name_only']);

        
        $manageQuizzes = Permission::firstOrCreate(['name' => 'manage_quizzes']);
        $gradeQuizzes  = Permission::firstOrCreate(['name' => 'grade_quizzes']);
        $solveQuizzes  = Permission::firstOrCreate(['name' => 'solve_quizzes']);

       
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo([
            $viewUsers,
            $editUsers,
            $deleteUsers,
            $changeAnyPassword,
            $editNameOnly,
            $manageQuizzes,
            $gradeQuizzes,
            $solveQuizzes,
        ]);

        $employee = Role::firstOrCreate(['name' => 'employee']);
        $employee->givePermissionTo([
            $viewUsers,
            $editNameOnly,
        ]);

        $userRole = Role::firstOrCreate(['name' => 'user']);

        $instructor = Role::firstOrCreate(['name' => 'instructor']);
        $instructor->givePermissionTo([
            $manageQuizzes,
            $gradeQuizzes,
        ]);

        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo([
            $solveQuizzes,
        ]);

        
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Main Admin',
                'password' => Hash::make('Password123!'), 
            ]
        );
        $adminUser->assignRole($admin);

        
    }
}
