<?php

use App\Enums\ContentType;
use App\Enums\FileType;
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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('updated_by')->constrained('teachers')->cascadeOnDelete();
            $table->foreignId('week_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [FileType::values()])->nullable();
            $table->enum('content_type', [ContentType::values()])->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('size')->nullable();
            $table->string('path')->nullable();
            $table->string('url')->nullable();
            $table->string('filename')->nullable();
            $table->string('original_filename')->nullable();
            $table->string('disk')->nullable();
            $table->string('title')->nullable();
            $table->text('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};
