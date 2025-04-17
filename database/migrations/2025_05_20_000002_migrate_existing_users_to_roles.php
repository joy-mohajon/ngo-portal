<?php

use App\Models\User;
use App\Models\Ngo;
use App\Models\Authority;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Get all existing users
        $users = User::all();

        foreach ($users as $user) {
            // Check if user has an NGO profile
            if ($user->ngo()->exists()) {
                $ngo = $user->ngo;
                
                // Assign the ngo role to the user
                $user->assignRole('ngo');
                
                // Generate a registration ID if it's empty (using user_id + random string)
                if (empty($ngo->registration_id)) {
                    $ngo->registration_id = 'NGO-' . $user->id . '-' . substr(md5(uniqid()), 0, 8);
                }
                
                $ngo->save();
            }
            
            // Check if user has an Authority profile
            if ($user->authority()->exists()) {
                // Assign the authority role to the user
                $user->assignRole('authority');
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not reversible
    }
}; 