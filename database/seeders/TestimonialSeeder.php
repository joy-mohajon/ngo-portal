<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\Project;
use App\Models\Ngo;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $ngos = Ngo::all();
        foreach ($projects as $project) {
            $ngo = $ngos->random();
            Testimonial::create([
                'project_id' => $project->id,
                'title' => 'Excellent Support',
                'description' => 'This project made a real difference in our community. The support and training provided were invaluable. Highly recommended!',
                'testimonial_file' => 'testimonials/support.pdf',
                'application_file' => 'testimonials/application_support.pdf',
                'requested_by' => $ngo->id,
                'date' => now()->subDays(rand(1, 365))->format('Y-m-d'),
                'status' => 'approved',
            ]);
            $ngo2 = $ngos->random();
            Testimonial::create([
                'project_id' => $project->id,
                'title' => 'Youth Empowerment',
                'description' => 'I am grateful for the opportunities this project created for local youth. The team was professional and caring.',
                'testimonial_file' => null,
                'application_file' => 'testimonials/application_youth.pdf',
                'requested_by' => $ngo2->id,
                'date' => now()->subDays(rand(1, 365))->format('Y-m-d'),
                'status' => 'pending',
            ]);
        }
    }
}