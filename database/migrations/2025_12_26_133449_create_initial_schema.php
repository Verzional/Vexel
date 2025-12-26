<?php

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
            $table->string('name');
            $table->integer('year');
            $table->timestamps();
        });

        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('title');
            $table->longtext('description');
            $table->timestamps();
        });

        Schema::create('rubrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->unique()->constrained('assignments')->onDelete('cascade');
            $table->string('subject_name');
            $table->json('criteria');
            $table->timestamps();
        });

        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->string('student_name');
            $table->string('file_path');
            $table->longtext('extracted_text')->nullable();
            $table->timestamps();
        });

        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions');
            $table->decimal('grade', 5, 2);
            $table->text('reasoning');
            $table->text('feedback');
            $table->text('notable_points');
            $table->boolean('is_verified')->default(false);
            $table->json('breakdown');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('rubrics');
        Schema::dropIfExists('submissions');
        Schema::dropIfExists('results');
    }
};
