<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ngo;
use App\Models\FocalPerson;

class FocalPersonSeeder extends Seeder
{
    public function run()
    {
        $designations = [
            'Program Manager', 'Field Officer', 'Coordinator', 'Monitoring Officer', 'Project Lead',
            'Community Mobilizer', 'Admin Officer', 'Finance Officer', 'Training Coordinator', 'Outreach Worker'
        ];
        $ngos = Ngo::all();
        foreach ($ngos as $ngo) {
            $count = rand(1, 2); // 1 or 2 focal persons per NGO
            for ($i = 0; $i < $count; $i++) {
                $name = fake('bn_BD')->name();
                $designation = $designations[array_rand($designations)];
                $mobile = '01' . rand(3, 9) . rand(10000000, 99999999); // Bangladeshi mobile
                $email = strtolower(str_replace(' ', '.', $ngo->short_name ?? $ngo->name)) . ".focal{$i}@example.com";
                $focalPerson = FocalPerson::create([
                    'name' => $name,
                    'mobile' => $mobile,
                    'email' => $email,
                    'designation' => $designation,
                ]);
                $ngo->focalPersons()->attach($focalPerson->id);
            }
        }
    }
} 