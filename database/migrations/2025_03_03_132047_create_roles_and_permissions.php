<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->seedRolesAndUsers();
    }

    private function seedRolesAndUsers(): void
    {
        // Create roles
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'trainer']);
        Role::create(['name' => 'staff']);

        // Create users and assign roles
        $userAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        $userAdmin->assignRole('admin');

        $userTrainer = User::create([
            'name' => 'Trainer',
            'email' => 'trainer@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        $userTrainer->assignRole('trainer');

        $userStaff = User::create([
            'name' => 'Staff',
            'email' => 'staff@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
        ]);
        $userStaff->assignRole('staff');
    }
};
