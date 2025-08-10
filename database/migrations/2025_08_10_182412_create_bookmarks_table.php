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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('page_number');
            $table->decimal('position_x', 8, 4)->default(0);
            $table->decimal('position_y', 8, 4)->default(0);
            $table->string('title')->nullable();
            $table->text('notes')->nullable();
            $table->string('color', 20)->default('#3B82F6');
            $table->boolean('is_private')->default(true);
            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'book_id', 'page_number']);
            $table->index(['book_id', 'page_number']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
