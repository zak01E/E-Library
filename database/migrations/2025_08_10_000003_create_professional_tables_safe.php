<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Only create tables that don't exist
        
        if (!Schema::hasTable('profiles')) {
            Schema::create('profiles', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('display_name')->nullable();
                $table->string('avatar')->nullable();
                $table->text('bio')->nullable();
                $table->date('date_of_birth')->nullable();
                $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
                $table->string('country')->nullable();
                $table->string('city')->nullable();
                $table->string('language_preference')->default('fr');
                $table->string('timezone')->default('Europe/Paris');
                $table->json('reading_preferences')->nullable();
                $table->json('privacy_settings')->nullable();
                $table->json('notification_settings')->nullable();
                $table->timestamps();
                
                $table->index('user_id');
            });
        }

        if (!Schema::hasTable('authors')) {
            Schema::create('authors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('pen_name')->nullable();
                $table->text('biography')->nullable();
                $table->string('website')->nullable();
                $table->json('social_links')->nullable();
                $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
                $table->string('verification_documents')->nullable();
                $table->integer('total_books')->default(0);
                $table->integer('total_downloads')->default(0);
                $table->decimal('total_revenue', 10, 2)->default(0);
                $table->decimal('commission_rate', 5, 2)->default(70.00);
                $table->string('payment_method')->nullable();
                $table->json('payment_details')->nullable();
                $table->enum('author_level', ['bronze', 'silver', 'gold', 'platinum'])->default('bronze');
                $table->json('achievements')->nullable();
                $table->json('specializations')->nullable();
                $table->timestamps();
                
                $table->index('user_id');
                $table->index('verification_status');
            });
        }

        if (!Schema::hasTable('borrowings')) {
            Schema::create('borrowings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('book_id')->constrained()->onDelete('cascade');
                $table->timestamp('borrowed_at')->useCurrent();
                $table->timestamp('due_date')->nullable();
                $table->timestamp('returned_at')->nullable();
                $table->integer('extended_count')->default(0);
                $table->enum('status', ['active', 'returned', 'overdue', 'lost'])->default('active');
                $table->decimal('fine_amount', 8, 2)->default(0);
                $table->boolean('fine_paid')->default(false);
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->index(['user_id', 'status']);
                $table->index(['book_id', 'status']);
            });
        }

        if (!Schema::hasTable('reservations')) {
            Schema::create('reservations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('book_id')->constrained()->onDelete('cascade');
                $table->timestamp('reserved_at')->useCurrent();
                $table->timestamp('expires_at')->nullable();
                $table->enum('status', ['pending', 'confirmed', 'cancelled', 'expired'])->default('pending');
                $table->boolean('notification_sent')->default(false);
                $table->integer('priority')->default(0);
                $table->timestamps();
                
                $table->index(['user_id', 'status']);
                $table->index(['book_id', 'status']);
            });
        }

        if (!Schema::hasTable('collections')) {
            Schema::create('collections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('name');
                $table->string('slug')->unique();
                $table->text('description')->nullable();
                $table->string('cover_image')->nullable();
                $table->boolean('is_public')->default(false);
                $table->boolean('is_featured')->default(false);
                $table->integer('follower_count')->default(0);
                $table->integer('view_count')->default(0);
                $table->timestamps();
                
                $table->index(['user_id', 'is_public']);
                $table->index('slug');
            });
        }

        if (!Schema::hasTable('user_favorites')) {
            Schema::create('user_favorites', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('book_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                
                $table->unique(['user_id', 'book_id']);
                $table->index('user_id');
                $table->index('book_id');
            });
        }

        if (!Schema::hasTable('user_reading_lists')) {
            Schema::create('user_reading_lists', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->foreignId('book_id')->constrained()->onDelete('cascade');
                $table->integer('priority')->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->unique(['user_id', 'book_id']);
                $table->index(['user_id', 'priority']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('user_reading_lists');
        Schema::dropIfExists('user_favorites');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('borrowings');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('profiles');
    }
};