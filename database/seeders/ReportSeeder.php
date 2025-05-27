<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Report;
use App\Models\Project;
use App\Models\Ngo;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $ngos = Ngo::all();
        foreach ($projects as $project) {
            $ngo = $ngos->random();
            Report::create([
                'project_id' => $project->id,
                'title' => 'Quarterly Progress Report',
                'description' => 'During this quarter, the project achieved significant milestones including the completion of training sessions for 120 beneficiaries in Dhaka and Chattogram. Community feedback has been overwhelmingly positive.',
                'month' => '2025-04',
                'file_path' => 'reports/progress_apr2025.pdf',
                'file_name' => 'progress_apr2025.pdf',
                'file_size' => '120 KB',
                'file_type' => 'pdf',
                'submitted_by' => $ngo->id,
                'status' => 'submitted',
            ]);
            $ngo2 = $ngos->random();
            Report::create([
                'project_id' => $project->id,
                'title' => 'Annual Impact Report',
                'description' => 'The annual report highlights the project’s impact on local livelihoods, with over 500 families benefiting from new income-generating activities. Partnerships with local authorities have strengthened project sustainability.',
                'month' => '2024-12',
                'file_path' => 'reports/impact_2024.pdf',
                'file_name' => 'impact_2024.pdf',
                'file_size' => '340 KB',
                'file_type' => 'pdf',
                'submitted_by' => $ngo2->id,
                'status' => 'submitted',
            ]);
        }
    }
}
