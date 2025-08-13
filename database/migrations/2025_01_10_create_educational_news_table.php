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
        Schema::create('educational_news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->text('excerpt')->nullable();
            $table->string('category')->default('general'); // urgent, opportunity, innovation, announcement
            $table->string('image_path')->nullable();
            $table->string('source')->nullable();
            $table->string('source_url')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['draft', 'published', 'archived'])->default('published');
            $table->integer('views')->default(0);
            $table->json('tags')->nullable();
            $table->date('event_date')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'priority']);
            $table->index('published_at');
            $table->index('category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('educational_news');
    }
};