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
        // Table des classes
        if (!Schema::hasTable('classes')) {
            Schema::create('classes', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Ex: "6ème A", "Terminale C"
                $table->string('level'); // Ex: "Primaire", "Collège", "Lycée"
                $table->string('academic_year'); // Ex: "2024-2025"
                $table->integer('total_students')->default(0);
                $table->foreignId('teacher_id')->nullable()->constrained('users')->nullOnDelete();
                $table->timestamps();
                
                $table->index(['level', 'academic_year']);
            });
        }
        
        // Table des étudiants  
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('matricule')->unique();
                $table->date('date_of_birth')->nullable();
                $table->enum('gender', ['M', 'F'])->nullable();
                $table->foreignId('class_id')->nullable()->constrained()->nullOnDelete();
                $table->foreignId('parent_id')->nullable();
                $table->decimal('average_grade', 5, 2)->nullable();
                $table->integer('absences_count')->default(0);
                $table->boolean('is_active')->default(true);
                $table->json('emergency_contacts')->nullable();
                $table->text('medical_notes')->nullable();
                $table->timestamps();
                
                $table->index('matricule');
                $table->index(['class_id', 'is_active']);
                $table->index('parent_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('classes');
    }
};
