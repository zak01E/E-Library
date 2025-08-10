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
        Schema::create('highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('page_number');
            $table->integer('start_position');
            $table->integer('end_position');
            $table->text('selected_text');
            $table->string('color', 20)->default('#FBBF24');
            $table->text('notes')->nullable();
            $table->boolean('is_private')->default(true);
            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'book_id', 'page_number']);
            $table->index(['book_id', 'page_number']);
            $table->index(['user_id', 'created_at']);
            $table->fullText(['selected_text', 'notes']); // For search
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('highlights');
    }
};
