<?php

use App\Enums\CoursePayment;
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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('max_students')->default(30);
            $table->integer('credit_hours')->default(3);
            $table->string('syllabus')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(false);
            $table->foreignId('program_id')->constrained('programs')->cascadeOnDelete();
            $table->foreignId('prerequisite_course_id')->nullable()->constrained('courses')->cascadeOnDelete();
            $table->foreignId('course_category_id')->constrained()->cascadeOnDelete();
            $table->boolean('require_proctor')->default(false);
            $table->enum('paid', [CoursePayment::values()])->default(CoursePayment::UNPAID);
            $table->decimal('cost', 10)->nullable();
            $table->integer('sequence')->default(1); // represent the number of times student had taking this course
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
