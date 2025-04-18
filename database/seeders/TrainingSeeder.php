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
            // Get all projects
            $projects = Project::all();
            
            if ($projects->isEmpty()) {
                Log::warning('No projects found. Please run ProjectSeeder first.');
                return;
            }
            
            // Create 50 trainings distributed across projects
            $totalTrainings = 50;
            $createdTrainings = 0;
            
            // First, create at least 2 trainings for each project
            foreach ($projects as $project) {
                $count = min(2, $totalTrainings - $createdTrainings);
                if ($count <= 0) break;
                
                Training::factory()
                    ->count($count)
                    ->forProject($project->id)
                    ->create();
                
                $createdTrainings += $count;
                Log::info("Created {$count} trainings for project ID: {$project->id}");
            }
            
            // Then, distribute the remaining trainings randomly
            $remainingTrainings = $totalTrainings - $createdTrainings;
            if ($remainingTrainings > 0) {
                for ($i = 0; $i < $remainingTrainings; $i++) {
                    $project = $projects->random();
                    
                    Training::factory()
                        ->forProject($project->id)
                        ->create();
                    
                    $createdTrainings++;
                }
                
                Log::info("Created {$remainingTrainings} additional trainings distributed randomly");
            }
            
            Log::info("Training seeding completed successfully. Total trainings created: {$createdTrainings}");
        } catch (\Exception $e) {
            Log::error('Error seeding trainings: ' . $e->getMessage());
            throw $e;
        }
    }
}