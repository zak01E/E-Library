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
        Schema::create('reading_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamp('started_at');
            $table->timestamp('ended_at')->nullable();
            $table->integer('current_page')->default(1);
            $table->integer('total_pages')->nullable();
            $table->decimal('progress', 5, 2)->default(0); // Percentage 0-100
            $table->integer('reading_time_minutes')->nullable();
            $table->string('device_type', 50)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'started_at']);
            $table->index(['book_id', 'started_at']);
            $table->index(['user_id', 'book_id', 'started_at']);
            $table->index(['ended_at']); // For active sessions (null ended_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reading_sessions');
    }
};
