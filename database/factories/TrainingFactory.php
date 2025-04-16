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
        // Get a random user for organizer
        $userId = User::inRandomOrder()->first()?->id ?? 1;
        
        // Get a random project
        $projectId = Project::inRandomOrder()->first()?->id ?? 1;
        
        // Set start date between now and 3 months in the future
        $startDate = $this->faker->dateTimeBetween('now', '+3 months');
        
        // Set end date between 1 and 5 days after start date
        $endDate = clone $startDate;
        $endDate->modify('+' . $this->faker->numberBetween(1, 5) . ' days');
        
        // Set registration deadline to before start date
        $registrationDeadline = clone $startDate;
        $registrationDeadline->modify('-' . $this->faker->numberBetween(1, 14) . ' days');
        
        $trainingCategories = [
            'Agriculture', 
            'Disaster Management', 
            'Women Empowerment', 
            'Digital Skills',
            'Healthcare', 
            'Climate Change', 
            'Education', 
            'Financial Management',
            'WASH', 
            'Renewable Energy', 
            'Community Development', 
            'Project Management'
        ];
        
        $trainingStatus = ['upcoming', 'ongoing', 'completed', 'cancelled'];
        
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraphs(3, true),
            'location' => $this->faker->city,
            'organizer_id' => $userId,
            'project_id' => $projectId,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'capacity' => $this->faker->numberBetween(10, 100),
            'registration_deadline' => $registrationDeadline,
            'category' => $this->faker->randomElement($trainingCategories),
            'status' => $this->faker->randomElement($trainingStatus),
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