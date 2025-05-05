<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Ngo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get random Ngos for holder and runner
        $holderId = Ngo::where('status', 'approved')->inRandomOrder()->first()?->id;
        $runnerId = Ngo::where('status', 'approved')->inRandomOrder()->first()?->id;
        
        // if (!$holderId) {
        //     // Create a Ngo if none exists
        //     $holder = Ngo::factory()->create();
        //     $holderId = $holder->id;
        //     $runnerId = $holder->id;
        // }
        
        // Set start date between 6 months in the past and now
        $startDate = $this->faker->dateTimeBetween('-6 months', 'now');
        
        // Set end date between 6 months and 2 years after start date
        $endDate = clone $startDate;
        $endDate->modify('+' . $this->faker->numberBetween(6, 24) . ' months');
        
        $focusAreas = [
            'Education',
            'Health',
            'Climate Change',
            'Agriculture',
            'Water and Sanitation',
            'Disaster Management',
            'Women Empowerment',
            'Children Welfare',
            'Poverty Reduction',
            'Digital Inclusion',
            'Food Security',
            'Renewable Energy'
        ];
        
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
            'Nationwide',
            'Multiple Districts'
        ];
        
        $statuses = [
            'active',
            'completed',
            'suspended',
            'pending'
        ];
        
        // Bangladesh-specific project titles
        $projectTitles = [
            'Rural Education Enhancement Initiative',
            'Urban Health Access Program',
            'Climate Resilience in Coastal Areas',
            'Sustainable Agriculture Practices',
            'Clean Water Access in Rural Communities',
            'Cyclone Preparedness and Response',
            'Women\'s Economic Empowerment',
            'Child Protection and Development',
            'Microfinance for Poverty Alleviation',
            'Digital Literacy for Rural Youth',
            'Food Security in Drought-Prone Areas',
            'Solar Energy for Rural Electrification',
            'Flood Management and Recovery',
            'Maternal and Child Health Program',
            'Education for Rohingya Refugees',
            'Fisheries Development in Coastal Regions',
            'Sanitation Improvement in Urban Slums',
            'Disaster Risk Reduction in Vulnerable Areas',
            'Women\'s Leadership Development',
            'Child Nutrition and Health Initiative',
            'Income Generation for Rural Women',
            'ICT Skills for Rural Communities',
            'Agricultural Innovation for Small Farmers',
            'Renewable Energy for Rural Communities',
            'Emergency Response and Recovery'
        ];
        
        // Bangladesh-specific project descriptions
        $projectDescriptions = [
            'This project aims to improve access to quality education in rural areas of Bangladesh, focusing on primary and secondary education for children from disadvantaged backgrounds.',
            'The Urban Health Access Program works to provide healthcare services to underserved urban populations, particularly in slum areas of major cities like Dhaka and Chittagong.',
            'This initiative focuses on building climate resilience in coastal communities that are vulnerable to rising sea levels, cyclones, and other climate-related disasters.',
            'The Sustainable Agriculture Practices project promotes environmentally friendly farming techniques that increase productivity while preserving natural resources.',
            'This program works to provide clean drinking water to rural communities that lack access to safe water sources, reducing waterborne diseases.',
            'The Cyclone Preparedness and Response initiative helps coastal communities prepare for and respond to cyclones, reducing loss of life and property.',
            'This project empowers women through skills training, access to credit, and support for entrepreneurship, helping them become economically independent.',
            'The Child Protection and Development program works to protect children from abuse, exploitation, and violence while promoting their healthy development.',
            'This microfinance initiative provides small loans to poor households, particularly women, to start or expand small businesses and improve their economic situation.',
            'The Digital Literacy for Rural Youth project teaches young people in rural areas how to use computers and the internet, opening up new opportunities for education and employment.',
            'This initiative works to improve food security in drought-prone areas through better agricultural practices, water management, and community-based food storage.',
            'The Solar Energy for Rural Electrification project provides solar panels to households in off-grid areas, bringing electricity to communities that lack access to the national grid.',
            'This program helps communities prepare for and recover from floods, which are a common occurrence in Bangladesh during the monsoon season.',
            'The Maternal and Child Health Program works to reduce maternal and child mortality by improving access to healthcare services for pregnant women and young children.',
            'This initiative provides education to Rohingya refugee children living in camps in Bangladesh, helping them continue their education despite displacement.',
            'The Fisheries Development project supports small-scale fishers in coastal areas, promoting sustainable fishing practices and improving their livelihoods.',
            'This program works to improve sanitation in urban slums, reducing the spread of disease and improving the quality of life for residents.',
            'The Disaster Risk Reduction initiative helps communities identify and reduce their vulnerability to natural disasters through better planning and infrastructure.',
            'This project develops women\'s leadership skills through training, mentoring, and support for participation in community decision-making.',
            'The Child Nutrition and Health Initiative works to improve the nutritional status of children under five, reducing malnutrition and promoting healthy growth.',
            'This program helps rural women generate income through skills training, access to markets, and support for small businesses.',
            'The ICT Skills for Rural Communities project teaches people in rural areas how to use information and communication technologies, opening up new opportunities.',
            'This initiative promotes agricultural innovation among small farmers, helping them increase productivity and adapt to changing environmental conditions.',
            'The Renewable Energy for Rural Communities project provides solar, wind, and other renewable energy solutions to off-grid areas, improving quality of life.',
            'This program helps communities respond to and recover from emergencies, providing immediate assistance and long-term support for rebuilding.'
        ];
        
        $titleIndex = $this->faker->numberBetween(0, count($projectTitles) - 1);
        
        return [
            'title' => $projectTitles[$titleIndex],
            'description' => $projectDescriptions[$titleIndex],
            'location' => $this->faker->randomElement($locations),
            'budget' => $this->faker->randomFloat(2, 50000, 5000000),
            'focus_area' => $this->faker->randomElement($focusAreas),
            'holder_id' => $holderId,
            'runner_id' => $runnerId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => $this->faker->randomElement($statuses),
        ];
    }
    
    /**
     * Indicate that the project is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }
    
    /**
     * Indicate that the project is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
        ]);
    }
    
    /**
     * Indicate that the project is suspended.
     */
    public function suspended(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'suspended',
        ]);
    }
    
    /**
     * Indicate that the project is pending.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'pending',
        ]);
    }
}
