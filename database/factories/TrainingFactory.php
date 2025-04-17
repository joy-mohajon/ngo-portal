<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Training>
 */
class TrainingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random users for organizer
        $organizerId = User::inRandomOrder()->first()?->id;
        
        if (!$organizerId) {
            // Create a user if none exists
            $organizer = User::factory()->create();
            $organizerId = $organizer->id;
        }
        
        // Get random project
        $projectId = Project::inRandomOrder()->first()?->id;
        
        if (!$projectId) {
            // Create a project if none exists
            $project = Project::factory()->create();
            $projectId = $project->id;
        }
        
        // Set start date between now and 6 months in the future
        $startDate = $this->faker->dateTimeBetween('now', '+6 months');
        
        // Set end date between 1 day and 30 days after start date
        $endDate = clone $startDate;
        $endDate->modify('+' . $this->faker->numberBetween(1, 30) . ' days');
        
        // Set registration deadline between now and start date
        $registrationDeadline = clone $startDate;
        $registrationDeadline->modify('-' . $this->faker->numberBetween(1, 14) . ' days');
        
        $locations = [
            'Dhaka',
            'Chittagong',
            'Khulna',
            'Rajshahi',
            'Sylhet',
            'Barishal',
            'Rangpur',
            'Mymensingh',
            'Comilla',
            'Narayanganj',
            'Online',
            'Multiple Locations'
        ];
        
        $categories = [
            'Skills Development',
            'Leadership',
            'Technical',
            'Awareness',
            'Capacity Building',
            'Vocational',
            'Entrepreneurship',
            'Health and Safety',
            'Environmental',
            'Digital Literacy',
            'Financial Literacy',
            'Community Development'
        ];
        
        $statuses = [
            'upcoming',
            'ongoing',
            'completed',
            'cancelled'
        ];
        
        // Bangladesh-specific training titles
        $trainingTitles = [
            'Basic Computer Skills for Rural Youth',
            'Leadership Development for Women',
            'Sustainable Farming Techniques',
            'Disaster Preparedness Workshop',
            'Financial Management for Small Businesses',
            'Digital Marketing Fundamentals',
            'Child Protection and Safety',
            'Water and Sanitation Awareness',
            'Climate Change Adaptation Strategies',
            'Maternal and Child Health Training',
            'Microfinance and Entrepreneurship',
            'ICT Skills for Employment',
            'Agricultural Innovation Workshop',
            'Renewable Energy Technologies',
            'Emergency Response Training',
            'Women\'s Rights and Empowerment',
            'Nutrition and Food Security',
            'Rural Healthcare Practices',
            'Education for Rohingya Children',
            'Fisheries Management Techniques',
            'Urban Sanitation Solutions',
            'Disaster Risk Reduction',
            'Women\'s Leadership in Community Development',
            'Child Nutrition and Health',
            'Income Generation for Rural Women',
            'Digital Skills for Rural Communities',
            'Agricultural Best Practices',
            'Solar Energy Installation and Maintenance',
            'Emergency First Aid Training',
            'Community Leadership Development'
        ];
        
        // Bangladesh-specific training descriptions
        $trainingDescriptions = [
            'This training program teaches basic computer skills to young people in rural areas, helping them access digital opportunities and improve their employability.',
            'The Leadership Development program for women focuses on building confidence, decision-making skills, and community leadership abilities to promote gender equality.',
            'This workshop teaches farmers sustainable agricultural practices that increase productivity while preserving natural resources and adapting to climate change.',
            'The Disaster Preparedness Workshop helps communities prepare for natural disasters like floods and cyclones, which are common in Bangladesh.',
            'This training program teaches small business owners financial management skills to help them run their businesses more effectively and sustainably.',
            'The Digital Marketing Fundamentals course teaches participants how to use digital tools to promote their businesses and reach more customers.',
            'This training program focuses on protecting children from abuse, exploitation, and violence, promoting their safety and well-being.',
            'The Water and Sanitation Awareness program teaches communities about the importance of clean water and proper sanitation to prevent disease.',
            'This workshop helps communities develop strategies to adapt to climate change impacts like rising sea levels, increased flooding, and changing weather patterns.',
            'The Maternal and Child Health Training program teaches healthcare workers and community members how to improve the health of mothers and children.',
            'This training program teaches participants about microfinance options and entrepreneurship skills to help them start or expand small businesses.',
            'The ICT Skills for Employment program teaches job seekers digital skills that are in demand in today\'s job market.',
            'This workshop introduces farmers to innovative agricultural techniques that can increase productivity and sustainability.',
            'The Renewable Energy Technologies training teaches participants about solar, wind, and other renewable energy solutions for off-grid areas.',
            'This Emergency Response Training program teaches participants how to respond effectively to emergencies and disasters.',
            'The Women\'s Rights and Empowerment training focuses on gender equality, women\'s rights, and strategies for women\'s empowerment in communities.',
            'This training program teaches communities about nutrition and food security, helping them improve their dietary practices and food availability.',
            'The Rural Healthcare Practices training teaches community health workers basic healthcare skills to serve rural populations.',
            'This training program provides education support for Rohingya refugee children, helping them continue their education despite displacement.',
            'The Fisheries Management Techniques workshop teaches fishers sustainable fishing practices and better management of fishery resources.',
            'This training program focuses on improving sanitation in urban areas, particularly in slums and informal settlements.',
            'The Disaster Risk Reduction training helps communities identify and reduce their vulnerability to natural disasters.',
            'This program develops women\'s leadership skills for community development, promoting their participation in decision-making processes.',
            'The Child Nutrition and Health training teaches parents and caregivers how to ensure proper nutrition for children under five.',
            'This Income Generation for Rural Women program teaches women skills to start small businesses and generate income for their families.',
            'The Digital Skills for Rural Communities program teaches basic digital literacy to people in rural areas, opening up new opportunities.',
            'This Agricultural Best Practices workshop teaches farmers modern farming techniques that increase productivity and sustainability.',
            'The Solar Energy Installation and Maintenance training teaches participants how to install and maintain solar energy systems for off-grid areas.',
            'This Emergency First Aid Training program teaches basic first aid skills to community members, helping them respond to medical emergencies.',
            'The Community Leadership Development program teaches participants leadership skills to help them become effective community leaders.'
        ];
        
        $titleIndex = $this->faker->numberBetween(0, count($trainingTitles) - 1);
        
        return [
            'title' => $trainingTitles[$titleIndex],
            'description' => $trainingDescriptions[$titleIndex],
            'location' => $this->faker->randomElement($locations),
            'organizer_id' => $organizerId,
            'project_id' => $projectId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => $this->faker->numberBetween(10, 100),
            'registration_deadline' => $registrationDeadline,
            'category' => $this->faker->randomElement($categories),
            'status' => $this->faker->randomElement($statuses),
        ];
    }
    
    /**
     * Indicate that the training is upcoming.
     */
    public function upcoming(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'upcoming',
        ]);
    }
    
    /**
     * Indicate that the training is ongoing.
     */
    public function ongoing(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ongoing',
        ]);
    }
    
    /**
     * Indicate that the training is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }
    
    /**
     * Indicate that the training is cancelled.
     */
    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'cancelled',
        ]);
    }
    
    /**
     * Set the training for a specific project.
     */
    public function forProject(int $projectId): static
    {
        return $this->state(fn (array $attributes) => [
            'project_id' => $projectId,
        ]);
    }
}