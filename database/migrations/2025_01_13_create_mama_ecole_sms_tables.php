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
        // Table des logs SMS envoyés
        Schema::create('mama_ecole_sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('parents')->onDelete('cascade');
            $table->string('phone_number');
            $table->text('message');
            $table->string('message_id')->nullable();
            $table->enum('status', ['pending', 'sent', 'delivered', 'failed'])->default('pending');
            $table->string('delivery_status')->nullable();
            $table->json('response_data')->nullable();
            $table->timestamps();
            
            $table->index('phone_number');
            $table->index('status');
            $table->index('message_id');
        });
        
        // Table des callbacks SMS
        Schema::create('mama_ecole_sms_callbacks', function (Blueprint $table) {
            $table->id();
            $table->json('data');
            $table->timestamps();
        });
        
        // Table des SMS reçus
        Schema::create('mama_ecole_sms_received', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->text('message');
            $table->string('message_id')->unique();
            $table->json('raw_data')->nullable();
            $table->boolean('processed')->default(false);
            $table->timestamps();
            
            $table->index('phone_number');
            $table->index('processed');
        });
        
        // Table des confirmations de réunion
        Schema::create('meeting_confirmations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained('parents')->onDelete('cascade');
            $table->foreignId('meeting_id')->nullable();
            $table->boolean('confirmed')->default(false);
            $table->timestamp('confirmed_at')->nullable();
            $table->enum('confirmation_method', ['voice', 'sms', 'ussd', 'app'])->nullable();
            $table->timestamps();
            
            $table->unique(['parent_id', 'meeting_id']);
            $table->index('confirmed');
        });
        
        // Table des grades des étudiants (pour les SMS)
        Schema::create('student_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->string('subject');
            $table->decimal('grade', 4, 2);
            $table->string('term')->nullable();
            $table->string('academic_year')->nullable();
            $table->text('comment')->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('users');
            $table->timestamps();
            
            $table->index(['student_id', 'created_at']);
            $table->index('subject');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_grades');
        Schema::dropIfExists('meeting_confirmations');
        Schema::dropIfExists('mama_ecole_sms_received');
        Schema::dropIfExists('mama_ecole_sms_callbacks');
        Schema::dropIfExists('mama_ecole_sms_logs');
    }
};