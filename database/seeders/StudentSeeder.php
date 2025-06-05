<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $projects = Project::all();
        $genders = ['male', 'female', 'other'];
        $educationLevels = ['Primary', 'Secondary', 'Higher Secondary', 'Undergraduate'];
        $institutions = ['Kurigram High School', 'Dhaka College', 'BRAC University', 'Rajshahi University'];
        $batches = ['Spring 2022', 'Fall 2022', 'Spring 2023', 'Fall 2023', 'Spring 2024'];

        for ($i = 1; $i <= 20; $i++) {
            $student = Student::create([
                'name' => 'Student ' . $i,
                'email' => 'student' . $i . '@example.com',
                'phone' => '0171' . rand(1000000, 9999999),
                'address' => 'Village ' . $i . ', Kurigram',
                'photo' => 'students/photos/student' . $i . '.jpg',
                'national_id' => '1990' . rand(100000, 999999),
                'national_id_file' => 'students/nid/student' . $i . '.pdf',
                'birth_certificate_number' => 'BC' . rand(100000, 999999),
                'birth_certificate_file' => 'students/birth/student' . $i . '.pdf',
                'date_of_birth' => Carbon::parse('2000-01-01')->addDays(rand(0, 7000)),
                'gender' => Arr::random($genders),
                'guardian_name' => 'Guardian ' . $i,
                'guardian_phone' => '0181' . rand(1000000, 9999999),
                'guardian_address' => 'Guardian Address ' . $i,
                'enrollment_date' => Carbon::now()->subMonths(rand(1, 24)),
                'education_level' => Arr::random($educationLevels),
                'education_institution' => Arr::random($institutions),
                'status' => 'active',
                'notes' => 'Notes for student ' . $i,
                'batch' => Arr::random($batches),
            ]);

            // Attach to 1-2 random projects with pivot data
            $attachProjects = $projects->random(rand(1, min(2, $projects->count())));
            foreach ($attachProjects as $project) {
                $student->projects()->attach($project->id, [
                    'enrollment_date' => $student->enrollment_date,
                    'completion_date' => null,
                    'status' => 'active',
                    'notes' => 'Enrolled in project ' . $project->title,
                ]);
            }
        }
    }
}