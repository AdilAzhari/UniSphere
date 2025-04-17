<?php

use App\Enums\PaymentStatus;
use App\Enums\ProctorApprovalStatus;
use App\Enums\RegistrationStatus;
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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('proctor_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('term_id')->constrained()->cascadeOnDelete();
            $table->enum('registration_status', [RegistrationStatus::values()])->index();
            $table->enum('proctor_approval_status', [ProctorApprovalStatus::values()])->index();
            $table->boolean('proctored');
            $table->timestamp('registered_at')->nullable();
            $table->date('completion_date')->nullable();
            $table->enum('payment_status', [PaymentStatus::values()]);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
