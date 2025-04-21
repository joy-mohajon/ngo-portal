<?php

namespace Database\Seeders;

use App\Models\{Ngo, Project, Training, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProjectTrainingSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            // ASA Projects
            [
                'ngo_id' => 1, // ASA
                'title' => 'Digital Financial Inclusion',
                'description' => 'Promoting mobile banking services in rural communities',
                'location' => 'Nationwide',
                'budget' => 2500000,
                'focus_area' => 'Financial Inclusion',
                'start_date' => Carbon::parse('2023-01-01'),
                'end_date' => Carbon::parse('2024-12-31'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Mobile banking & digital transaction safety',
                        'description' => 'Training on BKash/Nagad apps and online accounting',
                        'location' => 'Dhaka',
                        'start_date' => Carbon::parse('2023-03-15'),
                        'end_date' => Carbon::parse('2023-04-15'),
                        'capacity' => 50,
                        'registration_deadline' => Carbon::parse('2023-03-01'),
                        'category' => 'Financial Literacy',
                        'status' => 'completed'
                    ]
                ]
            ],
            // BRAC Projects
            [
                'ngo_id' => 2, // BRAC
                'title' => 'Skills Development for Youth',
                'description' => 'Providing IT and vocational training to young adults',
                'location' => 'Urban Areas',
                'budget' => 3500000,
                'focus_area' => 'Education',
                'start_date' => Carbon::parse('2023-02-01'),
                'end_date' => Carbon::parse('2024-06-30'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Basic IT (6 weeks)',
                        'description' => 'Fundamental computer skills training',
                        'location' => 'Dhaka',
                        'start_date' => Carbon::parse('2023-03-01'),
                        'end_date' => Carbon::parse('2023-04-15'),
                        'capacity' => 30,
                        'registration_deadline' => Carbon::parse('2023-02-20'),
                        'category' => 'Skills Development',
                        'status' => 'completed'
                    ],
                    [
                        'title' => 'Graphic design, freelancing (3-6 months)',
                        'description' => 'Advanced digital skills training',
                        'location' => 'Dhaka',
                        'start_date' => Carbon::parse('2023-05-01'),
                        'end_date' => Carbon::parse('2023-10-31'),
                        'capacity' => 20,
                        'registration_deadline' => Carbon::parse('2023-04-15'),
                        'category' => 'Vocational',
                        'status' => 'ongoing'
                    ]
                ]
            ],
            // Add other NGOs' projects similarly
        ];

        foreach ($projects as $projectData) {
            $project = Project::create([
                'ngo_id' => $projectData['ngo_id'],
                'title' => $projectData['title'],
                'description' => $projectData['description'],
                'location' => $projectData['location'],
                'budget' => $projectData['budget'],
                'focus_area' => $projectData['focus_area'],
                'holder_id' => User::role('ngo')->where('id', '!=', Ngo::find($projectData['id'])->user_id)->first()->id,
                'runner_id' => User::role('ngo')->where('id', '!=', Ngo::find($projectData['id'])->user_id)->first()->id,
                'start_date' => $projectData['start_date'],
                'end_date' => $projectData['end_date'],
                'status' => $projectData['status'],
            ]);

            foreach ($projectData['trainings'] as $trainingData) {
                Training::create([
                    'project_id' => $project->id,
                    'title' => $trainingData['title'],
                    'description' => $trainingData['description'],
                    'location' => $trainingData['location'],
                    'start_date' => $trainingData['start_date'],
                    'end_date' => $trainingData['end_date'],
                    'capacity' => $trainingData['capacity'],
                    'registration_deadline' => $trainingData['registration_deadline'],
                    'category' => $trainingData['category'],
                    'status' => $trainingData['status'],
                    'organizer_id' => $project->holder_id,
                ]);
            }
        }

        Log::info('Created ' . count($projects) . ' projects with trainings');
    }
}