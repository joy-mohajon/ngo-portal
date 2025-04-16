<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
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
        // Get random users for holder and runner
        $holderId = User::inRandomOrder()->first()?->id;
        $runnerId = User::inRandomOrder()->first()?->id;
        
        if (!$holderId) {
            // Create a user if none exists
            $holder = User::factory()->create();
            $holderId = $holder->id;
            $runnerId = $holder->id;
        }
        
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
        
        return [
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraphs(3, true),
            'location' => $this->faker->randomElement($locations),
            'budget' => $this->faker->randomFloat(2, 5000, 500000),
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
