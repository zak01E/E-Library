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
        Schema::create('school_events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', ['exam', 'holiday', 'orientation', 'registration', 'result', 'ceremony', 'other'])->default('other');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('level')->nullable(); // primaire, college, lycee, superieur
            $table->json('target_classes')->nullable(); // ['CP1', 'CP2', 'CE1', etc.]
            $table->json('regions')->nullable(); // Specific regions if applicable
            $table->string('color', 7)->default('#10b981'); // Hex color for display
            $table->string('icon')->default('fas fa-calendar');
            $table->boolean('is_national')->default(true);
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable(); // yearly, monthly, etc.
            $table->integer('importance')->default(5); // 1-10 scale
            $table->enum('status', ['upcoming', 'ongoing', 'completed', 'cancelled'])->default('upcoming');
            $table->json('documents')->nullable(); // Related document links
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index(['start_date', 'end_date']);
            $table->index('type');
            $table->index('level');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_events');
    }
};