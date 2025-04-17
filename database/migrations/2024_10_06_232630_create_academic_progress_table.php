<?php

use App\Enums\AcademicStanding;
use App\Enums\ProgramProgressStatus;
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
        Schema::create('academic_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('program_id')->nullable()->constrained();
            $table->decimal('gpa', 4)->nullable();
            $table->decimal('cgpa', 4)->nullable();
            $table->integer('total_credits')->default(0);
            $table->integer('total_courses')->default(0);
            $table->integer('total_courses_completed')->default(0);
            $table->integer('total_courses_failed')->default(0);
            $table->integer('total_courses_withdrawn')->default(0);
            $table->decimal('progress_percentage', 5, 2)->default(0.00);
            $table->enum('academic_standing', [AcademicStanding::values()])->nullable();
            $table->enum('status', [ProgramProgressStatus::values()]);
            $table->index('student_id');
            $table->index('program_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_progress');
    }
};
