<?php

namespace Database\Seeders;

use App\Enums\CourseStatus;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Database\Seeder;

class StudentCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $courses = Course::all();
        $courseCount = $courses->count();

        // Loop through each student and randomly attach courses
        foreach ($students as $student) {
            // Determine how many courses to attach (1 to min(5, total courses))
            $numCourses = min(rand(1, 5), $courseCount);

            // Skip if no courses available
            if ($numCourses < 1) {
                continue;
            }

            // Randomly select courses for each student
            $randomCourses = $courses->random($numCourses)->pluck('id')->toArray();

            // Attach the courses to the student with additional pivot data
            foreach ($randomCourses as $courseId) {
                $student->courses()->attach($courseId, [
                    'status' => $this->getRandomStatus(),
                    'grade' => $this->faker->optional(0.7)->randomFloat(2, 50, 100),
                    'attempt' => rand(1, 3),
                    'created_at' => now()->subDays(rand(1, 365)),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Get a random course status
     */
    protected function getRandomStatus(): string
    {
        $statuses = CourseStatus::values();

        return $statuses[array_rand($statuses)];
    }
}
