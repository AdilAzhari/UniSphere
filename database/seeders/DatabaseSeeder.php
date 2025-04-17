<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => '12345678',
            'role' => UserRole::ADMIN->value,
        ]);
        //        User::factory()->create([
        //            'name' => 'teacher',
        //            'email' => 'teacher@example.com',
        //            'password' => '12345678',
        //            'role' => UserRole::TEACHER->value,
        //        ]);
        $this->call([
            //            UserSeeder::class,
            //            departmentSeeder::class,
            //            ProgramTypeSeeder::class,
            //            ProgramStatusSeeder::class,
            //            programSeeder::class,
            //            TermSeeder::class,
            //            CourseCategorySeeder::class,
            //            CourseSeeder::class,
            //            TeacherSeeder::class,
            //            StudentSeeder::class,
            //            ProctorSeeder::class,
            //            enrollmentSeeder::class,
            //            AttendanceSeeder::class,
            //            WeekSeeder::class,
            //            AssignmentSeeder::class,
            //            QuizSeeder::class,
            //            GradingScaleSeeder::class,
            //            AssignmentSubmissionSeeder::class,
            //            ExamSeeder::class,
            //            ExamResultSeeder::class,
            //            TechnicalTeamSeeder::class,
            //            announcementSeeder::class,
            //            QuizQuestionSeeder::class,
            //            QuizQuestionOptionSeeder::class,
            //            QuizAnswerSeeder::class,
            //            QuizSubmissionSeeder::class,

            //            MaterialSeeder::class,

            //            ExamQuestionSeeder::class,
            //            ExamAnswerSeeder::class,
            //            ExamQuestionOptionSeeder::class,
            //            AnnouncementCommentSeeder::class,
            //            AcademicProgressSeeder::class,
            //            RegistrationSeeder::class,
            //            StudentCourseSeeder::class,
            //            CourseRequirementsSeeder::class,
            //            linkSeeder::class,
            //            CourseGradesSeeder::class,
            //            AcademicAchievementSeeder::class,
            PaymentSeeder::class,
            StorySeeder::class,
            StoryTagSeeder::class,
            StoryCommentSeeder::class,
            LearningGuidanceSeeder::class,
            AssignmentAttachmentSeeder::class,
            AssignmentCommentSeeder::class,
            AssignmentSubmissionFileSeeder::class,
            PeerReviewSeeder::class,
            ClassGroupSeeder::class,
        ]);
    }
}
