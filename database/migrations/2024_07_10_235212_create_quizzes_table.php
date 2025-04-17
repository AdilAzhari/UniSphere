<?php

use App\Enums\QuizDuration;
use App\Enums\QuizStatus;
use App\Enums\QuizType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('class_group_id')->constrained('class_groups')->cascadeOnDelete();
            $table->string('code');
            $table->string('description');
            $table->enum('type', [QuizType::values()]);
            $table->string('title');
            $table->string('instructions');
            $table->enum('duration', [QuizDuration::values()]);
            $table->enum('status', [QuizStatus::values()]);
            $table->date('start_date');
            $table->date('end_date');
            $table->string('passing_score');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
