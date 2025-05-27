<?php

namespace Database\Seeders;

use App\Models\FocusArea;
use Illuminate\Database\Seeder;

class FocusAreaSeeder extends Seeder
{
    public function run()
    {
        $focusAreas = [
            ['name' => 'Financial Inclusion', 'slug' => 'financial-inclusion', 'type' => 'Project'],
            ['name' => 'Healthcare', 'slug' => 'healthcare', 'type' => 'Project'],
            ['name' => 'Education', 'slug' => 'education', 'type' => 'Project'],
            ['name' => 'Community Development', 'slug' => 'community-development', 'type' => 'NGO'],
            ['name' => 'Women Empowerment', 'slug' => 'women-empowerment', 'type' => 'NGO'],
            ['name' => 'Disaster Relief', 'slug' => 'disaster-relief', 'type' => 'Project'],
            ['name' => 'Environment', 'slug' => 'environment', 'type' => 'Project'],
            ['name' => 'Human Rights', 'slug' => 'human-rights', 'type' => 'NGO'],
            ['name' => 'Agriculture', 'slug' => 'agriculture', 'type' => 'Project'],
        ];

        foreach ($focusAreas as $focusArea) {
            FocusArea::create([
                'name' => $focusArea['name'],
                'slug' => $focusArea['slug'],
                'description' => $this->getDescriptionForFocusArea($focusArea['name']),
                'type' => $focusArea['type'],
            ]);
        }
    }

    private function getDescriptionForFocusArea($name)
    {
        $descriptions = [
            'Financial Inclusion' => 'Programs focused on providing financial services to underserved populations',
            'Healthcare' => 'Health services, medical care, and public health initiatives',
            'Education' => 'Educational programs, schools, and literacy initiatives',
            'Community Development' => 'Programs that strengthen local communities and infrastructure',
            'Women Empowerment' => 'Initiatives focused on gender equality and women\'s rights',
            'Disaster Relief' => 'Emergency response and disaster management programs',
            'Environment' => 'Environmental conservation and sustainability programs',
            'Human Rights' => 'Advocacy and protection of fundamental human rights',
            'Agriculture' => 'Agricultural development and rural livelihood programs',
        ];

        return $descriptions[$name] ?? null;
    }
}