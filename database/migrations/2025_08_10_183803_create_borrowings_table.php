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
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->timestamp('borrowed_at')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->enum('status', ['active', 'returned', 'overdue', 'lost', 'damaged'])->default('active');
            $table->integer('renewal_count')->default(0);
            $table->text('notes')->nullable();
            $table->decimal('fine_amount', 8, 2)->nullable();
            $table->timestamps();

            // Indexes for performance
            $table->index(['user_id', 'status']);
            $table->index(['book_id', 'status']);
            $table->index(['due_date', 'status']);
            $table->index(['borrowed_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
