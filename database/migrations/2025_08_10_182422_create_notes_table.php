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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('page_number');
            $table->decimal('position_x', 8, 4)->default(0);
            $table->decimal('position_y', 8, 4)->default(0);
            $table->string('title')->nullable();
            $table->text('content');
            $table->string('color', 20)->default('#FCD34D');
            $table->boolean('is_private')->default(true);
            $table->json('tags')->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'book_id', 'page_number']);
            $table->index(['book_id', 'page_number']);
            $table->index(['user_id', 'updated_at']);
            $table->fullText(['title', 'content']); // For search
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
