<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Ngo;
use App\Models\Authority;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // Create roles if they don't exist
            $roles = ['admin', 'authority', 'ngo'];
            foreach ($roles as $roleName) {
                if (!Role::where('name', $roleName)->exists()) {
                    Role::create(['name' => $roleName]);
                    Log::info("Created role: {$roleName}");
                } else {
                    Log::info("Role already exists: {$roleName}");
                }
            }

            // Create admin user
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
            $admin->assignRole('admin');
            Log::info("Created admin user: admin@example.com");

            // Create authority user and profile
            $authorityUser = User::create([
                'name' => 'Joy',
                'email' => 'authority@example.com',
                'password' => Hash::make('password'),
            ]);
            $authorityUser->assignRole('authority');
            Log::info("Created authority user: authority@example.com");

            Authority::create([
                'user_id' => $authorityUser->id,
                'name' => 'Bangladesh NGO Affairs Bureau',
                'phone_number' => '+880-2-9558343',
                'email' => 'authority@example.com',
                'address' => 'NGO Affairs Bureau, Agargaon, Dhaka-1207, Bangladesh',
            ]);
            Log::info("Created authority profile for: authority@example.com");


            $ngoUser = User::create([
                'name' => 'NGO User',
                'email' => 'ngo@example.com',
                'password' => Hash::make('password'),
            ]);
            $ngoUser->assignRole('ngo');
    
            Ngo::create([
                'user_id' => $ngoUser->id,
                'name' => $ngoUser->name,
                'registration_id' => "NGO-111111",
                // 'phone_number' => '0987654321',
                'email' => $ngoUser->email,
                'location' => 'NGO Location',
            ]);
            
            Log::info("UserSeeder completed successfully");
        } catch (\Exception $e) {
            Log::error("Error in UserSeeder: " . $e->getMessage());
            throw $e;
        }
    }
}