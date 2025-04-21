<?php

namespace Database\Seeders;

use App\Models\{Project, Training, User};
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ProjectTrainingSeeder extends Seeder
{
    public function run()
    {
        $projects = [
            // Project 1
            [
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
            // Project 2
            [
                'title' => 'Ultra-Poor Graduation Program',
                'description' => 'Asset distribution and livelihood support for extreme poor households',
                'location' => 'Rural Areas',
                'budget' => 3800000,
                'focus_area' => 'Poverty Alleviation',
                'start_date' => Carbon::parse('2022-07-01'),
                'end_date' => Carbon::parse('2024-06-30'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Small business management',
                        'description' => 'Training on managing small businesses and income generation',
                        'location' => 'Multiple Locations',
                        'start_date' => Carbon::parse('2023-02-01'),
                        'end_date' => Carbon::parse('2023-03-15'),
                        'capacity' => 40,
                        'registration_deadline' => Carbon::parse('2023-01-20'),
                        'category' => 'Entrepreneurship',
                        'status' => 'completed'
                    ]
                ]
            ],
            // Project 3
            [
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
            // Project 4
            [
                'title' => 'Ultra-Poor Graduation Initiative',
                'description' => 'Comprehensive support for ultra-poor households to graduate from poverty',
                'location' => 'Rural Areas',
                'budget' => 5000000,
                'focus_area' => 'Poverty Alleviation',
                'start_date' => Carbon::parse('2021-01-01'),
                'end_date' => Carbon::parse('2025-12-31'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Livestock rearing techniques',
                        'description' => 'Training on poultry and livestock management',
                        'location' => 'Multiple Locations',
                        'start_date' => Carbon::parse('2023-04-01'),
                        'end_date' => Carbon::parse('2023-04-05'),
                        'capacity' => 25,
                        'registration_deadline' => Carbon::parse('2023-03-25'),
                        'category' => 'Agriculture',
                        'status' => 'completed'
                    ]
                ]
            ],
            // Project 5
            [
                'title' => 'Floating Hospitals',
                'description' => 'River-based medical services for hard-to-reach communities',
                'location' => 'Coastal Areas',
                'budget' => 4200000,
                'focus_area' => 'Healthcare',
                'start_date' => Carbon::parse('2020-01-01'),
                'end_date' => Carbon::parse('2025-12-31'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Community health worker certification',
                        'description' => 'Training for local community health workers',
                        'location' => 'Barishal',
                        'start_date' => Carbon::parse('2023-06-01'),
                        'end_date' => Carbon::parse('2023-08-31'),
                        'capacity' => 35,
                        'registration_deadline' => Carbon::parse('2023-05-15'),
                        'category' => 'Health Awareness',
                        'status' => 'upcoming'
                    ]
                ]
            ],
            // Project 6
            [
                'title' => 'Climate Adaptation',
                'description' => 'Supporting communities to adapt to climate change impacts',
                'location' => 'Coastal Areas',
                'budget' => 2800000,
                'focus_area' => 'Climate Change',
                'start_date' => Carbon::parse('2022-09-01'),
                'end_date' => Carbon::parse('2024-08-31'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Disaster preparedness drills',
                        'description' => 'Practical training for disaster preparedness',
                        'location' => 'Khulna',
                        'start_date' => Carbon::parse('2023-05-15'),
                        'end_date' => Carbon::parse('2023-05-17'),
                        'capacity' => 50,
                        'registration_deadline' => Carbon::parse('2023-05-01'),
                        'category' => 'Disaster Management',
                        'status' => 'upcoming'
                    ]
                ]
            ],
            // Project 7
            [
                'title' => 'Education Support',
                'description' => 'Scholarships and educational support for underprivileged children',
                'location' => 'Urban Slums',
                'budget' => 1800000,
                'focus_area' => 'Education',
                'start_date' => Carbon::parse('2023-01-01'),
                'end_date' => Carbon::parse('2023-12-31'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Teacher capacity building',
                        'description' => 'Training for teachers working with underprivileged children',
                        'location' => 'Dhaka',
                        'start_date' => Carbon::parse('2023-04-10'),
                        'end_date' => Carbon::parse('2023-04-12'),
                        'capacity' => 30,
                        'registration_deadline' => Carbon::parse('2023-03-31'),
                        'category' => 'Capacity Building',
                        'status' => 'completed'
                    ]
                ]
            ],
            // Project 8
            [
                'title' => 'Women\'s Empowerment',
                'description' => 'Vocational training and support for women',
                'location' => 'Urban Areas',
                'budget' => 2200000,
                'focus_area' => 'Women Empowerment',
                'start_date' => Carbon::parse('2023-03-01'),
                'end_date' => Carbon::parse('2024-02-28'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Entrepreneurship courses',
                        'description' => 'Training on starting and managing small businesses',
                        'location' => 'Dhaka',
                        'start_date' => Carbon::parse('2023-05-01'),
                        'end_date' => Carbon::parse('2023-07-31'),
                        'capacity' => 25,
                        'registration_deadline' => Carbon::parse('2023-04-20'),
                        'category' => 'Entrepreneurship',
                        'status' => 'upcoming'
                    ]
                ]
            ],
            // Project 9
            [
                'title' => 'Education for Underprivileged Children',
                'description' => 'Operating primary schools in rural areas',
                'location' => 'Rural Areas',
                'budget' => 1900000,
                'focus_area' => 'Education',
                'start_date' => Carbon::parse('2022-01-01'),
                'end_date' => Carbon::parse('2024-12-31'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Teacher training programs',
                        'description' => 'Monthly workshops for teachers',
                        'location' => 'Multiple Locations',
                        'start_date' => Carbon::parse('2023-06-01'),
                        'end_date' => Carbon::parse('2023-06-02'),
                        'capacity' => 40,
                        'registration_deadline' => Carbon::parse('2023-05-25'),
                        'category' => 'Capacity Building',
                        'status' => 'upcoming'
                    ]
                ]
            ],
            // Project 10
            [
                'title' => 'Women\'s Empowerment',
                'description' => 'Vocational training and support for rural women',
                'location' => 'Rural Areas',
                'budget' => 2100000,
                'focus_area' => 'Women Empowerment',
                'start_date' => Carbon::parse('2023-02-01'),
                'end_date' => Carbon::parse('2024-01-31'),
                'status' => 'active',
                'trainings' => [
                    [
                        'title' => 'Tailoring and embroidery (3-month courses)',
                        'description' => 'Vocational training in garment skills',
                        'location' => 'Rajshahi',
                        'start_date' => Carbon::parse('2023-04-01'),
                        'end_date' => Carbon::parse('2023-06-30'),
                        'capacity' => 20,
                        'registration_deadline' => Carbon::parse('2023-03-20'),
                        'category' => 'Vocational',
                        'status' => 'ongoing'
                    ],
                    [
                        'title' => 'Small business management',
                        'description' => 'Training on managing small enterprises',
                        'location' => 'Rajshahi',
                        'start_date' => Carbon::parse('2023-05-15'),
                        'end_date' => Carbon::parse('2023-05-17'),
                        'capacity' => 25,
                        'registration_deadline' => Carbon::parse('2023-05-01'),
                        'category' => 'Entrepreneurship',
                        'status' => 'upcoming'
                    ]
                ]
            ]
        ];

        // Get all NGO users
        $ngoUsers = User::role('ngo')->get();

        foreach ($projects as $projectData) {
            // Assign random holder and runner (ensuring they're different)
            $holder = $ngoUsers->random();
            $runner = $ngoUsers->where('id', '!=', $holder->id)->random();

            $project = Project::create([
                'title' => $projectData['title'],
                'description' => $projectData['description'],
                'location' => $projectData['location'],
                'budget' => $projectData['budget'],
                'focus_area' => $projectData['focus_area'],
                'holder_id' => $holder->id,
                'runner_id' => $runner->id,
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

        \Log::info('Created ' . count($projects) . ' projects with associated trainings');
    }
}