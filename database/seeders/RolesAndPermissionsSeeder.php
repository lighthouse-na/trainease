<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $trainer = Role::create(['name' => 'trainer']);
        $staff = Role::create(['name' => 'staff']);

        // Define permissions
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'create training']);
        Permission::create(['name' => 'enroll in training']);
        Permission::create(['name' => 'approve enrollments']);
        Permission::create(['name' => 'generate certificates']);

        // Assign permissions to roles
        $admin->givePermissionTo(['manage users', 'create training', 'approve enrollments', 'generate certificates']);
        $trainer->givePermissionTo(['create training', 'approve enrollments']);
        $staff->givePermissionTo(['enroll in training']);

        $userAdmin = User::create([
            'name' => 'Admin',

            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),

        ]);

        $userTrainer = User::create([
            'name' => 'Trainer',

            'email' => 'trainer@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),

        ]);

        $userStaff = User::create([
            'name' => 'Staff',

            'email' => 'staff@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),

        ]);

        // Assign roles to users
        $userAdmin->assignRole('admin');
        $userTrainer->assignRole('trainer');
        $userStaff->assignRole('staff');

        $this->command->info('Roles and users seeded successfully!');

        // Assign Admin role to the first user (example)
        $user = \App\Models\User::find(1);
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
