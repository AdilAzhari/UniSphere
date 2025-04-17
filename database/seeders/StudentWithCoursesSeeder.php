<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentWithCoursesSeeder extends Seeder
{
    public function run(): void
    {
        //        $user = User::where("id", 3)->first();
        $student = Student::where('id', 3)->first();
        Enrollment::factory()->count(5)->create(['student_id' => $student->id]);
        $student = Student::factory()
            ->has(
                Enrollment::factory()
                    ->count(3)
                    ->for(Term::factory()->past())
                    ->for(Course::factory())
            )
            ->has(
                Enrollment::factory()
                    ->count(2)
                    ->for(Term::factory()->current())
                    ->for(Course::factory())
            )
            ->has(
                Enrollment::factory()
                    ->count(4)
                    ->for(Term::factory()->future())
                    ->for(Course::factory())
            )
            ->create();

        echo "Student with courses created successfully.\n";
    }
}
