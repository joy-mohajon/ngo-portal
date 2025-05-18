<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            Log::info('Starting database seeding...');
            
            $this->call([
                UserSeeder::class,
                // ProjectSeeder::class,
                // TrainingSeeder::class,
                FocusAreaSeeder::class,
                NgoSeeder::class,
                ProjectTrainingSeeder::class,
            ]);
            
            Log::info('Database seeding completed successfully');
        } catch (\Exception $e) {
            Log::error('Error in database seeding: ' . $e->getMessage());
            throw $e;
        }
    }
}