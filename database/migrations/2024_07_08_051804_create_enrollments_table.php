<?php

use App\Enums\EnrollmentStatus;
use App\Enums\ProctorStatus;
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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->enum('enrollment_status', [EnrollmentStatus::values()])->default(EnrollmentStatus::PENDING->value);
            $table->enum('proctor_status', [ProctorStatus::values()])->default(ProctorStatus::PENDING->value);
            $table->boolean('proctored')->default(false);
            $table->date('enrollment_date');
            $table->date('completion_date')->nullable();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('term_id')->constrained()->cascadeOnDelete();
            $table->string('grade')->default('F');
            $table->Decimal('grade_points')->default(0.00);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
