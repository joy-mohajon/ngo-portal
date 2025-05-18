<?php

namespace Database\Seeders;

use App\Models\FocusArea;
use Illuminate\Database\Seeder;

class FocusAreaSeeder extends Seeder
{
    public function run()
    {
        $focusAreas = [
            ['name' => 'Financial Inclusion', 'slug' => 'financial-inclusion'],
            ['name' => 'Healthcare', 'slug' => 'healthcare'],
            ['name' => 'Education', 'slug' => 'education'],
            ['name' => 'Community Development', 'slug' => 'community-development'],
            ['name' => 'Women Empowerment', 'slug' => 'women-empowerment'],
            ['name' => 'Disaster Relief', 'slug' => 'disaster-relief'],
            ['name' => 'Environment', 'slug' => 'environment'],
            ['name' => 'Human Rights', 'slug' => 'human-rights'],
            ['name' => 'Agriculture', 'slug' => 'agriculture'],
        ];

        foreach ($focusAreas as $focusArea) {
            FocusArea::create([
                'name' => $focusArea['name'],
                'slug' => $focusArea['slug'],
                'description' => $this->getDescriptionForFocusArea($focusArea['name']),
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