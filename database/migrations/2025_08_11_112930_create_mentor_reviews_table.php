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
        if (!Schema::hasTable('mentor_reviews')) {
            Schema::create('mentor_reviews', function (Blueprint $table) {
                $table->id();
                $table->foreignId('mentor_id')->constrained('mentors')->onDelete('cascade');
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('mentorship_session_id')->nullable()->constrained('mentorship_sessions')->onDelete('set null');
                $table->integer('rating')->between(1, 5);
                $table->text('comment')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->boolean('is_anonymous')->default(false);
                $table->timestamps();

                // Ensure one review per student per mentor
                $table->unique(['mentor_id', 'student_id', 'mentorship_session_id'], 'unique_session_review');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentor_reviews');
    }
};
