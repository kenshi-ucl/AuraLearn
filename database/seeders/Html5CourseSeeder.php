<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course;

class Html5CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update the HTML5 Tutorial course
        $course = Course::firstOrCreate(
            ['slug' => 'html5-tutorial'],
            [
                'title' => 'HTML5 Tutorial',
                'description' => 'Complete HTML5 course covering web development fundamentals from the Internet basics to advanced HTML5 features. Based on Web Development & Design Foundations with HTML5.',
                'category' => 'web-development',
                'difficulty_level' => 'beginner',
                'duration_hours' => 40,
                'total_lessons' => 29,
                'tags' => json_encode(['HTML5', 'Web Development', 'Frontend']),
                'is_free' => 1,
                'is_published' => 1,
                'order_index' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        $this->command->info('HTML5 Tutorial course created/updated successfully.');
    }
}
