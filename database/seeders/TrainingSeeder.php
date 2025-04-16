<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // Get all projects or create one if none exist
            $projects = Project::all();
            
            if ($projects->isEmpty()) {
                // No projects exist, let's create one
                if (User::count() == 0) {
                    // Create a test user if none exists
                    $user = User::factory()->create([
                        'name' => 'Test User',
                        'email' => 'test@example.com',
                        'password' => bcrypt('password'),
                    ]);
                } else {
                    $user = User::first();
                }
                
                // Create a test project
                $project = Project::create([
                    'title' => 'Test Project',
                    'description' => 'This is a test project for training seeding',
                    'location' => 'Test Location',
                    'budget' => 10000,
                    'focus_area' => 'Education',
                    'holder_id' => $user->id,
                    'runner_id' => $user->id,
                    'start_date' => now(),
                    'end_date' => now()->addMonths(6),
                    'status' => 'active',
                ]);
                
                $projects = collect([$project]);
            }
            
            // Create trainings for each project
            foreach ($projects as $project) {
                // Create 3-5 trainings per project
                $count = rand(3, 5);
                Training::factory()
                    ->count($count)
                    ->forProject($project->id)
                    ->create();
                
                Log::info("Created {$count} trainings for project ID: {$project->id}");
            }
            
            Log::info('Training seeding completed successfully');
        } catch (\Exception $e) {
            Log::error('Error seeding trainings: ' . $e->getMessage());
        }
    }
}
