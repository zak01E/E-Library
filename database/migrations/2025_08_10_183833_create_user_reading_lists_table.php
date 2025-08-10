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
        Schema::create('user_reading_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->integer('priority')->default(2); // 1=low, 2=medium, 3=high, 4=urgent
            $table->enum('status', ['want_to_read', 'reading', 'read', 'on_hold'])->default('want_to_read');
            $table->timestamp('added_at')->nullable();
            $table->text('notes')->nullable();
            $table->date('estimated_read_date')->nullable();
            $table->timestamps();

            // Ensure a user can't add the same book twice to their reading list
            $table->unique(['user_id', 'book_id']);

            // Indexes for performance
            $table->index(['user_id', 'status']);
            $table->index(['user_id', 'priority']);
            $table->index(['book_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_reading_lists');
    }
};
