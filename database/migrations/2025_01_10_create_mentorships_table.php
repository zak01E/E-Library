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
        // Mentors profile table
        Schema::create('mentors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('specialization'); // Mathematics, Sciences, Languages, etc.
            $table->json('subjects'); // Detailed subjects they can teach
            $table->json('levels'); // Educational levels they can mentor
            $table->text('bio');
            $table->string('qualification');
            $table->integer('years_experience');
            $table->json('certifications')->nullable();
            $table->json('languages_spoken'); // ['Français', 'Anglais', 'Dioula', etc.]
            $table->json('availability'); // Days and hours available
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->boolean('is_volunteer')->default(false);
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('students_helped')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('total_reviews')->default(0);
            $table->integer('total_sessions')->default(0);
            $table->integer('total_hours')->default(0);
            $table->json('regions_covered')->nullable(); // Regions they can cover
            $table->enum('mentoring_type', ['online', 'in_person', 'both'])->default('both');
            $table->string('linkedin_url')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            $table->index('specialization');
            $table->index(['is_verified', 'is_active']);
            $table->index('rating');
        });

        // Mentorship requests/connections
        Schema::create('mentorship_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('mentor_id')->constrained('mentors')->onDelete('cascade');
            $table->string('subject');
            $table->string('level');
            $table->text('message');
            $table->text('goals')->nullable();
            $table->json('preferred_schedule')->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected', 'cancelled', 'completed'])->default('pending');
            $table->text('mentor_response')->nullable();
            $table->timestamp('responded_at')->nullable();
            $table->timestamp('session_started_at')->nullable();
            $table->timestamp('session_ended_at')->nullable();
            $table->timestamps();
            
            $table->index(['student_id', 'status']);
            $table->index(['mentor_id', 'status']);
            $table->index('status');
        });

        // Mentorship sessions
        Schema::create('mentorship_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentorship_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('mentor_id')->constrained('mentors');
            $table->datetime('scheduled_at');
            $table->integer('duration_minutes');
            $table->string('meeting_link')->nullable();
            $table->string('location')->nullable();
            $table->enum('type', ['online', 'in_person'])->default('online');
            $table->enum('status', ['scheduled', 'ongoing', 'completed', 'cancelled', 'no_show'])->default('scheduled');
            $table->text('topic');
            $table->text('notes')->nullable();
            $table->text('homework')->nullable();
            $table->json('resources_shared')->nullable();
            $table->decimal('student_rating', 3, 2)->nullable();
            $table->text('student_feedback')->nullable();
            $table->timestamps();
            
            $table->index(['scheduled_at', 'status']);
            $table->index(['student_id', 'status']);
            $table->index(['mentor_id', 'status']);
        });

        // Mentor reviews
        Schema::create('mentor_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('mentors')->onDelete('cascade');
            $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('session_id')->constrained('mentorship_sessions')->nullable();
            $table->decimal('rating', 3, 2);
            $table->text('review');
            $table->boolean('would_recommend')->default(true);
            $table->json('tags')->nullable(); // ['Patient', 'Knowledgeable', 'Helpful', etc.]
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
            
            $table->index(['mentor_id', 'rating']);
            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_reviews');
        Schema::dropIfExists('mentorship_sessions');
        Schema::dropIfExists('mentorship_requests');
        Schema::dropIfExists('mentors');
    }
};