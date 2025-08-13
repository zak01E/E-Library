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
        if (!Schema::hasTable('mentorship_sessions')) {
            Schema::create('mentorship_sessions', function (Blueprint $table) {
                $table->id();
                $table->foreignId('mentor_id')->constrained('mentors')->onDelete('cascade');
                $table->foreignId('student_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('mentorship_request_id')->nullable()->constrained('mentorship_requests')->onDelete('set null');
                $table->string('subject');
                $table->enum('status', ['scheduled', 'in_progress', 'completed', 'cancelled', 'no_show'])->default('scheduled');
                $table->timestamp('scheduled_at');
                $table->timestamp('started_at')->nullable();
                $table->timestamp('ended_at')->nullable();
                $table->integer('duration_minutes')->nullable();
                $table->text('notes')->nullable();
                $table->text('mentor_notes')->nullable();
                $table->enum('session_type', ['online', 'in_person'])->default('online');
                $table->string('meeting_url')->nullable();
                $table->text('location')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mentorship_sessions');
    }
};
