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
        // Table des parents
        if (!Schema::hasTable('parents')) {
            Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('phone_number')->unique();
            $table->enum('preferred_language', ['french', 'dioula', 'baoule', 'bete', 'senoufo'])->default('french');
            $table->boolean('can_read')->default(false);
            $table->enum('preferred_call_time', ['morning', 'afternoon', 'evening'])->nullable();
            $table->boolean('enrolled_mama_ecole')->default(false);
            $table->timestamp('enrollment_date')->nullable();
            $table->integer('total_calls_received')->default(0);
            $table->integer('total_calls_answered')->default(0);
            $table->decimal('engagement_score', 5, 2)->default(0);
            $table->timestamps();
            
            $table->index('phone_number');
            $table->index('preferred_language');
            $table->index('enrolled_mama_ecole');
        });
        }
        
        // Table des interactions MAMA ÉCOLE
        if (!Schema::hasTable('mama_ecole_interactions')) {
            Schema::create('mama_ecole_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained()->onDelete('cascade');
            $table->enum('message_type', ['grades', 'absence', 'meeting', 'urgent', 'welcome', 'reminder', 'feedback']);
            $table->string('language');
            $table->string('call_sid')->unique();
            $table->enum('call_status', ['queued', 'ringing', 'in-progress', 'completed', 'failed', 'busy', 'no-answer'])->default('queued');
            $table->integer('call_duration')->nullable();
            $table->boolean('listened_full')->default(false);
            $table->string('input_received')->nullable();
            $table->json('message_data')->nullable();
            $table->timestamps();
            
            $table->index(['parent_id', 'created_at']);
            $table->index('call_sid');
            $table->index('call_status');
            $table->index('message_type');
        });
        }
        
        // Table des messages vocaux laissés par les parents
        if (!Schema::hasTable('parent_voice_messages')) {
            Schema::create('parent_voice_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('call_sid');
            $table->string('recording_url');
            $table->integer('duration');
            $table->text('transcription')->nullable();
            $table->boolean('reviewed')->default(false);
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->timestamp('reviewed_at')->nullable();
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->text('teacher_response')->nullable();
            $table->timestamps();
            
            $table->index('reviewed');
            $table->index('priority');
        });
        }
        
        // Table de liaison parent-élève
        if (!Schema::hasTable('parent_student')) {
            Schema::create('parent_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->enum('relationship', ['mother', 'father', 'guardian', 'other'])->default('guardian');
            $table->boolean('is_primary_contact')->default(true);
            $table->timestamps();
            
            $table->unique(['parent_id', 'student_id']);
            $table->index('student_id');
        });
        }
        
        // Table des templates de messages
        if (!Schema::hasTable('mama_ecole_templates')) {
            Schema::create('mama_ecole_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['grades', 'absence', 'meeting', 'urgent', 'custom']);
            $table->json('content'); // Contenu multilingue
            $table->json('variables'); // Variables disponibles
            $table->boolean('active')->default(true);
            $table->integer('usage_count')->default(0);
            $table->timestamps();
            
            $table->index('type');
            $table->index('active');
        });
        }
        
        // Table des campagnes de notification
        if (!Schema::hasTable('mama_ecole_campaigns')) {
            Schema::create('mama_ecole_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('target_type', ['all', 'class', 'grade', 'school', 'custom']);
            $table->json('target_criteria')->nullable();
            $table->foreignId('template_id')->nullable()->constrained('mama_ecole_templates');
            $table->json('message_content');
            $table->integer('total_recipients')->default(0);
            $table->integer('successful_calls')->default(0);
            $table->integer('failed_calls')->default(0);
            $table->enum('status', ['draft', 'scheduled', 'in_progress', 'completed', 'cancelled'])->default('draft');
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('status');
            $table->index('scheduled_at');
        });
        }
        
        // Table des analytics
        if (!Schema::hasTable('mama_ecole_analytics')) {
            Schema::create('mama_ecole_analytics', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->integer('total_calls')->default(0);
            $table->integer('successful_calls')->default(0);
            $table->integer('failed_calls')->default(0);
            $table->decimal('average_duration', 8, 2)->default(0);
            $table->json('language_breakdown');
            $table->json('hourly_distribution');
            $table->json('message_type_breakdown');
            $table->decimal('engagement_rate', 5, 2)->default(0);
            $table->decimal('cost_fcfa', 10, 2)->default(0);
            $table->timestamps();
            
            $table->unique('date');
            $table->index('date');
        });
        }
        
        // Table des feedback parents
        if (!Schema::hasTable('parent_feedback')) {
            Schema::create('parent_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained()->onDelete('cascade');
            $table->foreignId('interaction_id')->nullable()->constrained('mama_ecole_interactions');
            $table->enum('rating', ['1', '2', '3', '4', '5'])->nullable();
            $table->text('comment')->nullable();
            $table->enum('channel', ['voice', 'sms', 'ussd', 'whatsapp'])->default('voice');
            $table->json('suggestions')->nullable();
            $table->boolean('wants_callback')->default(false);
            $table->timestamps();
            
            $table->index('rating');
            $table->index('parent_id');
        });
        }
        
        // Table des rewards LEARN & EARN
        if (!Schema::hasTable('mama_ecole_rewards')) {
            Schema::create('mama_ecole_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->constrained()->onDelete('cascade');
            $table->enum('action_type', [
                'listen_full',
                'attend_meeting',
                'respond_survey',
                'child_improvement',
                'refer_parent',
                'complete_training'
            ]);
            $table->integer('points_earned')->default(0);
            $table->decimal('fcfa_value', 8, 2)->default(0);
            $table->boolean('paid_out')->default(false);
            $table->timestamp('paid_at')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->timestamps();
            
            $table->index(['parent_id', 'paid_out']);
            $table->index('action_type');
        });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mama_ecole_rewards');
        Schema::dropIfExists('parent_feedback');
        Schema::dropIfExists('mama_ecole_analytics');
        Schema::dropIfExists('mama_ecole_campaigns');
        Schema::dropIfExists('mama_ecole_templates');
        Schema::dropIfExists('parent_student');
        Schema::dropIfExists('parent_voice_messages');
        Schema::dropIfExists('mama_ecole_interactions');
        Schema::dropIfExists('parents');
    }
};