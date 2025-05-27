<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // Make sure we have at least one user for holders and runners
            if (User::count() == 0) {
                Log::warning('No users found. Please run UserSeeder first.');
                return;
            }
            
            // Create 25 projects with different statuses
            $exampleActivities = [
                'Farmer training on sustainable agriculture practices',
                'Installation of improved irrigation systems',
                'Distribution of high-yield crop varieties',
                'Soil health management programs',
                'Establishment of farmer cooperatives',
            ];
            Project::factory()->count(2)->active()->create([
                'major_activities' => $exampleActivities
            ]);
            Project::factory()->count(1)->completed()->create([
                'major_activities' => $exampleActivities
            ]);
            //Project::factory()->count(1)->pending()->create();
            //Project::factory()->count(1)->suspended()->create();
            
            // Get all projects
            $projects = Project::all();
            
            // Create trainings for each project
            foreach ($projects as $project) {
                // Create 2-4 trainings per project
                Training::factory()
                    ->count(rand(2, 4))
                    ->forProject($project->id)
                    ->create();
            }
            
            Log::info('Created ' . $projects->count() . ' projects with trainings for API testing');
        } catch (\Exception $e) {
            Log::error('Error seeding projects: ' . $e->getMessage());
            throw $e;
        }
    }
}
