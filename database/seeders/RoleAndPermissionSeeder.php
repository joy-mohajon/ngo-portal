<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Ngo;
use App\Models\Authority;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $adminRole = Role::create(['name' => 'admin']);
        $authorityRole = Role::create(['name' => 'authority']);
        $ngoRole = Role::create(['name' => 'ngo']);

        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        // Create authority user and profile
        $authorityUser = User::create([
            'name' => 'Authority User',
            'email' => 'authority@example.com',
            'password' => Hash::make('password'),
        ]);
        $authorityUser->assignRole('authority');

        Authority::create([
            'user_id' => $authorityUser->id,
            'name' => 'Authority User',
            'phone_number' => '1234567890',
            'email' => 'authority@example.com',
            'address' => '123 Authority Street',
        ]);

        // Create NGO user and profile
        $ngoUser = User::create([
            'name' => 'NGO User',
            'email' => 'ngo@example.com',
            'password' => Hash::make('password'),
        ]);
        $ngoUser->assignRole('ngo');

        Ngo::create([
            'user_id' => $ngoUser->id,
            'name' => 'Test NGO',
            'phone_number' => '0987654321',
            'email' => 'ngo@example.com',
            'location' => 'NGO Location',
            'is_approved' => false,
        ]);
    }
}