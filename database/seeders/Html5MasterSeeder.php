<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Html5MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting HTML5 course content seeding...');
        
        // Run seeders in the correct order
        $this->call([
            Html5CourseSeeder::class,      // Create the course first
            Html5LessonsSeeder::class,     // Create lessons
            Html5LessonTopicsSeeder::class, // Create individual lesson subtopics
            Html5CodeExamplesSeeder::class, // Add code examples to lessons
            Html5ActivitiesSeeder::class,   // Add activities to lessons
        ]);
        
        $this->command->info('HTML5 course content seeding completed successfully!');
    }
}
